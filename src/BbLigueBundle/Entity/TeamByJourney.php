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
    protected $points = 0;
    
    public function getPoints()
    {
        $ligue = $this->team->getLigue();
        $this->points = 0;

        $this->points += $this->win_match  * $ligue->getPointsForWin();
        $this->points += $this->draw_match * $ligue->getPointsForDraw();
        $this->points += $this->lost_match * $ligue->getPointsForLost();

        return $this->points;
    }
}
