<?php
// src/BbLigueBundle/Model/Ligue.php

/*
 * Ligue has some Teams
 */

namespace BbLigueBundle\Model;

use Doctrine\ORM\Mapping as ORM;

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

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    
}