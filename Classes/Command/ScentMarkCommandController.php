<?php
declare(strict_types=1);

namespace Sitegeist\ScentMark\Command;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;
use Sitegeist\ScentMark\Domain\Model\Pack;
use Sitegeist\ScentMark\Domain\Repository\PackRepository;

class ScentMarkCommandController extends CommandController
{
    #[Flow\Inject]
    protected PackRepository $scentRepository;

    /**
     * Mark the current deployment with the pack scent.
     *
     * Returns status code 0 if the pack was new and successfully marked
     * Returns status code 1 if the pack was already known beforehand
     *
     * @param string $packScent
     */
    public function markCommand(string $packScent): void
    {
        $packEntity = $this->scentRepository->findOneByPackScent($packScent);
        if ($packEntity instanceof Pack) {
            $this->outputLine(sprintf('Pack with scent "%s" is already known', $packScent));
            $this->quit(1);
        } else {
            $packEntity = new Pack();
            $packEntity->setPackScent($packScent);
            $this->scentRepository->add($packEntity);
            $this->outputLine(sprintf('New pack with scent "%s" was detected.', $packScent));
        }
    }


    /**
     * Select pack leader by passing packScent and leaderScent. If no leader is currently elected the first one asking
     * for the role is granted leader status for one hour
     *
     * Returns status code 0 if the $packScent and $leaderScent match and the current pod is considered leader for a time
     * Returns status code 1 if the current pod is not the leader for now
     *
     * @param string $packScent
     * @param string $leaderScent
     */
    public function barkCommand(string $packScent, string $leaderScent): void
    {
        /**
         * @var Pack $pack
         */
        $pack = $this->scentRepository->findOneByPackScent($packScent);
        if (!$pack instanceof Pack) {
            $this->outputLine(sprintf('Pack "%s" not found"', $packScent));
            $this->quit(1);
        }

        $currentLeaderScent = $pack->getCurrentlyActiveLeaderScent();

        if ($currentLeaderScent === $leaderScent) {
            $this->outputLine(sprintf('Pack "%s" has EXISTING leader %s"', $packScent, $leaderScent));
            $this->quit(0);
        } elseif ($currentLeaderScent === null) {
            $pack->setCurrentlyActiveLeaderScent($leaderScent);
            $this->scentRepository->update($pack);
            $this->outputLine(sprintf('Pack "%s" has NEW leader "%s"', $packScent, $leaderScent));
            $this->quit(0);
        } else {
            $this->outputLine(sprintf( 'Pack "%s" has OTHER leader "%s" which is not "%s"', $packScent, $currentLeaderScent, $leaderScent));
            $this->quit(1);
        }
    }

    /**
     * Remove the oldest packs but keep a specified number of items
     *
     * @param int $keep
     */
    public function cleanupCommand(int $keep): void
    {
        $removed = $this->scentRepository->removeByAge($keep);
        $this->outputLine(sprintf( '%d packs were removed', $removed));
    }
}
