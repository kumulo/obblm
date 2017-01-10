<?php
namespace BbLeagueBundle\Composer;

use Composer\Script\Event;
use Sensio\Bundle\DistributionBundle\Composer\ScriptHandler;

class BbLeagueScriptHandler extends ScriptHandler
{
    /**
     * @param $event CommandEvent A instance
     */
    public static function initBundle(Event $event)
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
