<?php
// src/BbLeagueBundle/Model/PlayerByJourney.php

/*
 * PlayerByJourney has a Player
 * PlayerByJourney has a TeamByJourney
 */

namespace BbLeagueBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\MappedSuperclass */
class PlayerByJourney
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="BbLeagueBundle\Entity\Player", inversedBy="journeys", cascade={"persist"})
     */
    protected $player;

    /**
     * @ORM\ManyToOne(targetEntity="BbLeagueBundle\Entity\TeamByJourney", inversedBy="players", cascade={"persist"})
     */
    protected $journey;

    /**
     * @ORM\Column(name="ma", type="integer", length=2)
     * @Assert\NotBlank()
     */
    protected $move;

    /**
     * @ORM\Column(name="st", type="integer", length=2)
     * @Assert\NotBlank()
     */
    protected $strenght;

    /**
     * @ORM\Column(name="ag", type="integer", length=2)
     * @Assert\NotBlank()
     */
    protected $agility;

    /**
     * @ORM\Column(name="av", type="integer", length=2)
     * @Assert\NotBlank()
     */
    protected $average;

    /**
     * @ORM\Column(name="skills", type="array")
     */
    protected $skills;

    /**
     * @ORM\Column(name="injuries", type="array")
     */
    protected $injuries;

    /**
     * @ORM\Column(name="com", type="integer", length=3)
     * @Assert\NotBlank()
     */
    protected $completions;

    /**
     * @ORM\Column(name="td", type="integer", length=3)
     * @Assert\NotBlank()
     */
    protected $touchdowns;

    /**
     * @ORM\Column(name="inter", type="integer", length=3)
     * @Assert\NotBlank()
     */
    protected $interceptions;

    /**
     * @ORM\Column(name="cas", type="integer", length=3)
     * @Assert\NotBlank()
     */
    protected $casualties;

    /**
     * @ORM\Column(name="mvp", type="integer", length=3)
     * @Assert\NotBlank()
     */
    protected $mvps;

    /**
     * @ORM\Column(name="value", type="integer", length=8)
     * @Assert\NotBlank()
     */
    protected $value;

    /**
     * @ORM\Column(name="dead", type="boolean")
     */
    protected $dead;

    /**
     * @ORM\Column(name="dismiss", type="boolean")
     */
    protected $dismiss;


    public function __construct() {
        $this->move             = 0;
        $this->strenght         = 0;
        $this->agility          = 0;
        $this->average          = 0;
        $this->skills           = array();
        $this->injuries         = array();
        $this->completions      = 0;
        $this->touchdowns       = 0;
        $this->interceptions    = 0;
        $this->casualties       = 0;
        $this->mvps             = 0;
        $this->value            = 0;
        $this->dead             = 0;
        $this->dismiss          = 0;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set move
     *
     * @param integer $move
     *
     * @return PlayerByJourney
     */
    public function setMove($move)
    {
        $this->move = $move;

        return $this;
    }

    /**
     * Get move
     *
     * @return integer
     */
    public function getMove()
    {
        return $this->move;
    }

    /**
     * Set strenght
     *
     * @param integer $strenght
     *
     * @return PlayerByJourney
     */
    public function setStrenght($strenght)
    {
        $this->strenght = $strenght;

        return $this;
    }

    /**
     * Get strenght
     *
     * @return integer
     */
    public function getStrenght()
    {
        return $this->strenght;
    }

    /**
     * Set agility
     *
     * @param integer $agility
     *
     * @return PlayerByJourney
     */
    public function setAgility($agility)
    {
        $this->agility = $agility;

        return $this;
    }

    /**
     * Get agility
     *
     * @return integer
     */
    public function getAgility()
    {
        return $this->agility;
    }

    /**
     * Set average
     *
     * @param integer $average
     *
     * @return PlayerByJourney
     */
    public function setAverage($average)
    {
        $this->average = $average;

        return $this;
    }

    /**
     * Get average
     *
     * @return integer
     */
    public function getAverage()
    {
        return $this->average;
    }

    /**
     * Set player
     *
     * @param \BbLeagueBundle\Entity\Player $player
     *
     * @return PlayerByJourney
     */
    public function setPlayer(\BbLeagueBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \BbLeagueBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set journey
     *
     * @param \BbLeagueBundle\Entity\TeamByJourney $journey
     *
     * @return PlayerByJourney
     */
    public function setJourney(\BbLeagueBundle\Entity\TeamByJourney $journey = null)
    {
        $this->journey = $journey;

        return $this;
    }

    /**
     * Get journey
     *
     * @return \BbLeagueBundle\Entity\TeamByJourney
     */
    public function getJourney()
    {
        return $this->journey;
    }

    /**
     * Set skills
     *
     * @param array $skills
     *
     * @return PlayerByJourney
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;

        return $this;
    }

    /**
     * Get skills
     *
     * @return array
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * Set injuries
     *
     * @param array $injuries
     *
     * @return PlayerByJourney
     */
    public function setInjuries($injuries)
    {
        $this->injuries = $injuries;

        return $this;
    }

    /**
     * Get injuries
     *
     * @return array
     */
    public function getInjuries()
    {
        return $this->injuries;
    }

    /**
     * Set completions
     *
     * @param integer $completions
     *
     * @return PlayerByJourney
     */
    public function setCompletions($completions)
    {
        $this->completions = $completions;

        return $this;
    }

    /**
     * Get completions
     *
     * @return integer
     */
    public function getCompletions()
    {
        return $this->completions;
    }

    /**
     * Set touchdowns
     *
     * @param integer $touchdowns
     *
     * @return PlayerByJourney
     */
    public function setTouchdowns($touchdowns)
    {
        $this->touchdowns = $touchdowns;

        return $this;
    }

    /**
     * Get touchdowns
     *
     * @return integer
     */
    public function getTouchdowns()
    {
        return $this->touchdowns;
    }

    /**
     * Set interceptions
     *
     * @param integer $interceptions
     *
     * @return PlayerByJourney
     */
    public function setInterceptions($interceptions)
    {
        $this->interceptions = $interceptions;

        return $this;
    }

    /**
     * Get interceptions
     *
     * @return integer
     */
    public function getInterceptions()
    {
        return $this->interceptions;
    }

    /**
     * Set casualties
     *
     * @param integer $casualties
     *
     * @return PlayerByJourney
     */
    public function setCasualties($casualties)
    {
        $this->casualties = $casualties;

        return $this;
    }

    /**
     * Get casualties
     *
     * @return integer
     */
    public function getCasualties()
    {
        return $this->casualties;
    }

    /**
     * Set mvps
     *
     * @param integer $mvps
     *
     * @return PlayerByJourney
     */
    public function setMvps($mvps)
    {
        $this->mvps = $mvps;

        return $this;
    }

    /**
     * Get mvps
     *
     * @return integer
     */
    public function getMvps()
    {
        return $this->mvps;
    }

}
