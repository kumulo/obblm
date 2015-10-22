<?php
// src/BbLigueBundle/Entiy/Match.php

namespace BbLigueBundle\Entiy;

use BbLigueBundle\Model\Match as BaseMatch;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_match")
 */
class Match extends BaseMatch
{
        
}
