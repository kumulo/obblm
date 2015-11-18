<?php
// src/BbLeagueBundle/Model/Match.php

/*
 * Match has a Team
 * Match has a "visitor" Team
 */

namespace BbLeagueBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class Match
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="BbLeagueBundle\Entity\Team", inversedBy="matchs", cascade={"persist"})
     */
    protected $team;

    /**
     * @ORM\ManyToOne(targetEntity="BbLeagueBundle\Entity\Team", inversedBy="matchs_has_visitor", cascade={"persist"})
     */
    protected $visitor;

    /**
     * @ORM\ManyToOne(targetEntity="BbLeagueBundle\Entity\Journey", inversedBy="matchs", cascade={"persist"})
     */
    protected $journey;

    /**
     * @ORM\OneToMany(targetEntity="BbLeagueBundle\Entity\TeamByJourney", mappedBy="match", cascade={"remove"})
     */
    protected $teams_by_journey;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $weather;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $home_actions;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $visitor_actions;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $home_injuries;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $visitor_injuries;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $home_skills;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    protected $visitor_skills;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $home_dismiss;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    protected $visitor_dismiss;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $valid;

    public function __construct()
    {
        $this->teams_by_journey = new \Doctrine\Common\Collections\ArrayCollection();
        $this->valid            = 0;
        $this->home_actions     = array();
        $this->visitor_actions  = array();
        $this->home_injuries    = array();
        $this->visitor_injuries = array();
        $this->home_skills      = array();
        $this->visitor_skills   = array();
        $this->home_dismiss     = false;
        $this->visitor_dismiss  = false;
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
     * Set weather
     *
     * @param integer $weather
     *
     * @return Match
     */
    public function setWeather($weather)
    {
        $this->weather = $weather;

        return $this;
    }

    /**
     * Get weather
     *
     * @return integer
     */
    public function getWeather()
    {
        return $this->weather;
    }

    /**
     * Set team
     *
     * @param \BbLeagueBundle\Entity\Team $team
     *
     * @return Match
     */
    public function setTeam(\BbLeagueBundle\Entity\Team $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \BbLeagueBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set visitor
     *
     * @param \BbLeagueBundle\Entity\Team $visitor
     *
     * @return Match
     */
    public function setVisitor(\BbLeagueBundle\Entity\Team $visitor = null)
    {
        $this->visitor = $visitor;

        return $this;
    }

    /**
     * Get visitor
     *
     * @return \BbLeagueBundle\Entity\Team
     */
    public function getVisitor()
    {
        return $this->visitor;
    }

    /**
     * Set journey
     *
     * @param \BbLeagueBundle\Entity\Journey $journey
     *
     * @return Match
     */
    public function setJourney(\BbLeagueBundle\Entity\Journey $journey = null)
    {
        $this->journey = $journey;

        return $this;
    }

    /**
     * Get journey
     *
     * @return \BbLeagueBundle\Entity\Journey
     */
    public function getJourney()
    {
        return $this->journey;
    }

    /**
     * Add teamsByJourney
     *
     * @param \BbLeagueBundle\Entity\TeamByJourney $teamsByJourney
     *
     * @return Match
     */
    public function addTeamsByJourney(\BbLeagueBundle\Entity\TeamByJourney $teamsByJourney)
    {
        $this->teams_by_journey[] = $teamsByJourney;

        return $this;
    }

    /**
     * Remove teamsByJourney
     *
     * @param \BbLeagueBundle\Entity\TeamByJourney $teamsByJourney
     */
    public function removeTeamsByJourney(\BbLeagueBundle\Entity\TeamByJourney $teamsByJourney)
    {
        $this->teams_by_journey->removeElement($teamsByJourney);
    }

    /**
     * Get teamsByJourney
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeamsByJourney()
    {
        return $this->teams_by_journey;
    }
    /**
     * Set homeActions
     *
     * @param array $homeActions
     *
     * @return Match
     */
    public function setHomeActions($homeActions)
    {
        $this->home_actions = $homeActions;

        return $this;
    }

    /**
     * Get homeActions
     *
     * @return array
     */
    public function getHomeActions()
    {
        return $this->home_actions;
    }

    /**
     * Set visitorActions
     *
     * @param array $visitorActions
     *
     * @return Match
     */
    public function setVisitorActions($visitorActions)
    {
        $this->visitor_actions = $visitorActions;

        return $this;
    }

    /**
     * Get visitorActions
     *
     * @return array
     */
    public function getVisitorActions()
    {
        return $this->visitor_actions;
    }

    /**
     * Set homeInjuries
     *
     * @param array $homeInjuries
     *
     * @return Match
     */
    public function setHomeInjuries($homeInjuries)
    {
        $this->home_injuries = $homeInjuries;

        return $this;
    }

    /**
     * Get homeInjuries
     *
     * @return array
     */
    public function getHomeInjuries()
    {
        return $this->home_injuries;
    }

    /**
     * Set visitorInjuries
     *
     * @param array $visitorInjuries
     *
     * @return Match
     */
    public function setVisitorInjuries($visitorInjuries)
    {
        $this->visitor_injuries = $visitorInjuries;

        return $this;
    }

    /**
     * Get visitorInjuries
     *
     * @return array
     */
    public function getVisitorInjuries()
    {
        return $this->visitor_injuries;
    }

    /**
     * Set homeSkills
     *
     * @param array $homeSkills
     *
     * @return Match
     */
    public function setHomeSkills($homeSkills)
    {
        $this->home_skills = $homeSkills;

        return $this;
    }

    /**
     * Get homeSkills
     *
     * @return array
     */
    public function getHomeSkills()
    {
        return $this->home_skills;
    }

    /**
     * Set visitorSkills
     *
     * @param array $visitorSkills
     *
     * @return Match
     */
    public function setVisitorSkills($visitorSkills)
    {
        $this->visitor_skills = $visitorSkills;

        return $this;
    }

    /**
     * Get visitorSkills
     *
     * @return array
     */
    public function getVisitorSkills()
    {
        return $this->visitor_skills;
    }

    /**
     * Set homeDismiss
     *
     * @param array $homeDismiss
     *
     * @return Match
     */
    public function setHomeDismiss($homeDismiss)
    {
        $this->home_dismiss = $homeDismiss;

        return $this;
    }

    /**
     * Get homeDismiss
     *
     * @return array
     */
    public function getHomeDismiss()
    {
        return $this->home_dismiss;
    }

    /**
     * Set visitorDismiss
     *
     * @param array $visitorDismiss
     *
     * @return Match
     */
    public function setVisitorDismiss($visitorDismiss)
    {
        $this->visitor_dismiss = $visitorDismiss;

        return $this;
    }

    /**
     * Get visitorDismiss
     *
     * @return array
     */
    public function getVisitorDismiss()
    {
        return $this->visitor_dismiss;
    }

    /**
     * Set valid
     *
     * @param boolean $valid
     *
     * @return Match
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
}
