<?php
// src/BbLigueBundle/Model/TeamByJourney.php

/*
 * Team has a Coach
 * Team has some Players
 * Team has a Ligue
 */

namespace BbLigueBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class TeamByJourney
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Team", inversedBy="journeys", cascade={"persist"})
     */
    protected $team;

    /**
     * @ORM\OneToMany(targetEntity="BbLigueBundle\Entity\Player", mappedBy="journey", cascade={"remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $players;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updated_at;
    
    public function __construct() {}
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
     * Set id
     *
     * @param integer
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get created_at
     *
     * @return Datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set created_at
     *
     * @param Datetime
     */
    public function setCreatedAt($date)
    {
        $this->created_at = $date;
    }

    /**
     * Get updated_at
     *
     * @return Datetime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set updated_at
     *
     * @param Datetime
     */
    public function setUpdatedAt($date)
    {
        $this->updated_at = $date;
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function preUpdate() {
        $this->setUpdatedAt(new \Datetime);
    }
}