<?php

namespace BbLeagueBundle\Services;

use BbLeagueBundle\Entity\Encounter;
use BbLeagueBundle\Entity\Journey;
use BbLeagueBundle\Entity\League;
use BbLeagueBundle\Entity\Team;
use BbLeagueBundle\Entity\TeamByJourney;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;

class LeagueService {
    private $em;
    private $translator;
    /** @var League $league */
    private $league = false;
    private $numberOfJouneys = 1;
    private $avaibleTeams = array();

    public function __construct(EntityManager $entity_manager, $translator)
    {
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
            $j = $this->renderEncounters($j);
            if (count($j->getEncounters()) > 0) {
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

    private function renderEncounters(Journey $j)
    {
        $temp = new ArrayCollection( $this->avaibleTeams->toArray() );

        while(count($temp) > 1) {
            $encounter = new Encounter();
            $encounter->setJourney($j);
            /** @var Team $t1
             * @var Team $t2
             */
            $t1 = $temp->first();
            $temp->removeElement($t1);
            $encounter->setTeam($t1);
            $not_view = new ArrayCollection( $temp->toArray() );
            if(count($not_view) > 0) {
                foreach($t1->getEncounters() as $encounter) {
                    $not_view->removeElement($encounter);
                }
                $t2 = $not_view->first();
                if($t2) {
                    $temp->removeElement($t2);
                    $encounter->setVisitor($t2);
                    $t1->addEncounter($encounter);
                    $t2->addEncounter($encounter);
                    $j->addEncounter($encounter);
                    $this->em->persist($encounter);
                }
            }
        }
        $temp->clear();
        return $j;
    }
    /**
     * Generate new TeamJouney entity
     *
     * @param Team $team
     * @param Journey $encounter_jouney
     */
    public function generateEncounterTeamJourney(Team $team, Journey $encounter_journey) {
        $last_journey = $team->getLastJourney();
        $new_journey = new TeamByJourney();
        $new_journey->setJourney($encounter_journey)
            ->setTeam($team)
            ->setWinEncounter($last_journey->getWinEncounter() + 0)
            ->setDrawEncounter($last_journey->getDrawEncounter() + 0)
            ->setLostEncounter($last_journey->getLostEncounter() + 0)
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
