<?php

namespace App\Service\ChampionshipFormat;

use App\Entity\Championship;
use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;

class OpenChampionshipFormat extends AbstractChampionshipFormat implements ChampionshipFormatInterface {

    const FORMAT = 'format.open';

    protected $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function validateTeamForChampionship(Championship $championship, Team $team):bool {
        if(!$team instanceof Team || !$championship instanceof Championship) {
            return false;
        }

        return true;
    }

    public function onLaunched(Championship $championship):Championship {
        foreach($championship->getTeams() as $team) {
            $team->setLockedByManagment(true);
            $this->em->persist($team);
        }
        $this->em->flush();
        return $championship;
    }
}