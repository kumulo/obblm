<?php
// src/BbLigueBundle/Model/Ligue.php

/*
 * Ligue has some Teams
 */

namespace BbLigueBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\MappedSuperclass */
class Ligue
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="BbLigueBundle\Entity\Team", mappedBy="ligue", cascade={"remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $teams;

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
     * @return Ligue
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
     * @return Ligue
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
     * @param \BbLigueBundle\Entity\Team $team
     *
     * @return Ligue
     */
    public function addTeam(\BbLigueBundle\Entity\Team $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \BbLigueBundle\Entity\Team $team
     */
    public function removeTeam(\BbLigueBundle\Entity\Team $team)
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
     * @return Ligue
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
     * @return Ligue
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
     * @return Ligue
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
}
