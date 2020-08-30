<?php

namespace App\Service\ChampionshipFormat;

use App\Entity\Championship;
use App\Entity\Game;
use App\Entity\Journey;
use App\Traits\ClassNameAsKeyTrait;

abstract class AbstractChampionshipFormat {
    use ClassNameAsKeyTrait;

    const FORMAT = 'format.default';
    const ENDS_WITH_PLAYOFF = true;

    public function getKey():string
    {
        return get_class($this)::FORMAT;
    }

    public function getFormat():string
    {
        return get_class($this)::FORMAT;
    }
    public function onLaunched(Championship $championship):Championship {
        return $championship;
    }
    public function onGameValidate(Championship $championship, Game $game):Championship {
        return $championship;
    }
    public function onJourneyClose(Championship $championship, Journey $journey):Championship {
        return $championship;
    }
}