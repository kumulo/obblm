<?php
// src/BbLigueBundle/Entity/Coach.php

namespace BbLigueBundle\Entity;

use BbLigueBundle\Model\Coach as BaseCoach;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_coach")
 */
class Coach extends BaseCoach
{
    public function getInvolvedLigues() {
        $result = array();
        foreach($this->teams as $team) {
            $result[] = $team->getLigue();
        }
        return new Collections\ArrayCollection($result);
    }
}
