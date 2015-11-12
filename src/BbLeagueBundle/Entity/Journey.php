<?php
// src/BbLeagueBundle/Entity/Journey.php

namespace BbLeagueBundle\Entity;

use BbLeagueBundle\Model\Journey as BaseJourney;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_journey")
 */
class Journey extends BaseJourney
{

}
