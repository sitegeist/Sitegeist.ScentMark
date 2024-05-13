<?php
declare(strict_types=1);

namespace Sitegeist\ScentMark\Command;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;
use Sitegeist\ScentMark\Domain\Model\Scent;
use Sitegeist\ScentMark\Domain\Repository\ScentRepository;

class ScentMarkCommandController extends CommandController
{
    #[Flow\Inject]
    protected ScentRepository $scentRepository;

    public function markCommand(string $scent): void
    {
        $scentEntity = $this->scentRepository->findOneByValue($scent);
        if ($scentEntity instanceof Scent) {
            $this->outputLine(sprintf('Scent on tree did already contain "%s"', $scent));
            $this->quit(1);
        } else {
            $scentEntity = new Scent();
            $scentEntity->setValue($scent);
            $this->scentRepository->add($scentEntity);
            $this->outputLine(sprintf('Marked tree with "%s"', $scent));
        }
    }

    public function sniffCommand(string $scent): void
    {
        $scentEntity = $this->scentRepository->findOneByValue($scent);
        if ($scentEntity instanceof Scent) {
            $this->outputLine(sprintf( 'Scent on tree contains scent "%s" since "%s"', $scent, $scentEntity->getDateTime()?->format('y-m-d H:i:s')));
            $this->quit();
        } else {
            $this->outputLine(sprintf('Scent on tree did not contain "%s"', $scent));
            $this->quit(1);
        }
    }

    public function cleanupCommand(int $keep): void
    {
        $removed = $this->scentRepository->removeByAge($keep);
        $this->outputLine(sprintf( '%d scents were removed', $removed));
    }
}
