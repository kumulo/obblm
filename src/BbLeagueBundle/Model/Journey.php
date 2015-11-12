<?php
// src/BbLeagueBundle/Model/Journey.php

/*
 *
 */

namespace BbLeagueBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
abstract class Journey
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="BbLeagueBundle\Entity\TeamByJourney", mappedBy="journey", cascade={"remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $teams;

    /**
     * @ORM\OneToMany(targetEntity="BbLeagueBundle\Entity\Match", mappedBy="journey", cascade={"remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $matchs;

    /**
     * @ORM\ManyToOne(targetEntity="BbLeagueBundle\Entity\League", inversedBy="journeys", cascade={"persist"})
     * @Assert\NotBlank()
     */
    protected $league;

    public function __construct()
    {
        // your own logic
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
     * @return Journey
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
     * Add team
     *
     * @param \BbLeagueBundle\Entity\TeamByJourney $team
     *
     * @return Journey
     */
    public function addTeam(\BbLeagueBundle\Entity\TeamByJourney $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \BbLeagueBundle\Entity\TeamByJourney $team
     */
    public function removeTeam(\BbLeagueBundle\Entity\TeamByJourney $team)
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
     * Set league
     *
     * @param \BbLeagueBundle\Entity\League $league
     *
     * @return Journey
     */
    public function setLeague(\BbLeagueBundle\Entity\League $league = null)
    {
        $this->league = $league;

        return $this;
    }

    /**
     * Get league
     *
     * @return \BbLeagueBundle\Entity\League
     */
    public function getLeague()
    {
        return $this->league;
    }

    /**
     * Add match
     *
     * @param \BbLeagueBundle\Entity\Match $match
     *
     * @return Journey
     */
    public function addMatch(\BbLeagueBundle\Entity\Match $match)
    {
        $this->matchs[] = $match;

        return $this;
    }

    /**
     * Remove match
     *
     * @param \BbLeagueBundle\Entity\Match $match
     */
    public function removeMatch(\BbLeagueBundle\Entity\Match $match)
    {
        $this->matchs->removeElement($match);
    }

    /**
     * Get matchs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatchs()
    {
        return $this->matchs;
    }
}
