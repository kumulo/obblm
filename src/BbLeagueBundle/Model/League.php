<?php
// src/BbLeagueBundle/Model/League.php

/*
 * League has some Teams
 */

namespace BbLeagueBundle\Model;

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
     * Constructor
     */
    public function __construct()
    {
        $this->teams = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get pointsForLost
     *
     * @return integer
     */
    public function getPointsForLost()
    {
        return $this->points_for_lost;
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
}
