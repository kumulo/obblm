<?php
// src/BbLeagueBundle/Entiy/Match.php

namespace BbLeagueBundle\Entity;

use BbLeagueBundle\Model\Match as BaseMatch;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_match")
 */
class Match extends BaseMatch
{

}
