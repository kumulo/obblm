<?php

namespace App\Service\TieBreaker;

use Doctrine\ORM\QueryBuilder;

class InjuryPlusTieBreak extends AbstractTieBreaker {

    const KEY = 'tiebreak.injury_give';

    public function updateTieBreakQuery(QueryBuilder $query)
    {
        return $query->addOrderBy('t.injury_give', 'ASC');
    }
}
