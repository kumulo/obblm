<?php

namespace App\Service\ChampionshipFormat;

use App\Traits\ServiceKeyTrait;

abstract class AbstractChampionshipFormat {
    use ServiceKeyTrait;

    const OPEN = 'format.open';
    const TOURNAMENT = 'format.tournament';
    const JOURNEY = 'format.journey';

    const ENDS_WITH_PLAYOFF = true;
}