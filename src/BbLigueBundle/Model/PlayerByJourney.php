<?php
// src/BbLigueBundle/Model/PlayerByJourney.php

/*
 * PlayerByJourney has a Player
 * PlayerByJourney has a TeamByJourney
 */

namespace BbLigueBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/** @ORM\MappedSuperclass */
class PlayerByJourney
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
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\Player", inversedBy="journeys", cascade={"persist"})
     */
    protected $player;

    /**
     * @ORM\ManyToOne(targetEntity="BbLigueBundle\Entity\TeamByJourney", inversedBy="players", cascade={"persist"})
     */
    protected $journey;

}
