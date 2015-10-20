<?php
// src/BbLigueBundle/Model/Journey.php

/*
 *
 */

namespace BbLigueBundle\Model;

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
     * @ORM\OneToMany(targetEntity="BbLigueBundle\Entity\TeamByJourney", mappedBy="journey", cascade={"remove"})
     * @ORM\OrderBy({"id" = "DESC"})
     */
    protected $teams;

    /**
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Ligue", inversedBy="teams", cascade={"persist"})
     * @Assert\NotBlank()
     */
    protected $ligue;

    public function __construct()
    {
        parent::__construct();
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
     * @param \BbLigueBundle\Entity\TeamByJourney $team
     *
     * @return Journey
     */
    public function addTeam(\BbLigueBundle\Entity\TeamByJourney $team)
    {
        $this->teams[] = $team;

        return $this;
    }

    /**
     * Remove team
     *
     * @param \BbLigueBundle\Entity\TeamByJourney $team
     */
    public function removeTeam(\BbLigueBundle\Entity\TeamByJourney $team)
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
     * Set ligue
     *
     * @param \BbLigueBundle\Entity\Ligue $ligue
     *
     * @return Journey
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

}
