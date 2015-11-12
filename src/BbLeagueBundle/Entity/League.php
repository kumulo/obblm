<?php
// src/BbLeagueBundle/Entity/League.php

namespace BbLeagueBundle\Entity;

use BbLeagueBundle\Model\League as BaseLeague;
use Doctrine\ORM\Mapping as ORM;
use BbLeagueBundle\Entity\Team;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_league")
 */
class League extends BaseLeague
{
    public function getTeams() {
        $teams = $this->teams;
        $iterator = $teams->getIterator();
        $iterator->uasort(function (Team $a, Team $b) {
            return ($a->getId() < $b->getId()) ? -1 : 1;
        });
        $r = array();
        foreach(iterator_to_array($iterator) as $team) {
            $key = $team->getLastJourney()->getPoints().'-'.$team->getLastJourney()->getTdGive().'-'.$team->getLastJourney()->getTR().'-'.$team->getId();
            $r[$key] = $team;
        }
        krsort($r);

        return $r;
    }
}
