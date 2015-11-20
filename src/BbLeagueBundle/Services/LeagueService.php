<?php

namespace BbLeagueBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use BbLeagueBundle\Entity\League;
use BbLeagueBundle\Entity\Journey;
use BbLeagueBundle\Entity\TeamByJourney;
use BbLeagueBundle\Entity\Match;

class LeagueService {
    private $em;
    private $translator;
    private $league = false;
    private $numberOfJouneys = 1;
    private $avaibleTeams = array();
    private $isOdd = false;

    public function __construct(\Doctrine\ORM\EntityManager $entity_manager, $translator) {
        $this->em = $entity_manager;
        $this->translator = $translator;
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $entity_manager) {
        $this->em = $entity_manager;
        return $this;
    }
    public function setNumberOfJourneys($num = 1) {
        $this->numberOfJouneys = $num;
        return $this;
    }
    public function setLeague(League $league) {
        $this->league = $league;
        $this->avaibleTeams = $this->league->getTeams();
        if(!count($this->avaibleTeams)%2) {
            $this->isOdd = true;
        }
        return $this;
    }

    public function renderJourneys() {
        if(!$this->league || !$this->league->getValid())
        {
            return false;
        }
        for($i = 1; $i <= $this->numberOfJouneys; $i++) {
            $j = new Journey();
            $name = $this->translator->trans('specials.league_journey_count', array('%count%' => $i));
            $j->setName($name);
            $j->setLeague($this->league);
            $j = $this->renderMatchs($j);
            //dump($j->getMatchs());
            if(count($j->getMatchs()) > 0) {
                $this->league->addJourney($j);
                $this->em->persist($j);
            }
            else {
               $i = $this->numberOfJouneys;
            }
        }
        $this->em->persist($this->league);
        $this->em->flush();
        return $this->league;
    }
    private function renderMatchs(Journey $j) {
        $temp = new ArrayCollection( $this->avaibleTeams->toArray() );

        while(count($temp) > 1) {
            $match = new Match();
            $match->setJourney($j);
            $t1 = $temp->first();
            $temp->removeElement($t1);
            $match->setTeam($t1);
            $not_view = new ArrayCollection( $temp->toArray() );
            if(count($not_view) > 0) {
                foreach($t1->getEncounters() as $encounter) {
                    $not_view->removeElement($encounter);
                }
                $t2 = $not_view->first();
                if($t2) {
                    $temp->removeElement($t2);
                    $match->setVisitor($t2);
                    $t1->addMatch($match);
                    $t2->addMatch($match);
                    $j->addMatch($match);
                    $this->em->persist($match);
                }
            }
        }
        $temp->clear();
        return $j;
    }
    /**
     * Generate new TeamJouney entity
     *
     * @param \BbLeagueBundle\Entity\Team $team
     * @param \BbLeagueBundle\Entity\Jouney $match_jouney
     * @param Array $actions_give
     * @param Array $actions_take

     */
    public function generateMatchTeamJourney(
            \BbLeagueBundle\Entity\Team $team,
            \BbLeagueBundle\Entity\Jouney $match_jouney,
            Array $actions_give,
            Array $actions_take) {

        $last_journey = $match->getTeam()->getLastJourney();
        $new_journey = new TeamByJourney();
        $new_journey->setJourney($match_jouney)
            ->setTeam($team)
            ->setWinMatch( $last_journey->getWinMatch() + 0 )
            ->setDrawMatch( $last_journey->getDrawMatch() + 0 )
            ->setLostMatch( $last_journey->getLostMatch() + 0 )
            ->setTdGive( $last_journey->getTdGive() + 0 )
            ->setTdTake( $last_journey->getTdTake() + 0 )
            ->setInjuryGive( $last_journey->getInjuryGive() + 0 )
            ->setInjuryTake( $last_journey->getInjuryTake() + 0 )
            ->setPass( $last_journey->getPass() + 0 )
            ->setRedCard( $last_journey->getRedCard() + 0 )
            ->setRerolls( $last_journey->getRerolls() + 0 )
            ->setTreasure( $last_journey->getTreasure() + 0 )
            ->setPopularity( $last_journey->getPopularity() + 0 )
            ->setAssistants( $last_journey->getAssistants() + 0 )
            ->setCheerleaders( $last_journey->getCheerleaders() + 0 )
            ->setApothecary( $last_journey->getApothecary() + 0 );
        $team->addJourney($new_journey);
        return $new_journey;
    }
}
