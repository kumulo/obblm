<?php

namespace BbLeagueBundle\Services\TieBreaks;

class TouchdownPlusTieBreak extends TieBreak {

    public function updateTieBreakQuery($query) {
        return $query->addOrderBy('touchdown_scored', 'ASC');
    }
    public function getName() {
        return 'tiebreak.touchdown.scored';
    }
}
