<?php
declare(strict_types=1);

namespace Sitegeist\ScentMark\Command;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;
use Neos\Cache\Frontend\StringFrontend;

class ScentMarkCommandController extends CommandController
{
    /**
     * @var StringFrontend
     * @Flow\Inject
     */
    protected $scentMarkCache;

    /**
     * @param string $scent
     * @return string
     * @throws \Neos\Cache\Exception
     * @throws \Neos\Cache\Exception\InvalidDataException
     */
    public function markCommand(string $scent)
    {
        $this->scentMarkCache->set('default', $scent);
        $this->outputLine(sprintf('Marked tree with "%s"', $scent));
    }

    /**
     * @param string $scent
     * @return string
     * @throws \Neos\Flow\Cli\Exception\StopCommandException
     */
    public function sniffCommand(string $scent)
    {
        $scentOnBark = $this->scentMarkCache->get('default', $scent);
        if ($scentOnBark && $scentOnBark == $scent) {
            $this->outputLine(sprintf( 'Scent on tree matched "%s"', $scent));
            $this->quit();
        } else {
            $this->outputLine(sprintf('Scent on tree "%s" did not match "%s"', $scentOnBark, $scent));
            $this->quit(1);
        }
    }
}
