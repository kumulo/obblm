<?php

namespace App\Service\ChampionshipFormat;

interface ChampionshipFormatInterface {
    /**
     * Returns the key name to be store in database in format Championship value.
     *
     * @return string
     */
    public function getKey();

    /**
     * Returns the key name to be store in database in format Championship value.
     *
     * @return string
     */
    public function getFormat();
}