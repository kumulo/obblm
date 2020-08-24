<?php

namespace App\Traits;

trait ServiceKeyTrait {
    /**
     * @internal
     */
    public function getKey()
    {
        return get_class($this);
    }
}