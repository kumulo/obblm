<?php
// src/BbLigueBundle/Entity/PlayerByJourney.php

namespace BbLigueBundle\Entity;

use BbLigueBundle\Model\PlayerByJourney as BasePlayerByJourney;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_player_by_journey")
 */
class PlayerByJourney extends BasePlayerByJourney
{

}
