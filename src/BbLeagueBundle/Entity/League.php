<?php
// src/BbLeagueBundle/Entity/League.php

namespace BbLeagueBundle\Entity;

use BbLeagueBundle\Model\League as BaseLeague;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="BbLeagueBundle\Repository\LeagueRepository")
 * @ORM\Table(name="bbl_league")
 */
class League extends BaseLeague
{
    public function getTeams() {
        $teams = $this->teams;
        $iterator = $teams->getIterator();
        $iterator->uasort(function (Team $a, Team $b) {
            return ($a->getLastJourney()->getPoints() > $b->getLastJourney()->getPoints()) ? -1 : 1;
        });
        $r = new ArrayCollection(iterator_to_array($iterator));
        return $r;
    }
}
