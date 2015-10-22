<?php
// src/BbLigueBundle/Model/Player.php

/*
 * Player has a Team
 */

namespace BbLigueBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class Player
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
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\TeamByJourney", inversedBy="players", cascade={"persist"})
     */
    protected $journey;
    
}
