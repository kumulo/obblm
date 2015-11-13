<?php
// src/BbLeagueBundle/Entity/TeamByJourney.php

namespace BbLeagueBundle\Entity;

use BbLeagueBundle\Model\TeamByJourney as BaseTeamByJourney;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Criteria;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="bbl_team_by_journey")
 */
class TeamByJourney extends BaseTeamByJourney
{
    protected $points = 0;
    protected $tr = 0;

    public function __construct() {
        parent::__construct();
    }
    public function getInjuredPlayers() {
        $injuredPlayers = array();
        $playerCollection = $this->getPlayers();
        foreach($playerCollection as $player) {
            if(in_array("M", $player->getInjuries())) {
                $injuredPlayers[] = $player;
            }
        }

        return $injuredPlayers;
    }

    public function getAvailaiblePlayers() {
        $playerCollection = $this->getPlayers();
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("dismiss", false))
            ->where(Criteria::expr()->eq("dead", false))
            ->orderBy(array("id" => Criteria::ASC))
        ;
        $availaiblePlayers = $playerCollection->matching($criteria);
        return $availaiblePlayers;
    }

    public function getBasePlayers() {
        $playerCollection = $this->getAvailaiblePlayers();
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("journeyman", false))
            ->orderBy(array("id" => Criteria::ASC))
        ;
        $basePlayers = $playerCollection->matching($criteria);
        return $basePlayers;
    }

    public function getJourneyMen() {
        $playerCollection = $this->getAvailaiblePlayers();
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("journeyman", true))
            ->orderBy(array("id" => Criteria::ASC))
        ;
        $journeyMen = $playerCollection->matching($criteria);
        return $journeyMen;
    }

    public function calculatePoints()
    {
        $league = $this->team->getLeague();
        $this->points = 0;

        $this->points += $this->win_match  * $league->getPointsForWin();
        $this->points += $this->draw_match * $league->getPointsForDraw();
        $this->points += $this->lost_match * $league->getPointsForLost();
    }

    public function getRosterRules()
    {
        $lrule = $this->getJourney()->getLeague()->getRule();
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
        $injuredPlayers = $this->getInjuredPlayers();
        foreach($this->getAvailaiblePlayers() as $player) {
            if(!in_array($player, $injuredPlayers)) $value += $player->getValue();
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

    public function toArray()
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
