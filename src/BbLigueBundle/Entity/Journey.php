<?php
// src/BbLigueBundle/Entity/Journey.php

namespace BbLigueBundle\Entity;

use BbLigueBundle\Model\Journey as BaseJourney;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_journey")
 */
class Journey extends BaseJourney
{

}
