<?php

namespace App\Service\ChampionshipFormat;

use App\Entity\Championship;
use App\Entity\Game;
use App\Entity\Journey;
use App\Entity\Team;

interface ChampionshipFormatInterface {

    /**
     * Returns the key name to be store in database in format Championship value.
     *
     * @return string
     */
    public function getKey():string;

    /**
     * Returns the key name to be store in database in format Championship value.
     *
     * @return string
     */
    public function getFormat():string;

    public function validateTeamForChampionship(Championship $championship, Team $team):bool;
    public function onLaunched(Championship $championship):Championship;
    public function onGameValidate(Championship $championship, Game $game):Championship;
    public function onJourneyClose(Championship $championship, Journey $journey):Championship;
}