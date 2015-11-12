<?php
// src/BbLeagueBundle/Entity/PlayerByJourney.php

namespace BbLeagueBundle\Entity;

use BbLeagueBundle\Model\PlayerByJourney as BasePlayerByJourney;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_player_by_journey")
 */
class PlayerByJourney extends BasePlayerByJourney
{
    /**
     * Get Spp
     *
     * @return integer
     */
    public function getSpp()
    {
        return (
            $this->completions * 1 +
            $this->touchdowns * 3 +
            $this->casualties * 2 +
            $this->interceptions * 2 +
            $this->mvps * 5
        );
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return PlayerByJourney
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }
}
