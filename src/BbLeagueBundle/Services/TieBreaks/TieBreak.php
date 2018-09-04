<?php

namespace BbLeagueBundle\Services\TieBreaks;

use Doctrine\ORM\EntityManager;

abstract class TieBreak implements TieBreakInterface {

    protected $em;

    public function __construct(EntityManager $em, $options = array()) {
        $this->em = $em;
    }

    public function getClassName() {
        return self::class;
    }
}
