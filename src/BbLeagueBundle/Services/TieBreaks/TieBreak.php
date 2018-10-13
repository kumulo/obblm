<?php

namespace BbLeagueBundle\Services\TieBreaks;

abstract class TieBreak implements TieBreakInterface {

    public function __construct($options = [])
    {
    }

    public function getClassName() {
        return self::class;
    }
}
