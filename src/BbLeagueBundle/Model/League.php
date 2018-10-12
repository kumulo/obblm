<?php
// src/BbLeagueBundle/Model/League.php

/*
 * League has some Teams
 */

namespace BbLeagueBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\MappedSuperclass */
class League
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="BbLeagueBundle\Entity\Team", mappedBy="league", cascade={"remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $teams;

    /**
     * @ORM\OneToMany(targetEntity="BbLeagueBundle\Entity\Journey", mappedBy="league", cascade={"remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $journeys;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(name="rule_key", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $rule;

    /**
     * @ORM\Column(name="format", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $format;

    /**
     * @ORM\Column(name="number_of_journeys", type="integer", length=5)
     * @Assert\NotBlank()
     */
    protected $number_of_journeys = 11;

    /**
     * @ORM\Column(name="number_for_playoff", type="integer", length=3)
     * @Assert\NotBlank()
     */
    protected $number_for_playoff = 8;

    /**
     * @ORM\Column(name="points_for_win", type="integer", length=2)
     * @Assert\NotBlank()
     */
    protected $points_for_win = 3;

    /**
     * @ORM\Column(name="points_for_draw", type="integer", length=2)
     * @Assert\NotBlank()
     */
    protected $points_for_draw = 1;

    /**
     * @ORM\Column(name="points_for_lost", type="integer", length=2)
     * @Assert\NotBlank()
     */
    protected $points_for_lost = 0;

    /**
     * @ORM\Column(name="tie_break_1", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $tie_break_1 = "";

    /**
     * @ORM\Column(name="tie_break_2", type="string", length=255)
     */
    protected $tie_break_2 = "";

    /**
     * @ORM\Column(name="tie_break_3", type="string", length=255)
     */
    protected $tie_break_3 = "";

    /**
     * @ORM\Column(name="valid", type="boolean")
     */
    protected $valid;

    /**
     * @ORM\OneToOne(targetEntity="BbLeagueBundle\Entity\Journey")
     * @ORM\JoinColumn(name="current_journey", referencedColumnName="id")
     */
    protected $current_journey;

    /**
     * @ORM\ManyToMany(targetEntity="BbLeagueBundle\Entity\Coach")
     * @ORM\JoinTable(name="bbl_league_commissioner",
     *      joinColumns={@ORM\JoinColumn(name="league_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="coach_id", referencedColumnName="id", unique=true)}
     *      )
     */
    protected $commissioners;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
        $this->valid = false;
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
     * Set name
     *
     * @param string $name
     *
     * @return League
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set format
     *
     * @param string $format
     *
     * @return League
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Set rule
     *
     * @param string $rule
     *
     * @return League
     */
    public function setRule($rule)
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * Get rule
     *
     * @return string
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Add team
     *
     * @param \BbLeagueBundle\Entity\Team $team
     *
     * @return League
     */
    public function addTeam(\BbLeagueBundle\Entity\Team $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \BbLeagueBundle\Entity\Team $team
     */
    public function removeTeam(\BbLeagueBundle\Entity\Team $team)
    {
        $this->teams->removeElement($team);
    }

    /**
     * Get teams
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeams()
    {
        return $this->teams;
    }

    /**
     * Set pointsForWin
     *
     * @param integer $pointsForWin
     *
     * @return League
     */
    public function setPointsForWin($pointsForWin)
    {
        $this->points_for_win = $pointsForWin;

        return $this;
    }

    /**
     * Get pointsForWin
     *
     * @return integer
     */
    public function getPointsForWin()
    {
        return $this->points_for_win;
    }

    /**
     * Set pointsForDraw
     *
     * @param integer $pointsForDraw
     *
     * @return League
     */
    public function setPointsForDraw($pointsForDraw)
    {
        $this->points_for_draw = $pointsForDraw;

        return $this;
    }

    /**
     * Get pointsForDraw
     *
     * @return integer
     */
    public function getPointsForDraw()
    {
        return $this->points_for_draw;
    }

    /**
     * Set pointsForLost
     *
     * @param integer $pointsForLost
     *
     * @return League
     */
    public function setPointsForLost($pointsForLost)
    {
        $this->points_for_lost = $pointsForLost;

        return $this;
    }

    /**
     * Get tie_break_1
     *
     * @return string
     */
    public function getTieBreak1()
    {
        return $this->tie_break_1;
    }

    /**
     * Set tie_break_1
     *
     * @param string $tie_break_1
     *
     * @return League
     */
    public function setTieBreak1($tie_break_1)
    {
        $this->tie_break_1 = $tie_break_1;

        return $this;
    }

    /**
     * Get tie_break_2
     *
     * @return string
     */
    public function getTieBreak2()
    {
        return $this->tie_break_2;
    }

    /**
     * Set tie_break_2
     *
     * @param string $tie_break_2
     *
     * @return League
     */
    public function setTieBreak2($tie_break_2)
    {
        $this->tie_break_2 = $tie_break_2;

        return $this;
    }

    /**
     * Get tie_break_3
     *
     * @return string
     */
    public function getTieBreak3()
    {
        return $this->tie_break_3;
    }

    /**
     * Set tie_break_3
     *
     * @param string $tie_break_3
     *
     * @return League
     */
    public function setTieBreak3($tie_break_3)
    {
        $this->tie_break_3 = $tie_break_3;

        return $this;
    }

    /**
     * Get pointsForLost
     *
     * @return integer
     */
    public function getPointsForLost()
    {
        return $this->points_for_lost;
    }

    /**
     * Set numberOfJourneys
     *
     * @param integer $numberOfJourneys
     *
     * @return League
     */
    public function setNumberOfJourneys($numberOfJourneys)
    {
        $this->number_of_journeys = $numberOfJourneys;

        return $this;
    }

    /**
     * Get numberOfJourneys
     *
     * @return integer
     */
    public function getNumberOfJourneys()
    {
        return $this->number_of_journeys;
    }

    /**
     * Set numberOfJourneys
     *
     * @param integer $numberOfJourneys
     *
     * @return League
     */
    public function setNumberForPlayoff($numberForPlayoff)
    {
        $this->number_for_playoff = $numberForPlayoff;

        return $this;
    }

    /**
     * Get numberOfJourneys
     *
     * @return integer
     */
    public function getNumberForPlayoff()
    {
        return $this->number_for_playoff;
    }

    /**
     * Set valid
     *
     * @param boolean $valid
     *
     * @return Team
     */
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get valid
     *
     * @return boolean
     */
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Set current_journey
     *
     * @param \BbLeagueBundle\Entity\Journey $journey
     *
     * @return Team
     */
    public function setCurrentJourney($journey)
    {
        $this->current_journey = $journey;

        return $this;
    }

    /**
     * Get current_journey
     *
     * @return \BbLeagueBundle\Entity\Journey
     */
    public function getCurrentJourney()
    {
        return $this->current_journey;
    }

    /**
     * Add journey
     *
     * @param \BbLeagueBundle\Entity\Journey $journey
     *
     * @return League
     */
    public function addJourney(\BbLeagueBundle\Entity\Journey $journey)
    {
        $this->journeys[] = $journey;

        return $this;
    }

    /**
     * Remove journey
     *
     * @param \BbLeagueBundle\Entity\Journey $journey
     */
    public function removeJourney(\BbLeagueBundle\Entity\Journey $journey)
    {
        $this->journeys->removeElement($journey);
    }

    /**
     * Get journeys
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJourneys()
    {
        return $this->journeys;
    }

    /**
     * Get tiebreaks
     *
     * @return ArrayCollection[]TieBreakInterface
     */
    public function getTieBreaks()
    {
        $tiebreaks = new ArrayCollection();
        if ($this->tie_break_1) {
            $tiebreaks->add($this->tie_break_1);
        }
        if ($this->tie_break_2) {
            $tiebreaks->add($this->tie_break_2);
        }
        if ($this->tie_break_3) {
            $tiebreaks->add($this->tie_break_3);
        }

        return $tiebreaks;
    }
}
