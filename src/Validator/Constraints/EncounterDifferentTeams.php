<?php

namespace BBlm\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use function get_class;

class EncounterDifferentTeams extends Constraint {

    public $limitMessage = 'constraints.encounter.different_teams.violation';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
