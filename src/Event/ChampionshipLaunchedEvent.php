<?php

namespace BBlm\Event;

use BBlm\Entity\Championship;
use Symfony\Contracts\EventDispatcher\Event;

class ChampionshipLaunchedEvent extends Event {
    public const NAME = 'championship.launched';

    protected $championship;

    public function __construct(Championship $championship)
    {
        $this->championship = $championship;
    }

    public function getChampionship()
    {
        return $this->championship;
    }
}