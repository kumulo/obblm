<?php

namespace BbLeagueBundle\Services\TieBreaks;

use Doctrine\ORM\QueryBuilder;

class TouchdownLessTieBreak extends TieBreak {

    public function updateTieBreakQuery(QueryBuilder $query)
    {
        return $query->addOrderBy('t.td_take', 'DESC');
    }

    public function getName() {
        return 'tiebreak.touchdown.taken';
    }
}
