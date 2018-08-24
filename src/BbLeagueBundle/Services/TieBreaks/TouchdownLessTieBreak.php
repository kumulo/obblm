<?php

namespace BbLeagueBundle\Services\TieBreaks;

class TouchdownLessTieBreak extends TieBreak {

    public function updateTieBreakQuery($query) {
        return $query->addOrderBy('touchdown_taken', 'DESC');
    }
    public function getName() {
        return 'tiebreak.touchdown.taken';
    }
}
