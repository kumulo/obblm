<?php

namespace BbLeagueBundle\Services\TieBreaks;

class VictoryTieBreak extends TieBreak {

    public function updateTieBreakQuery($query) {
        return $query->addOrderBy('victory', 'ASC');
    }
    public function getName() {
        return 'tiebreak.victory';
    }
}
