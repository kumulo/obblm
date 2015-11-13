<?php
// src/BbLeagueBundle/Model/Player.php

/*
 * Player has a Team
 */

namespace BbLeagueBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\MappedSuperclass */
class Player
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="BbLeagueBundle\Entity\Team", inversedBy="players", cascade={"persist"})
     */
    protected $team;

    /**
     * @ORM\OneToMany(targetEntity="BbLeagueBundle\Entity\PlayerByJourney", mappedBy="player", cascade={"persist"})
     */
    protected $journeys;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(name="position", type="integer", length=2)
     * @Assert\NotBlank()
     */
    protected $position;

    /**
     * @ORM\Column(name="type", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $type;

    public function __construct()
    {
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
     * @return Player
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
     * Set position
     *
     * @param integer $position
     *
     * @return Player
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Player
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set team
     *
     * @param \BbLeagueBundle\Entity\Team $team
     *
     * @return Player
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
     * Add journey
     *
     * @param \BbLeagueBundle\Entity\PlayerByJourney $journey
     *
     * @return Player
     */
    public function addJourney(\BbLeagueBundle\Entity\PlayerByJourney $journey)
    {
        $this->journeys[] = $journey;

        return $this;
    }

    /**
     * Remove journey
     *
     * @param \BbLeagueBundle\Entity\PlayerByJourney $journey
     */
    public function removeJourney(\BbLeagueBundle\Entity\PlayerByJourney $journey)
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
