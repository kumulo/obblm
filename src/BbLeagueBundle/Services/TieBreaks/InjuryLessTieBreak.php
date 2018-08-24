<?php

namespace BbLeagueBundle\Services\TieBreaks;

class InjuryLessTieBreak extends TieBreak {

    public function updateTieBreakQuery($query) {
        return $query->addOrderBy('injury_taken', 'DESC');
    }
    public function getName() {
        return 'tiebreak.injury.taken';
    }
}
