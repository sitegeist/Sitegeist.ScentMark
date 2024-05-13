<?php
declare(strict_types=1);

namespace Sitegeist\ScentMark\Domain\Model;

use Neos\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 * @ORM\Table(
 *     uniqueConstraints={
 *       @ORM\UniqueConstraint(name="unique_values",columns={"value"}),
 *     },
 *     indexes={
 *       @ORM\Index(name="index_values",columns={"value"}),
 *     }
 *  )
 */
class Scent
{

    /**
     * @var string
     */
    protected $value;

    /**
     * @var \DateTime
     */
    protected $dateTime;

    public function __construct()
    {
        $this->dateTime = new \DateTime();
        $this->value = '';
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTime $dateTime): void
    {
        $this->dateTime = $dateTime;
    }
}
