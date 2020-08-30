<?php

namespace App\Service;

use App\Entity\Player;
use App\Entity\PlayerVersion;

class PlayerService {

    const TRANSLATION_GLUE = '.';

    public static function getPlayerTranslationKey(Player $player):string {
        list($rule_key, $roster, $type) = explode(self::TRANSLATION_GLUE, $player->getType());
        return self::composeTranslationPlayerKey($rule_key, $roster, $type);
    }

    public static function composePlayerKey($rule_key, $roster, $type):string {
        return join(self::TRANSLATION_GLUE, [$rule_key, $roster, $type]);
    }

    public static function composeTranslationPlayerKey($rule_key, $roster, $type):string {
        return join(self::TRANSLATION_GLUE, [$rule_key, 'rosters', $roster, 'positions', $type]);
    }

    public static function getPlayerSkills(Player $player):array {
        $last = self::getLastVersion($player);
        return ($last instanceof PlayerVersion) ? $last->getSkills() : ($last['skills'] ?? []);
    }

    public static function getPlayerCharacteristics(Player $player):array {
        $last = self::getLastVersion($player);
        return ($last instanceof PlayerVersion) ? $last->getCharacteristics() : $last;
    }

    public static function getPlayerValue(Player $player):string {
        $last = self::getLastVersion($player);
        $rule = TeamService::getTeamRule($player->getTeam());
        list($rule_key, $roster, $type) = explode('.', $player->getType());
        return ($last instanceof PlayerVersion) ? $last->getValue() : $rule->getRule()['rosters'][$roster]['players'][$type]['cost'];
    }

    /**
     * @param Player $player
     * @return PlayerVersion|array
     */
    public static function getLastVersion(Player $player) {
        $versions = $player->getVersions();
        /** @var PlayerVersion $last */
        $last = $versions->first();
        if($last) {
            return $last;
        }
        $rule = TeamService::getTeamRule($player->getTeam());
        list($rule_key, $roster, $type) = explode('.', $player->getType());
        return $rule->getRule()['rosters'][$roster]['players'][$type];
    }
}