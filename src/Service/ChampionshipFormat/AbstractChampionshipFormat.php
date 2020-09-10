<?php

namespace BBlm\Service\ChampionshipFormat;

use BBlm\Entity\Championship;
use BBlm\Entity\Encounter;
use BBlm\Entity\Journey;
use BBlm\Entity\Team;
use BBlm\Entity\TeamVersion;
use BBlm\Traits\ClassNameAsKeyTrait;
use DateTime;

abstract class AbstractChampionshipFormat {
    use ClassNameAsKeyTrait;

    const FORMAT = 'format.default';
    const ENDS_WITH_PLAYOFF = true;

    public function getKey():string
    {
        return get_class($this)::FORMAT;
    }

    public function getFormat():string
    {
        return get_class($this)::FORMAT;
    }
    public function onLaunched(Championship $championship):Championship {
        return $championship;
    }
    public function onEncounterValidate(Championship $championship, Encounter $encounter):Championship {
        return $championship;
    }
    public function onJourneyClose(Championship $championship, Journey $journey):Championship {
        return $championship;
    }
    public function canAddNewEncounter(Championship $championship, Team $team):bool {
        return false;
    }
    public function validateEncounter(Encounter $encounter):Encounter {
        return $encounter->setValidatedAt(new DateTime());
    }
    public function setWinnerAndLoser(Encounter $encounter, TeamVersion $home, TeamVersion $visitor):Encounter {
        return $encounter;
    }
    public function getOrderedTeamsWithTieBreaks(Championship $championship) {
        return [];
    }
    public function getOpenedEncounter(Team $team):?Encounter {
        return null;
    }
    public function getOrderedTeams(Championship $championship) {
        return [];
    }
}