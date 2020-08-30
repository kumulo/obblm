<?php

namespace App\Service;

use App\Service\TieBreaker\TieBreakerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Translation\DataCollectorTranslator;

class TieBreakService {

    private $tiebreaks;

    public function __construct() {
        $this->tiebreaks = new ArrayCollection();
    }

    /*
     * @return ArrayCollection
     */
    public function getTieBreaks() {
        return $this->tiebreaks;
    }
    public function getTieBreaksForForm() {
        $tiebreaks = [];
        foreach ($this->tiebreaks as $key => $tiebreak) {
            if(!$tiebreak instanceof TieBreakerInterface) {
                throw new UnexpectedTypeException($tiebreak, TieBreakerInterface::class);
            }
            $tiebreaks[$key] = $tiebreak->getKey();
        }
        return $tiebreaks;
    }

    public function get($key)
    {
        if (!isset($this->tiebreaks[$key])) {
            return false;
        }

        return $this->tiebreaks[$key];
    }
    public function addTieBreak(TieBreakerInterface $tiebreak) {
        $this->tiebreaks->offsetSet($tiebreak->getKey(), $tiebreak);
    }
}
