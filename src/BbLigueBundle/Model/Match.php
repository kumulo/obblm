<?php
// src/BbLigueBundle/Model/Match.php

/*
 * Match has a Team
 * Match has a "visitor" Team
 */

namespace BbLigueBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class Match
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
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Team", inversedBy="matchs", cascade={"persist"})
     */
    protected $team;

    /**
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Team", inversedBy="matchs", cascade={"persist"})
     */
    protected $visitor;

    /**
     * @ORM\Column(type="integer")
     */
    protected $weather;
    
}