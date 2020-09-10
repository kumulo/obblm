<?php

namespace BBlm\Service\TieBreaker;

use Doctrine\ORM\QueryBuilder;

class TouchdownPlusTieBreak extends AbstractTieBreaker {

    const KEY = 'tiebreak.td_give';

    public function updateTieBreakQuery(QueryBuilder $query)
    {
        return $query->addOrderBy('t.td_give', 'DESC');
    }
    public function getOrderingForCriteria():array
    {
        return ['td_give' => 'DESC'];
    }
}
