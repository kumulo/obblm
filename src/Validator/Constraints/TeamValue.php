<?php

namespace BBlm\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use function get_class;

class TeamValue extends Constraint {

    const LIMIT = 1000000;

    public $limitMessage = 'constraints.team.value.violation';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
