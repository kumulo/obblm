<?php

// src/BbLeagueBundle/Repository/TeamRepository.php
namespace BbLeagueBundle\Repository;

use BbLeagueBundle\Entity\League;
use BbLeagueBundle\Services\TieBreaks\TieBreakInterface;
use BbLeagueBundle\Services\TieBreakService;
use Doctrine\ORM\EntityRepository;

class TeamByJourneyRepository extends EntityRepository
{
    public function findTeamsByLeagueWithTiebreaks(League $league, TieBreakService $tiebreaks)
    {
        $journey = $league->getCurrentJourney();
        $qb = $this->createQueryBuilder('t');
        $qb->where('t.journey = :journey')
            ->setParameter('journey', $journey);
        /** @var TieBreakInterface $tiebreak */
        foreach ($league->getTieBreaks() as $tiebreak) {
            $qb = $tiebreaks->get($tiebreak)->updateTieBreakQuery($qb);
        }

        return $qb->getQuery()->execute();
    }
}