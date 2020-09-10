<?php

namespace BBlm\Service\ChampionshipFormat;

use BBlm\Entity\Championship;
use BBlm\Entity\Team;

class JourneyChampionshipFormat extends AbstractChampionshipFormat implements ChampionshipFormatInterface {

    const FORMAT = 'format.championship';

    public function validateTeamForChampionship(Championship $championship, Team $team):bool {
        if(!$team instanceof Team || !$championship instanceof Championship) {
            return false;
        }

        return true;
    }
}