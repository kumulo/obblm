<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class TeamComposition extends Constraint {

    public $limitMessage = 'constraints.team.composition.violation';

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }
}
