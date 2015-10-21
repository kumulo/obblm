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

    public function __toArray()
    {
        return array(
            'id'            => $this->id,
            'name'          => $this->journey->getName(),
            'points'        => $this->getPoints(),
            'win_match'     => $this->win_match,
            'draw_match'    => $this->draw_match,
            'lost_match'    => $this->lost_match,
            'td_give'       => $this->td_give,
            'td_take'       => $this->td_take,
            'injury_give'   => $this->injury_give,
            'injury_take'   => $this->injury_take,
            'pass'          => $this->pass,
            'red_card'      => $this->red_card,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
        );
    }
}
