<?php

namespace BBlm\Service\Rule;

use BBlm\Form\Encounter\ActionBb2020Type;

class Bb2020Rule extends AbstractRule {
    public function getActionsFormClass(): string
    {
        return ActionBb2020Type::class;
    }
    public function getKey(): string
    {
        return 'bb2020';
    }
}
