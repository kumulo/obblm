<?php

namespace BBlm\Service;

use BBlm\Entity\Championship;
use BBlm\Entity\Team;
use BBlm\Service\Rule\RuleInterface;

class BblmContextualizer {
    protected $rule;
    protected $championship;
    protected $team;

    public function __construct() {}

    public function getRule():?RuleInterface {
        return $this->rule;
    }

    public function setRule(RuleInterface $rule) {
        $this->rule = $rule;
    }

    public function getChampionship():?Championship {
        return $this->championship;
    }

    public function setChampionship(Championship $championship) {
        $this->championship = $championship;
    }

    public function getTeam():?Team {
        return $this->team;
    }

    public function setteam(Team $team) {
        $this->team = $team;
    }
}