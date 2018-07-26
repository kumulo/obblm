<?php

namespace BbLeagueBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
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

    }

    public function addTieBreak($tiebreak) {
        $this->tiebreaks->add($tiebreak);
    }
}
