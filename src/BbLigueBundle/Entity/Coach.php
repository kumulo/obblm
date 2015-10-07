<?php
// src/BbLigueBundle/Entity/Coach.php

namespace BbLigueBundle\Entity;

use BbLigueBundle\Model\Coach as BaseCoach;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_coach")
 */
class Coach extends BaseCoach
{
    
}