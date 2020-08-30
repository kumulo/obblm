<?php

namespace App\Twig;

use App\Entity\Player;
use App\Entity\Team;
use App\Service\PlayerService;
use App\Service\TeamService;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class TeamExtension extends AbstractExtension {

    public function getFilters()
    {
        return [
            // Team filters
            new TwigFilter('rule_key', [$this, 'getRuleKey']),
            new TwigFilter('roster_name', [$this, 'getRosterName']),
            new TwigFilter('tr', [$this, 'getTeamRate']),
            new TwigFilter('calculate_value', [$this, 'getTeamValue']),
            new TwigFilter('reroll_cost', [$this, 'getRerollCost']),
            // Players filters
            new TwigFilter('type', [$this, 'getType']),
            new TwigFilter('characteristics', [$this, 'getCharacteristics']),
            new TwigFilter('skills', [$this, 'getSkills']),
            new TwigFilter('value', [$this, 'getPlayerValue']),
        ];
    }
    public function getFunctions()
    {
        return [
            new TwigFunction('area', [$this, 'calculateArea']),
        ];
    }

    public function calculateArea(int $width, int $length)
    {
        return $width * $length;
    }

    public function getTeamRate(Team $team) {
        return TeamService::calculateTeamRate($team);
    }

    public function getRuleKey(Team $team) {
        return TeamService::getTeamRule($team)->getRuleKey();
    }

    public function getRosterName(Team $team) {
        return TeamService::getRosterNameForTranslation($team);
    }

    public function getRerollCost(Team $team) {
        return TeamService::getRerollCost($team);
    }

    public function getTeamValue(Team $team) {
        return TeamService::calculateTeamValue($team);
    }

    public function getCharacteristics(Player $player, $characteristic) {
        $characteristics = PlayerService::getPlayerCharacteristics($player);

        if(!isset($characteristics[$characteristic])) {
            throw new InvalidParameterException("The characteristic " . $characteristic . " does not exists");
        }

        return $characteristics[$characteristic];
    }

    public function getSkills(Player $player) {
        return PlayerService::getPlayerSkills($player);
    }

    public function getType(Player $player) {
        return PlayerService::getPlayerTranslationKey($player);
    }

    public function getPlayerValue(Player $player) {
        return PlayerService::getPlayerValue($player);
    }

}