<?php
// src/BbLeagueBundle/Model/Team.php

/*
 * Team has a Coach
 * Team has some Players
 * Team has a League
 */

namespace BbLeagueBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
abstract class Team
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="BbLeagueBundle\Entity\Coach", inversedBy="teams", cascade={"persist"})
     * @Assert\NotBlank()
     */
    protected $coach;

    /**
     * @ORM\ManyToOne(targetEntity="BbLeagueBundle\Entity\League", inversedBy="teams", cascade={"persist"})
     * @Assert\NotBlank()
     */
    protected $league;

    /**
     * @ORM\OneToMany(targetEntity="BbLeagueBundle\Entity\TeamByJourney", mappedBy="team", cascade={"remove"})
     * @ORM\OrderBy({"journey" = "DESC"})
     */
    protected $journeys;

    /**
     * @ORM\OneToMany(targetEntity="BbLeagueBundle\Entity\Player", mappedBy="team", cascade={"remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $players;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(name="roster", type="string", length=30)
     * @Assert\NotBlank()
     */
    protected $roster;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    protected $created_at;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    protected $updated_at;

    /**
     * @ORM\OneToMany(targetEntity="BbLeagueBundle\Entity\Encounter", mappedBy="team", cascade={"persist"})
     */
    protected $encounters;

    /**
     * @ORM\OneToMany(targetEntity="BbLeagueBundle\Entity\Encounter", mappedBy="visitor", cascade={"persist"})
     */
    protected $encounters_has_visitor;

    /**
     * @ORM\Column(name="base_reroll_value", type="integer", length=8)
     * @Assert\NotBlank()
     */
    protected $base_reroll_value;

    /**
     * @ORM\Column(name="valid", type="boolean")
     */
    protected $valid;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $logo;

    /**
     * @Assert\File(
     *     maxSize="6000000",
     *     mimeTypes={ "image/jpeg", "image/jpg", "image/png", "image/svg" },
     *     mimeTypesMessage = "Please upload a valid image"
     * )
     */
    public $file;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->journeys             = new \Doctrine\Common\Collections\ArrayCollection();
        $this->players              = new \Doctrine\Common\Collections\ArrayCollection();
        $this->encounters = new \Doctrine\Common\Collections\ArrayCollection();
        $this->encounters_has_visitor = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created_at           = new \DateTime();
        $this->updated_at           = new \DateTime();
        $this->base_reroll_value    = 0;
        $this->valid                = 0;
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
     * @return Team
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
     * Set roster
     *
     * @param string $roster
     *
     * @return Team
     */
    public function setRoster($roster)
    {
        $this->roster = $roster;

        return $this;
    }

    /**
     * Get roster
     *
     * @return string
     */
    public function getRoster()
    {
        return $this->roster;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Team
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Team
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set coach
     *
     * @param \BbLeagueBundle\Entity\Coach $coach
     *
     * @return Team
     */
    public function setCoach(\BbLeagueBundle\Entity\Coach $coach = null)
    {
        $this->coach = $coach;

        return $this;
    }

    /**
     * Get coach
     *
     * @return \BbLeagueBundle\Entity\Coach
     */
    public function getCoach()
    {
        return $this->coach;
    }

    /**
     * Set league
     *
     * @param \BbLeagueBundle\Entity\League $league
     *
     * @return Team
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
     * Add journey
     *
     * @param \BbLeagueBundle\Entity\TeamByJourney $journey
     *
     * @return Team
     */
    public function addJourney(\BbLeagueBundle\Entity\TeamByJourney $journey)
    {
        $this->journeys[] = $journey;

        return $this;
    }

    /**
     * Remove journey
     *
     * @param \BbLeagueBundle\Entity\TeamByJourney $journey
     */
    public function removeJourney(\BbLeagueBundle\Entity\TeamByJourney $journey)
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
     * Add encounter
     *
     * @param \BbLeagueBundle\Entity\Encounter $encounter
     *
     * @return Team
     */
    public function addEncounter(\BbLeagueBundle\Entity\Encounter $encounter)
    {
        $this->encounters[] = $encounter;

        return $this;
    }

    /**
     * Remove encounter
     *
     * @param \BbLeagueBundle\Entity\Encounter $encounter
     */
    public function removeEncounter(\BbLeagueBundle\Entity\Encounter $encounter)
    {
        $this->encounters->removeElement($encounter);
    }

    /**
     * Get encounters
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEncounters()
    {
        return $this->encounters;
    }

    /**
     * Add encountersHasVisitor
     *
     * @param \BbLeagueBundle\Entity\Encounter $encountersHasVisitor
     *
     * @return Team
     */
    public function addEncountersHasVisitor(\BbLeagueBundle\Entity\Encounter $encountersHasVisitor)
    {
        $this->encounters_has_visitor[] = $encountersHasVisitor;

        return $this;
    }

    /**
     * Remove encountersHasVisitor
     *
     * @param \BbLeagueBundle\Entity\Encounter $encountersHasVisitor
     */
    public function removeEncountersHasVisitor(\BbLeagueBundle\Entity\Encounter $encountersHasVisitor)
    {
        $this->encounters_has_visitor->removeElement($encountersHasVisitor);
    }

    /**
     * Get encountersHasVisitor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEncountersHasVisitor()
    {
        return $this->encounters_has_visitor;
    }

    /**
     * Add player
     *
     * @param \BbLeagueBundle\Entity\Player $player
     *
     * @return Team
     */
    public function addPlayer(\BbLeagueBundle\Entity\Player $player)
    {
        $this->players[] = $player;

        return $this;
    }

    /**
     * Remove player
     *
     * @param \BbLeagueBundle\Entity\Player $player
     */
    public function removePlayer(\BbLeagueBundle\Entity\Player $player)
    {
        $this->players->removeElement($player);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Set baseRerollValue
     *
     * @param integer $baseRerollValue
     *
     * @return Team
     */
    public function setBaseRerollValue($baseRerollValue)
    {
        $this->base_reroll_value = $baseRerollValue;

        return $this;
    }

    /**
     * Get baseRerollValue
     *
     * @return integer
     */
    public function getBaseRerollValue()
    {
        return $this->base_reroll_value;
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
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate() {
        $this->setUpdatedAt(new \Datetime);
    }
}
