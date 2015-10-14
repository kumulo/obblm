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
     * @ORM\OrderBy({"id" = "ASC"})
     */
    protected $journeys;

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
    
    public function __construct() {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
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
     * Set id
     *
     * @param integer
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get ligue
     *
     * @return Entity\Ligue
     */
    public function getLigue()
    {
        return $this->ligue;
    }

    /**
     * Set ligue
     *
     * @param Entity\Ligue
     */
    public function setLigue($ligue)
    {
        $this->ligue = $ligue;
    }

    /**
     * Get coach
     *
     * @return Entity\Coach
     */
    public function getCoach()
    {
        return $this->coach;
    }

    /**
     * Set coach
     *
     * @param Entity\Coach
     */
    public function setCoach($coach)
    {
        $this->coach = $coach;
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
     * Get roster
     *
     * @return varchar
     */
    public function getRoster()
    {
        return $this->roster;
    }

    /**
     * Set roster
     *
     * @param string
     */
    public function setRoster($roster)
    {
        $this->roster = $roster;
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
