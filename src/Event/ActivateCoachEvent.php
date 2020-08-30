<?php

namespace App\Event;

use App\Entity\Coach;
use Symfony\Contracts\EventDispatcher\Event;

class ActivateCoachEvent extends Event {
    public const NAME = 'coach.activation';

    protected $coach;

    public function __construct(Coach $coach)
    {
        $this->coach = $coach;
    }

    public function getCoach()
    {
        return $this->coach;
    }
}