<?php

namespace BbLeagueBundle\Services\TieBreaks;

use Doctrine\ORM\QueryBuilder;

class InjuryPlusTieBreak extends TieBreak {

    public function updateTieBreakQuery(QueryBuilder $query)
    {
        return $query->addOrderBy('t.injury_give', 'ASC');
    }

    public function getName() {
        return 'tiebreak.injury.given';
    }
}
