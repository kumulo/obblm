<?php
// src/BbLeagueBundle/Model/TeamByJourney.php

/*
 * Team has a Coach
 * Team has some Players
 * Team has a League
 */

namespace BbLeagueBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
abstract class TeamByJourney
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="BbLeagueBundle\Entity\Team", inversedBy="journeys", cascade={"persist"})
     */
    protected $team;

    /**
     * @ORM\ManyToOne(targetEntity="BbLeagueBundle\Entity\Journey", inversedBy="teams", cascade={"persist"})
     */
    protected $journey;

    /**
     * @ORM\ManyToOne(targetEntity="BbLeagueBundle\Entity\Match", inversedBy="teams_by_journey", cascade={"persist"})
     */
    protected $match;

    /**
     * @ORM\OneToMany(targetEntity="BbLeagueBundle\Entity\PlayerByJourney", mappedBy="journey", cascade={"remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $players;

    /**
     * @ORM\Column(name="win_match", type="smallint")
     */
    protected $win_match;

    /**
     * @ORM\Column(name="draw_match", type="smallint")
     */
    protected $draw_match;

    /**
     * @ORM\Column(name="lost_match", type="smallint")
     */
    protected $lost_match;

    /**
     * @ORM\Column(name="td_give", type="smallint")
     */
    protected $td_give;

    /**
     * @ORM\Column(name="td_take", type="smallint")
     */
    protected $td_take;

    /**
     * @ORM\Column(name="injury_give", type="smallint")
     */
    protected $injury_give;

    /**
     * @ORM\Column(name="injury_take", type="smallint")
     */
    protected $injury_take;

    /**
     * @ORM\Column(name="pass", type="smallint")
     */
    protected $pass;

    /**
     * @ORM\Column(name="red_card", type="smallint")
     */
    protected $red_card;

    /**
     * @ORM\Column(name="rerolls", type="smallint")
     */
    protected $rerolls;

    /**
     * @ORM\Column(name="treasure", type="integer")
     */
    protected $treasure;

    /**
     * @ORM\Column(name="popularity", type="integer")
     */
    protected $popularity;

    /**
     * @ORM\Column(name="assistants", type="integer")
     */
    protected $assistants;

    /**
     * @ORM\Column(name="cheerleaders", type="integer")
     */
    protected $cheerleaders;

    /**
     * @ORM\Column(name="apothecary", type="boolean")
     */
    protected $apothecary;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updated_at;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->players      = new \Doctrine\Common\Collections\ArrayCollection();
        $this->rerolls      = 0;
        $this->treasure     = 0;
        $this->apothecary   = 0;
        $this->popularity   = 0;
        $this->assistants   = 0;
        $this->cheerleaders = 0;
        $this->win_match    = 0;
        $this->draw_match   = 0;
        $this->lost_match   = 0;
        $this->td_give      = 0;
        $this->td_take      = 0;
        $this->injury_give  = 0;
        $this->injury_take  = 0;
        $this->pass         = 0;
        $this->red_card     = 0;
        $this->created_at   = new \DateTime();
        $this->updated_at   = new \DateTime();
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
     * Set winMatch
     *
     * @param integer $winMatch
     *
     * @return TeamByJourney
     */
    public function setWinMatch($winMatch)
    {
        $this->win_match = $winMatch;

        return $this;
    }

    /**
     * Get winMatch
     *
     * @return integer
     */
    public function getWinMatch()
    {
        return $this->win_match;
    }

    /**
     * Set drawMatch
     *
     * @param integer $drawMatch
     *
     * @return TeamByJourney
     */
    public function setDrawMatch($drawMatch)
    {
        $this->draw_match = $drawMatch;

        return $this;
    }

    /**
     * Get drawMatch
     *
     * @return integer
     */
    public function getDrawMatch()
    {
        return $this->draw_match;
    }

    /**
     * Set lostMatch
     *
     * @param integer $lostMatch
     *
     * @return TeamByJourney
     */
    public function setLostMatch($lostMatch)
    {
        $this->lost_match = $lostMatch;

        return $this;
    }

    /**
     * Get lostMatch
     *
     * @return integer
     */
    public function getLostMatch()
    {
        return $this->lost_match;
    }

    /**
     * Set tdGive
     *
     * @param integer $tdGive
     *
     * @return TeamByJourney
     */
    public function setTdGive($tdGive)
    {
        $this->td_give = $tdGive;

        return $this;
    }

    /**
     * Get tdGive
     *
     * @return integer
     */
    public function getTdGive()
    {
        return $this->td_give;
    }

    /**
     * Set tdTake
     *
     * @param integer $tdTake
     *
     * @return TeamByJourney
     */
    public function setTdTake($tdTake)
    {
        $this->td_take = $tdTake;

        return $this;
    }

    /**
     * Get tdTake
     *
     * @return integer
     */
    public function getTdTake()
    {
        return $this->td_take;
    }

    /**
     * Set injuryGive
     *
     * @param integer $injuryGive
     *
     * @return TeamByJourney
     */
    public function setInjuryGive($injuryGive)
    {
        $this->injury_give = $injuryGive;

        return $this;
    }

    /**
     * Get injuryGive
     *
     * @return integer
     */
    public function getInjuryGive()
    {
        return $this->injury_give;
    }

    /**
     * Set injuryTake
     *
     * @param integer $injuryTake
     *
     * @return TeamByJourney
     */
    public function setInjuryTake($injuryTake)
    {
        $this->injury_take = $injuryTake;

        return $this;
    }

    /**
     * Get injuryTake
     *
     * @return integer
     */
    public function getInjuryTake()
    {
        return $this->injury_take;
    }

    /**
     * Set pass
     *
     * @param integer $pass
     *
     * @return TeamByJourney
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return integer
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set redCard
     *
     * @param integer $redCard
     *
     * @return TeamByJourney
     */
    public function setRedCard($redCard)
    {
        $this->red_card = $redCard;

        return $this;
    }

    /**
     * Get redCard
     *
     * @return integer
     */
    public function getRedCard()
    {
        return $this->red_card;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return TeamByJourney
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
     * @return TeamByJourney
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
     * Set team
     *
     * @param \BbLeagueBundle\Entity\Team $team
     *
     * @return TeamByJourney
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
     * Set journey
     *
     * @param \BbLeagueBundle\Entity\Journey $journey
     *
     * @return TeamByJourney
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
     * Add player
     *
     * @param \BbLeagueBundle\Entity\Player $player
     *
     * @return TeamByJourney
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
     * Set match
     *
     * @param \BbLeagueBundle\Entity\Match $match
     *
     * @return TeamByJourney
     */
    public function setMatch(\BbLeagueBundle\Entity\Match $match = null)
    {
        $this->match = $match;

        return $this;
    }

    /**
     * Get match
     *
     * @return \BbLeagueBundle\Entity\Match
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * Set rerolls
     *
     * @param integer $rerolls
     *
     * @return TeamByJourney
     */
    public function setRerolls($rerolls)
    {
        $this->rerolls = $rerolls;

        return $this;
    }

    /**
     * Get rerolls
     *
     * @return integer
     */
    public function getRerolls()
    {
        return $this->rerolls;
    }

    /**
     * Set treasure
     *
     * @param integer $treasure
     *
     * @return TeamByJourney
     */
    public function setTreasure($treasure)
    {
        $this->treasure = $treasure;

        return $this;
    }

    /**
     * Get treasure
     *
     * @return integer
     */
    public function getTreasure()
    {
        return $this->treasure;
    }

    /**
     * Set popularity
     *
     * @param integer $popularity
     *
     * @return TeamByJourney
     */
    public function setPopularity($popularity)
    {
        $this->popularity = $popularity;

        return $this;
    }

    /**
     * Get popularity
     *
     * @return integer
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * Set assistants
     *
     * @param integer $assistants
     *
     * @return TeamByJourney
     */
    public function setAssistants($assistants)
    {
        $this->assistants = $assistants;

        return $this;
    }

    /**
     * Get assistants
     *
     * @return integer
     */
    public function getAssistants()
    {
        return $this->assistants;
    }

    /**
     * Set cheerleaders
     *
     * @param integer $cheerleaders
     *
     * @return TeamByJourney
     */
    public function setCheerleaders($cheerleaders)
    {
        $this->cheerleaders = $cheerleaders;

        return $this;
    }

    /**
     * Get cheerleaders
     *
     * @return integer
     */
    public function getCheerleaders()
    {
        return $this->cheerleaders;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate() {
        $this->setUpdatedAt(new \Datetime);
    }
}
