<?php

namespace BBlm\Service\TieBreaker;

interface TieBreakerInterface {
    /**
     * Returns the key name to be store in database in tie breakers Championship values.
     *
     * @return string
     */
    public function getKey():string;
    public function getOrderingForCriteria():array;
}