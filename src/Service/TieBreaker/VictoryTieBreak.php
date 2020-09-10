<?php

namespace BBlm\Service\TieBreaker;

use Doctrine\ORM\QueryBuilder;

class VictoryTieBreak extends AbstractTieBreaker {

    const KEY = 'tiebreak.win_encounter';

    public function updateTieBreakQuery(QueryBuilder $query)
    {
        return $query->addOrderBy('t.game_win', 'DESC');
    }
    public function getOrderingForCriteria():array
    {
        return ['game_win' => 'DESC'];
    }
}
