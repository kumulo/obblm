<?php

namespace BbLeagueBundle\Services;

use BbLeagueBundle\Services\TieBreaks\TieBreakInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Translation\DataCollectorTranslator;

class TieBreakService {

    private $em;
    private $translator;
    private $tiebreaks;
    private $handlers;
    private $container;

    public function __construct(EntityManager $entity_manager,
                                DataCollectorTranslator $translator,
                                iterable $handlers) {
        $this->em = $entity_manager;
        $this->translator = $translator;
        $this->handlers = $handlers;

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
            /** @var TieBreakInterface $tiebreak */
            $tiebreaks[$key] = $tiebreak->getName();
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
    public function addTieBreak(TieBreakInterface $tiebreak) {
        $this->tiebreaks->offsetSet($tiebreak->getName(), $tiebreak);
    }
}
