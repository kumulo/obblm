<?php
// src/BbLigueBundle/Entity/TeamByJourney.php

namespace BbLigueBundle\Entity;

use BbLigueBundle\Model\TeamByJourney as BaseTeamByJourney;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_team_by_journey")
 */
class TeamByJourney extends BaseTeamByJourney
{
    
}