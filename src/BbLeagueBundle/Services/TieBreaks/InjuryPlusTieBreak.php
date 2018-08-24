<?php

namespace BbLeagueBundle\Services\TieBreaks;

class InjuryPlusTieBreak extends TieBreak {

    public function updateTieBreakQuery($query) {
        return $query->addOrderBy('injury_given', 'ASC');
    }
    public function getName() {
        return 'tiebreak.injury.given';
    }
}
