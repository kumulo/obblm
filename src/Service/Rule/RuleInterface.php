<?php

namespace BBlm\Service\Rule;

use BBlm\Entity\PlayerVersion;
use BBlm\Entity\Rule;
use BBlm\Entity\TeamVersion;

interface RuleInterface {
    public function getKey():string;
    public function getActionsFormClass():string;
    public function getInjuriesFormClass():string;
    public function getTemplateKey():string;
    public function attachRule(Rule $rule):self;
    public function getAttachedRule():Rule;
    public function getInjuriesTable():array;
    public function getInjury($key):?object;
    public function getSppLevel($spp):?string;
    public function calculateTeamValue(TeamVersion $version, bool $excludeDisposable = false):?int;
    public function calculateTeamRate(TeamVersion $version):?int;
    public function playerIsDisposable(PlayerVersion $playerVersion):bool;
}
