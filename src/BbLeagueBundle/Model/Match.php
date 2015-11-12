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

    public function __construct()
    {

    }

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
}
