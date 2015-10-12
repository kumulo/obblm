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
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Rule", inversedBy="ligues", cascade={"persist"})
     * @ORM\JoinColumn(referencedColumnName="rule_key")
     */
    protected $rule;

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
    
}
