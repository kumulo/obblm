<?php

namespace App\Service\TieBreaker;

use Doctrine\ORM\QueryBuilder;

class VictoryTieBreak extends AbstractTieBreaker {

    const KEY = 'tiebreak.win_encounter';

    public function updateTieBreakQuery(QueryBuilder $query)
    {
        return $query->addOrderBy('t.win_encounter', 'ASC');
    }
}
