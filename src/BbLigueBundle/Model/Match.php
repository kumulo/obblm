<?php
// src/BbLigueBundle/Model/Match.php

/*
 * Match has a Team
 * Match has a "visitor" Team
 */

namespace BbLigueBundle\Model;

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
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Team", inversedBy="matchs", cascade={"persist"})
     */
    protected $team;

    /**
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Team", inversedBy="matchs_has_visitor", cascade={"persist"})
     */
    protected $visitor;

    /**
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Journey", inversedBy="matchs", cascade={"persist"})
     */
    protected $journey;

    /**
     * @ORM\OneToMany(targetEntity="BbLigueBundle\Entity\TeamByJourney", mappedBy="match", cascade={"remove"})
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
     * @param \BbLigueBundle\Entity\Team $team
     *
     * @return Match
     */
    public function setTeam(\BbLigueBundle\Entity\Team $team = null)
    {
        $this->team = $team;

        return $this;
    }

    /**
     * Get team
     *
     * @return \BbLigueBundle\Entity\Team
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set visitor
     *
     * @param \BbLigueBundle\Entity\Team $visitor
     *
     * @return Match
     */
    public function setVisitor(\BbLigueBundle\Entity\Team $visitor = null)
    {
        $this->visitor = $visitor;

        return $this;
    }

    /**
     * Get visitor
     *
     * @return \BbLigueBundle\Entity\Team
     */
    public function getVisitor()
    {
        return $this->visitor;
    }

    /**
     * Set journey
     *
     * @param \BbLigueBundle\Entity\Journey $journey
     *
     * @return Match
     */
    public function setJourney(\BbLigueBundle\Entity\Journey $journey = null)
    {
        $this->journey = $journey;

        return $this;
    }

    /**
     * Get journey
     *
     * @return \BbLigueBundle\Entity\Journey
     */
    public function getJourney()
    {
        return $this->journey;
    }

    /**
     * Add teamsByJourney
     *
     * @param \BbLigueBundle\Entity\TeamByJourney $teamsByJourney
     *
     * @return Match
     */
    public function addTeamsByJourney(\BbLigueBundle\Entity\TeamByJourney $teamsByJourney)
    {
        $this->teams_by_journey[] = $teamsByJourney;

        return $this;
    }

    /**
     * Remove teamsByJourney
     *
     * @param \BbLigueBundle\Entity\TeamByJourney $teamsByJourney
     */
    public function removeTeamsByJourney(\BbLigueBundle\Entity\TeamByJourney $teamsByJourney)
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
