<?php
// src/BbLigueBundle/Entity/Ligue.php

namespace BbLigueBundle\Entity;

use BbLigueBundle\Model\Ligue as BaseLigue;
use Doctrine\ORM\Mapping as ORM;
use BbLigueBundle\Entity\Team;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_ligue")
 */
class Ligue extends BaseLigue
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
