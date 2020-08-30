<?php

namespace App\Service\TieBreaker;

use App\Traits\ClassNameAsKeyTrait;

abstract class AbstractTieBreaker implements TieBreakerInterface {
    use ClassNameAsKeyTrait;

    const KEY = 'tiebreak.default';
    const ENDS_WITH_PLAYOFF = true;

    public function getKey():string
    {
        return get_class($this)::KEY;
    }
}