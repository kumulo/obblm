<?php
// src/BbLigueBundle/Entity/TeamByJourney.php

namespace BbLigueBundle\Entity;

use BbLigueBundle\Model\TeamByJourney as BaseTeamByJourney;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_team_by_journey")
 */
class TeamByJourney extends BaseTeamByJourney
{
    protected $points = 0;
    protected $tr = 0;
    
    public function __construct() {
        parent::__construct();
    }

    public function getAvailaiblePlayers() {
        $playerCollection = $this->getPlayers();
        //TODO : Ajouter le test sur le tableau des blessures
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("dead", "0"))
            ->where(Criteria::expr()->eq("dismiss", "0"))
            ->orderBy(array("id" => Criteria::ASC))
        ;
        $availaiblePlayers = $playerCollection->matching($criteria);
        return $availaiblePlayers;
    }

    public function calculatePoints()
    {
        $ligue = $this->team->getLigue();
        $this->points = 0;

        $this->points += $this->win_match  * $ligue->getPointsForWin();
        $this->points += $this->draw_match * $ligue->getPointsForDraw();
        $this->points += $this->lost_match * $ligue->getPointsForLost();
    }

    public function getRosterRules()
    {
        $lrule = $this->getJourney()->getLigue()->getRule();
        dump($lrule);

        $rule = $lrule['rosters'];
        return $rule;
    }

    public function getPoints()
    {
        if($this->points == 0) $this->calculatePoints();
        return $this->points;
    }

    public function getRerollsValue()
    {
        return $this->rerolls * $this->getTeam()->getBaseRerollValue();
    }

    public function getPopularityValue()
    {
        return $this->popularity * 10000;
    }

    public function getAssistantsValue()
    {
        return $this->assistants * 10000;
    }

    public function getCheerleadersValue()
    {
        return $this->cheerleaders * 10000;
    }

    public function getApothecaryValue()
    {
        return $this->apothecary * 50000;
    }

    public function calculateTR()
    {
        $value = 0;
        foreach($this->getAvailaiblePlayers() as $player) {
            $value += $player->getValue();
        }

        $value += $this->getRerollsValue();
        $value += $this->getPopularityValue();
        $value += $this->getAssistantsValue();
        $value += $this->getCheerleadersValue();
        $value += $this->getApothecaryValue();

        $this->tr = $value / 10000;
    }

    public function getTR()
    {
        if($this->tr == 0) $this->calculateTR();
        return $this->tr;
    }

    public function __toArray()
    {
        return array(
            'id'            => $this->id,
            'name'          => $this->journey->getName(),
            'rerolls'       => $this->rerolls,
            'tr'            => $this->getTR(),
            'treasure'      => $this->treasure,
            'apothecary'    => $this->apothecary,
            'popularity'    => $this->popularity,
            'assistants'    => $this->assistants,
            'cheerleaders'  => $this->cheerleaders,
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
