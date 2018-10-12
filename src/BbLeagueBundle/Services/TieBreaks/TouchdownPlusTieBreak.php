<?php

namespace BbLeagueBundle\Services\TieBreaks;

use Doctrine\ORM\QueryBuilder;

class TouchdownPlusTieBreak extends TieBreak {

    public function updateTieBreakQuery(QueryBuilder $query)
    {
        return $query->addOrderBy('t.td_give', 'ASC');
    }

    public function getName() {
        return 'tiebreak.touchdown.scored';
    }
}
