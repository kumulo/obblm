<?php
// src/BbLigueBundle/Model/Team.php

/*
 * Team has a Coach
 * Team has some Players
 * Team has a Ligue
 */

namespace BbLigueBundle\Model;

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
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Coach", inversedBy="teams", cascade={"persist"})
     * @Assert\NotBlank()
     */
    protected $coach;

    /**
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Ligue", inversedBy="teams", cascade={"persist"})
     * @Assert\NotBlank()
     */
    protected $ligue;

    /**
     * @ORM\OneToMany(targetEntity="BbLigueBundle\Entity\TeamByJourney", mappedBy="team", cascade={"remove"})
     * @ORM\OrderBy({"journey" = "DESC"})
     */
    protected $journeys;

    /**
     * @ORM\OneToMany(targetEntity="BbLigueBundle\Entity\Player", mappedBy="team", cascade={"remove"})
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
     * @ORM\OneToMany(targetEntity="BbLigueBundle\Entity\Match", mappedBy="team", cascade={"persist"})
     */
    protected $matchs;

    /**
     * @ORM\OneToMany(targetEntity="BbLigueBundle\Entity\Match", mappedBy="visitor", cascade={"persist"})
     */
    protected $matchs_has_visitor;

    /**
     * @ORM\Column(name="base_reroll_value", type="integer", length=8)
     * @Assert\NotBlank()
     */
    protected $base_reroll_value;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->journeys             = new \Doctrine\Common\Collections\ArrayCollection();
        $this->players              = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created_at           = new \DateTime();
        $this->updated_at           = new \DateTime();
        $this->base_reroll_value    = 0;
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
     * @param \BbLigueBundle\Entity\Coach $coach
     *
     * @return Team
     */
    public function setCoach(\BbLigueBundle\Entity\Coach $coach = null)
    {
        $this->coach = $coach;

        return $this;
    }

    /**
     * Get coach
     *
     * @return \BbLigueBundle\Entity\Coach
     */
    public function getCoach()
    {
        return $this->coach;
    }

    /**
     * Set ligue
     *
     * @param \BbLigueBundle\Entity\Ligue $ligue
     *
     * @return Team
     */
    public function setLigue(\BbLigueBundle\Entity\Ligue $ligue = null)
    {
        $this->ligue = $ligue;

        return $this;
    }

    /**
     * Get ligue
     *
     * @return \BbLigueBundle\Entity\Ligue
     */
    public function getLigue()
    {
        return $this->ligue;
    }

    /**
     * Add journey
     *
     * @param \BbLigueBundle\Entity\TeamByJourney $journey
     *
     * @return Team
     */
    public function addJourney(\BbLigueBundle\Entity\TeamByJourney $journey)
    {
        $this->journeys[] = $journey;

        return $this;
    }

    /**
     * Remove journey
     *
     * @param \BbLigueBundle\Entity\TeamByJourney $journey
     */
    public function removeJourney(\BbLigueBundle\Entity\TeamByJourney $journey)
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
     * Add match
     *
     * @param \BbLigueBundle\Entity\Match $match
     *
     * @return Team
     */
    public function addMatch(\BbLigueBundle\Entity\Match $match)
    {
        $this->matchs[] = $match;

        return $this;
    }

    /**
     * Remove match
     *
     * @param \BbLigueBundle\Entity\Match $match
     */
    public function removeMatch(\BbLigueBundle\Entity\Match $match)
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

    /**
     * Add matchsHasVisitor
     *
     * @param \BbLigueBundle\Entity\Match $matchsHasVisitor
     *
     * @return Team
     */
    public function addMatchsHasVisitor(\BbLigueBundle\Entity\Match $matchsHasVisitor)
    {
        $this->matchs_has_visitor[] = $matchsHasVisitor;

        return $this;
    }

    /**
     * Remove matchsHasVisitor
     *
     * @param \BbLigueBundle\Entity\Match $matchsHasVisitor
     */
    public function removeMatchsHasVisitor(\BbLigueBundle\Entity\Match $matchsHasVisitor)
    {
        $this->matchs_has_visitor->removeElement($matchsHasVisitor);
    }

    /**
     * Get matchsHasVisitor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatchsHasVisitor()
    {
        return $this->matchs_has_visitor;
    }

    /**
     * Get matchs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommingMatchs()
    {
        $r = array();
        $matchs = array_merge(
            iterator_to_array($this->matchs),
            iterator_to_array($this->matchs_has_visitor)
        );
        foreach($matchs as $match) {
            if(count($match->getTeamsByJourney()) == 0) {
                $r[] = $match;
            }
        }
        return $r;
    }

    /**
     * Add player
     *
     * @param \BbLigueBundle\Entity\Player $player
     *
     * @return Team
     */
    public function addPlayer(\BbLigueBundle\Entity\Player $player)
    {
        $this->players[] = $player;

        return $this;
    }

    /**
     * Remove player
     *
     * @param \BbLigueBundle\Entity\Player $player
     */
    public function removePlayer(\BbLigueBundle\Entity\Player $player)
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
     * @ORM\PreUpdate
     */
    public function preUpdate() {
        $this->setUpdatedAt(new \Datetime);
    }
}
