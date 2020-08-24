<?php

namespace App\Service\TieBreaker;

use App\Traits\ServiceKeyTrait;

abstract class AbstractTieBreaker implements TieBreakerInterface {
    use ServiceKeyTrait;
}