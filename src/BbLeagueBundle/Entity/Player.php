<?php
// src/BbLeagueBundle/Entity/Player.php

namespace BbLeagueBundle\Entity;

use BbLeagueBundle\Model\Player as BasePlayer;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_player")
 */
class Player extends BasePlayer
{

}
