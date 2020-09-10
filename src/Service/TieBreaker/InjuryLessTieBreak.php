<?php

namespace BBlm\Service\TieBreaker;

use Doctrine\ORM\QueryBuilder;

class InjuryLessTieBreak extends AbstractTieBreaker {

    const KEY = 'tiebreak.injury_take';

    public function updateTieBreakQuery(QueryBuilder $query)
    {
        return $query->addOrderBy('t.injury_take', 'DESC');
    }
    public function getOrderingForCriteria():array
    {
        return ['injury_take' => 'DESC'];
    }
}
