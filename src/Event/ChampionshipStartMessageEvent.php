<?php

namespace BBlm\Event;

use BBlm\Entity\Championship;
use BBlm\Entity\Coach;
use Symfony\Contracts\EventDispatcher\Event;

class ChampionshipStartMessageEvent extends Event {
    public const NAME = 'championship.start.send';

    protected $coach;
    protected $championship;

    /**
     * SendInvitationMessageEvent constructor.
     * @param $coach Coach
     * @param $championship Championship
     */
    public function __construct(Coach $coach, Championship $championship)
    {
        $this->coach = $coach;
        $this->championship = $championship;
    }

    public function getCoach()
    {
        return $this->coach;
    }

    public function getChampionship()
    {
        return $this->championship;
    }
}