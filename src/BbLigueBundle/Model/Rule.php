<?php
// src/BbLigueBundle/Model/Rule.php

/*
 * Rule has some Teams
 */

namespace BbLigueBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
abstract class Rule
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @ORM\Column(name="description", type="string", nullable=true, length=255)
     */
    protected $description;

    /**
     * @ORM\Column(name="rule", nullable=true, type="array")
     */
    protected $rule;


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
     * Set ruleKey
     *
     * @param string $ruleKey
     *
     * @return Rule
     */
    public function setRuleKey($ruleKey)
    {
        $this->rule_key = $ruleKey;

        return $this;
    }

    /**
     * Get ruleKey
     *
     * @return string
     */
    public function getRuleKey()
    {
        return $this->rule_key;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Rule
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
     * Set description
     *
     * @param string $description
     *
     * @return Rule
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set rule
     *
     * @param array $rule
     *
     * @return Rule
     */
    public function setRule($rule)
    {
        $this->rule = $rule;

        return $this;
    }

    /**
     * Get rule
     *
     * @return array
     */
    public function getRule()
    {
        return $this->rule;
    }
}
