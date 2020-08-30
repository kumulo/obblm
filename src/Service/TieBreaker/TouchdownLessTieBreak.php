<?php

namespace App\Service\TieBreaker;

use Doctrine\ORM\QueryBuilder;

class TouchdownLessTieBreak extends AbstractTieBreaker {

    const KEY = 'tiebreak.td_take';

    public function updateTieBreakQuery(QueryBuilder $query)
    {
        return $query->addOrderBy('t.td_take', 'DESC');
    }
}
