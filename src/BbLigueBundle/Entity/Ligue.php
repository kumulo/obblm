<?php
// src/BbLigueBundle/Entity/Ligue.php

namespace BbLigueBundle\Entity;

use BbLigueBundle\Model\Ligue as BaseLigue;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_ligue")
 */
class Ligue extends BaseLigue
{

}
