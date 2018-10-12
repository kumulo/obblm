<?php

namespace BbLeagueBundle\Services\TieBreaks;

use Doctrine\ORM\QueryBuilder;

class InjuryLessTieBreak extends TieBreak {

    public function updateTieBreakQuery(QueryBuilder $query)
    {
        return $query->addOrderBy('t.injury_take', 'DESC');
    }

    public function getName() {
        return 'tiebreak.injury.taken';
    }
}
