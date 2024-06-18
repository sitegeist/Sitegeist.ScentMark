<?php
declare(strict_types=1);

namespace Sitegeist\ScentMark\Domain\Model;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 * @ORM\Table(
 *     uniqueConstraints={
 *       @ORM\UniqueConstraint(name="unique_values",columns={"packScent"}),
 *     },
 *     indexes={
 *       @ORM\Index(name="index_values",columns={"packScent"}),
 *     }
 *  )
 */
class Pack
{

    /**
     * @var string
     */
    protected $packScent;

    /**
     * @var string
     * @ORM\Column(nullable=true)
     */
    protected $leaderScent;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(nullable=true)
     */
    protected $leadExpiration;

    /**
     * @var \DateTimeImmutable
     */
    protected $dateTime;

    public function __construct()
    {
        $this->dateTime = new \DateTimeImmutable();
        $this->packScent = '';
    }

    public function getPackScent(): string
    {
        return $this->packScent;
    }

    public function setPackScent(string $packScent): void
    {
        $this->packScent = $packScent;
    }

    public function getDateTime(): \DateTimeImmutable
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTimeImmutable $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

    public function getLeaderScent(): ?string
    {
        return $this->leaderScent;
    }

    public function setLeaderScent(?string $leaderScent): void
    {
        $this->leaderScent = $leaderScent;
    }

    public function getLeadExpiration(): ?\DateTimeImmutable
    {
        return $this->leadExpiration;
    }

    public function setLeadExpiration(?\DateTimeImmutable $leadExpiration): void
    {
        $this->leadExpiration = $leadExpiration;
    }

    public function getCurrentlyActiveLeaderScent(): ?string
    {
        if (
            $this->leaderScent !== null
            && $this->leadExpiration instanceof \DateTimeImmutable
            && $this->leadExpiration->getTimestamp() > time()
        ) {
            return $this->leaderScent;
        }
        return null;
    }

    public function setCurrentlyActiveLeaderScent(string $leaderScent): void
    {
        if ($this->getCurrentlyActiveLeaderScent() !== null) {
            throw new \Exception('Already has a leader');
        }
        $this->leaderScent = $leaderScent;
        $this->leadExpiration = (new \DateTimeImmutable())->modify('+1 hour');
    }
}
