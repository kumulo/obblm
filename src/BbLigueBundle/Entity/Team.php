<?php
// src/BbLigueBundle/Entity/Team.php

namespace BbLigueBundle\Entity;

use BbLigueBundle\Model\Team as BaseTeam;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_team")
 */
class Team extends BaseTeam
{
    
}