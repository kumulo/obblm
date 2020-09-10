<?php

namespace BBlm\Service\ChampionshipFormat;

use BBlm\Entity\Championship;
use BBlm\Entity\Encounter;
use BBlm\Entity\Journey;
use BBlm\Entity\Team;
use BBlm\Entity\TeamVersion;

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
    public function onEncounterValidate(Championship $championship, Encounter $encounter):Championship;
    public function onJourneyClose(Championship $championship, Journey $journey):Championship;
    public function canAddNewEncounter(Championship $championship, Team $team):bool;
    public function getOpenedEncounter(Team $team):?Encounter;
    public function validateEncounter(Encounter $encounter):Encounter;
    //public function getNewTeamVersion(Team $team):TeamVersion;
    //public function getNewPlayerVersion(Team $team):PlayerVersion;
    public function setWinnerAndLoser(Encounter $encounter, TeamVersion $home, TeamVersion $visitor):Encounter;
    public function getOrderedTeamsWithTieBreaks(Championship $championship);
    public function getOrderedTeams(Championship $championship);
}