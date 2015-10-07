<?php
// src/BbLigueBundle/Model/Team.php

/*
 * Team has a Coach
 * Team has some Players
 * Team has a Ligue
 */

namespace BbLigueBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class Team
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Coach", inversedBy="teams", cascade={"persist"})
     */
    protected $coach;

    /**
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Ligue", inversedBy="teams", cascade={"persist"})
     */
    protected $ligue;

    /**
     * @ORM\OneToMany(targetEntity="BbLigueBundle\Entity\TeamByJourney", mappedBy="team", cascade={"remove"})
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $journeys;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

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
     * Get name
     *
     * @return varchar
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string
     */
    public function setName($name)
    {
        $this->name = $name;
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