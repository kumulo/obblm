<?php

namespace BbLeagueBundle\Services\TieBreaks;

use Doctrine\ORM\QueryBuilder;

class VictoryTieBreak extends TieBreak {

    public function updateTieBreakQuery(QueryBuilder $query)
    {
        return $query->addOrderBy('t.win_encounter', 'ASC');
    }

    public function getName() {
        return 'tiebreak.victory';
    }
}
