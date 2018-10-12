<?php
// src/BbLeagueBundle/Entiy/Encounter.php

namespace BbLeagueBundle\Entity;

use BbLeagueBundle\Model\Encounter as BaseEncounter;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_encounter")
 */
class Encounter extends BaseEncounter
{

}
