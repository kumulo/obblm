<?php

namespace App\Service;

use App\Entity\Rule;
use App\Entity\Team;

class TeamService {

    const TRANSLATION_GLUE = '.';

    public static function calculateTeamValue(Team $team):int {
        $team_cost = 0;
        $rule = self::getTeamRule($team);

        // Players
        foreach($team->getPlayers() as $player) {
            $team_cost += $rule->getPlayerCost($player->getType());
        }
        // Sidelines
        $team_cost += $team->getRerolls() * self::getRerollCost($team);
        $team_cost += $team->getAssistants() * self::getAssistantsCost($team);
        $team_cost += $team->getCheerleaders() * self::getCheerleadersCost($team);
        $team_cost += $team->getPopularity() * self::getPopularityCost($team);
        $team_cost += ($team->getApothecary()) ? self::getApothecaryCost($team) : 0;

        return $team_cost;
    }

    public static function calculateTeamRate(Team $team):int {
        return self::calculateTeamValue($team) / 10000;
    }

    public static function getApothecaryCost(Team $team):int {
        return (int) self::getTeamRule($team)->getRule()['sidelines_cost']['apothecary'];
    }

    public static function getCheerleadersCost(Team $team):int {
        return (int) self::getTeamRule($team)->getRule()['sidelines_cost']['cheerleaders'];
    }

    public static function getAssistantsCost(Team $team):int {
        return (int) self::getTeamRule($team)->getRule()['sidelines_cost']['assistants'];
    }

    public static function getPopularityCost(Team $team):int {
        return (int) self::getTeamRule($team)->getRule()['sidelines_cost']['popularity'];
    }

    /**
     * @param Team $team
     * @return Rule|false
     */
    public static function getTeamRule(Team $team) {
        return ($team->getChampionship()) ? $team->getChampionship()->getRule() : ($team->getRule() ?? false);
    }

    public static function getRosterNameForTranslation(Team $team):string {
        return join(self::TRANSLATION_GLUE, [self::getTeamRule($team)->getRuleKey(), 'rosters', $team->getRoster(), 'title']);
    }

    public static function getRerollCost(Team $team):int {
        return (int) self::getTeamRule($team)->getRule()['rosters'][$team->getRoster()]['options']['reroll_cost'];
    }

    public static function isTeamCouldHaveApothecary(Team $team):bool {
        return (bool) self::getTeamRule($team)->getRule()['rosters'][$team->getRoster()]['options']['can_have_apothecary'];
    }
}