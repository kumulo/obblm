<?php
// src/BbLigueBundle/Entity/Player.php

namespace BbLigueBundle\Entity;

use BbLigueBundle\Model\Player as BasePlayer;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_player")
 */
class Player extends BasePlayer
{
    
}
