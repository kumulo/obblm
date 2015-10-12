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
     * @OneToMany(targetEntity="Ligue", mappedBy="rule")
     * @var Ligue[]
     */
}
