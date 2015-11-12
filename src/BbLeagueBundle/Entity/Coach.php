<?php
// src/BbLeagueBundle/Entity/Coach.php

namespace BbLeagueBundle\Entity;

use BbLeagueBundle\Model\Coach as BaseCoach;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_coach")
 */
class Coach extends BaseCoach
{
    public function getInvolvedLeagues() {
        $result = array();
        foreach($this->teams as $team) {
            $result[] = $team->getLeague();
        }
        return new Collections\ArrayCollection($result);
    }
}
