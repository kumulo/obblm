<?php
// src/BbLigueBundle/Model/Rule.php

/*
 * Rule has some Teams
 */

namespace BbLigueBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\MappedSuperclass */
class Rule
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="rule_key", unique=true, type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $rule_key;


    /**
     * @ORM\OneToMany(targetEntity="Ligue", mappedBy="rule")
     */
    protected $ligues;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(name="rule", type="text")
     * @Assert\NotBlank()
     */
    protected $rule;

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
     * Get rule_key
     *
     * @return varchar
     */
    public function getRuleKey()
    {
        return $this->rule_key;
    }

    /**
     * Set rule_key
     *
     * @param string
     */
    public function setRuleKey($rule_key)
    {
        $this->rule_key = $rule_key;
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
     * Get rule
     *
     * @return varchar
     */
    public function getRule()
    {
        return $this->rule;
    }

    /**
     * Set rule
     *
     * @param string
     */
    public function setRule($rule)
    {
        $this->rule = $rule;
    }
}