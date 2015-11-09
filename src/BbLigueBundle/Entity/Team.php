<?php
// src/BbLigueBundle/Entity/Team.php

namespace BbLigueBundle\Entity;

use BbLigueBundle\Model\Team as BaseTeam;
use Doctrine\ORM\Mapping as ORM;
use BbLigueBundle\Entity\TeamByJourney;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="bbl_team")
 */
class Team extends BaseTeam
{
    protected $last_journey;
    
    public function getLastJourney()
    {
        $this->getJourneys();
        return $this->getJourneys()->first();
    }

    public function getStats()
    {
        $j = $this->journeys;

        $iterator = $j->getIterator();
        $iterator->uasort(function (TeamByJourney $a, TeamByJourney $b) {
            return ($a->getId() < $b->getId()) ? -1 : 1;
        });
        $r = array();
        foreach(iterator_to_array($iterator) as $journey) {
            $r[$journey->getJourney()->getId()] = $journey->toArray();
        }
        ksort($r);
        return $r;
    }

    public function getDashbordStats()
    {
        $j = $this->getStats();

        $r = array();
        foreach($j as $key => $journey) {
            $nj = array(
                'label' => $journey['name'],
                'value' => $journey['tr']
            );
            $r[] = $nj;
        }
        return $r;
    }
}
