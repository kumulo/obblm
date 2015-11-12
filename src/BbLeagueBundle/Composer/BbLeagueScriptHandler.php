<?php
namespace BbLeagueBundle\Composer;

use Composer\Script\CommandEvent;
use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler;

class BbLeagueScriptHandler extends ScriptHandler
{
    /**
     * @param $event CommandEvent A instance
     */
    public static function initBundle(CommandEvent $event)
    {
        $options = parent::getOptions($event);
        $appDir = $options['symfony-app-dir'];

        parent::executeCommand(
            $event,
            $appDir,
            'bbleague:media:init'
        );
    }
}
