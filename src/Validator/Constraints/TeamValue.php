<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class TeamValue extends Constraint {

    const LIMIT = 1000000;

    public $limitMessage = 'constraints.team.value.violation';

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}
