<?php

namespace App\DataFixtures\Teams;

use App\Entity\Championship;
use App\Entity\Coach;
use App\Entity\Player;
use App\Entity\Team;
use App\Service\PlayerService;

trait TeamFixtureTrait {
    protected $championship;
    protected $rule_key;
    protected $coach;

    private function setChampionship(Championship $championship) {
        $this->championship = $championship;
        $this->rule_key = $championship->getRule()->getRuleKey();
        return $this;
    }

    private function setCoach(Coach $coach) {
        $this->coach = $coach;
        return $this;
    }

    private function loadTeamByArray(array $data):Team {
        /*
         * array
         *   name
         *   roster
         *   rerolls
         *   apothecary
         *   positions
         *     type_key: quantity
         */
        $team = (new Team())
            ->setName($data['name'])
            ->setRoster($data['roster'])
            ->setApothecary($data['apothecary'])
            ->setCoach($this->coach)
            ->setChampionship($this->championship)
            ->setRerolls($data['rerolls']);

        $player_number = 0;
        foreach($data['positions'] as $type => $quantity) {
            for($i = 0; $i < $quantity; $i++) {
                $player = (new Player())
                    ->setName('Player '.$player_number)
                    ->setNumber($player_number)
                    ->setType(PlayerService::composePlayerKey($this->rule_key, $data['roster'], $type));
                $team->addPlayer($player);
                $player_number++;
            }
        }
        return $team;
    }
}