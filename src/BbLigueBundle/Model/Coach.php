<?php
// src/BbLigueBundle/Model/Coach.php

/*
 * Coach has some Teams
 */

namespace BbLigueBundle\Model;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
class Coach extends BaseUser
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
     * @ORM\OneToMany(targetEntity="BbLigueBundle\Entity\Team", mappedBy="coach", cascade={"remove"})
     */
    protected $teams;

    public function getTeams()
    {
        return $this->teams;
    }
    public function setTeams($teams)
    {
        $this->teams = $teams;
    }
}