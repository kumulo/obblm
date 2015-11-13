<?php

namespace BbLeagueBundle\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\ArrayCollection;
use BbLeagueBundle\Entity\League;
use BbLeagueBundle\Entity\Journey;
use BbLeagueBundle\Entity\Match;

class LeagueService {
    private $em;
    private $translator;
    private $league = false;
    private $numberOfJouneys = 1;
    private $avaibleTeams = array();
    private $isOdd = false;

    public function __construct(EntityManager $entity_manager, $translator) {
        $this->em = $entity_manager;
        $this->translator = $translator;
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
        if(!$this->league)
        {
            return false;
        }
        for($i = 1; $i <= $this->numberOfJouneys; $i++) {
            $j = new Journey();
            $name = $this->translator->trans('specials.league_journey_count', array('%count%' => $i));
            $j->setName($name);
            $j->setLeague($this->league);
            if($i>0) {
                $matchs = $this->renderMatchs($j);
            }
            if(count($j->getMatchs()) > 0) {
                $this->league->addJourney($j);
            }
        }
        return $this->league->getJourneys()->toArray();
    }
    private function renderMatchs(Journey $j) {
        $temp = new ArrayCollection( $this->avaibleTeams->toArray() );

        while(count($temp) > 1) {
            $match = new Match();
            $match->setJourney($j);
            $t1 = $temp->get(array_rand($temp->toArray()));
            $temp->removeElement($t1);
            $match->setTeam($t1);
            $not_view = new ArrayCollection( $temp->toArray() );
            if(count($not_view) > 0) {
                foreach($t1->getEncounters() as $encounter) {
                    $not_view->removeElement($encounter);
                }
                $t2 = $not_view->get(array_rand($not_view->toArray()));
                if($t2) {
                    $temp->removeElement($t2);
                    $match->setVisitor($t2);
                    $t1->addMatch($match);
                    $t2->addMatch($match);
                    $j->addMatch($match);
                }
            }
        }
        $temp->clear();
    }
}
