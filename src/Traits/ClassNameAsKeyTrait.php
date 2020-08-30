<?php

namespace App\Traits;

trait ClassNameAsKeyTrait {
    /**
     * @internal
     */
    public function getKey()
    {
        return get_class($this);
    }
}