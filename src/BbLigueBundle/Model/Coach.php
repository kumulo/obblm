<?php
// src/BbLigueBundle/Model/Coach.php

/*
 * Coach has some Teams
 */

namespace BbLigueBundle\Model;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
abstract class Coach extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @ORM\OneToMany(targetEntity="BbLigueBundle\Entity\Team", mappedBy="coach", cascade={"remove"})
     */
    protected $teams;

    /**
     * Add team
     *
     * @param \BbLigueBundle\Entity\Team $team
     *
     * @return Coach
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
}
