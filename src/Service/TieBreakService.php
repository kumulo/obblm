<?php

namespace BBlm\Service;

use BBlm\Entity\Championship;
use BBlm\Service\TieBreaker\TieBreakerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

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

    public function get($key):?TieBreakerInterface
    {
        if (!isset($this->tiebreaks[$key])) {
            return false;
        }

        return $this->tiebreaks[$key];
    }
    public function addTieBreak(TieBreakerInterface $tiebreak) {
        $this->tiebreaks->offsetSet($tiebreak->getKey(), $tiebreak);
    }

    public function applyTieBreaks(Championship $championship, ArrayCollection $collection) {
        $criteria = Criteria::create();
        $ordering = ['points' => 'DESC'];
        if($championship->getTieBreak1()) {
            $tb = $this->get($championship->getTieBreak1());
            $ordering = array_merge($ordering, $tb->getOrderingForCriteria());
        }
        if($championship->getTieBreak2()) {
            $tb = $this->get($championship->getTieBreak2());
            $ordering = array_merge($ordering, $tb->getOrderingForCriteria());
        }
        if($championship->getTieBreak3()) {
            $tb = $this->get($championship->getTieBreak3());
            $ordering = array_merge($ordering, $tb->getOrderingForCriteria());
        }
        $criteria->orderBy($ordering);
        return $collection->matching($criteria);
    }
}
