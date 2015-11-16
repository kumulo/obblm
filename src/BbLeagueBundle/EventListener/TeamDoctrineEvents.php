<?php
namespace BbLeagueBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use BbLeagueBundle\Entity\Team;
use BbLeagueBundle\Entity\TeamByJourney;
use BbLeagueBundle\Entity\Player;
use BbLeagueBundle\Entity\PlayerByJourney;
use BbLeagueBundle\Entity\Match;
use BbLeagueBundle\Entity\Journey;

class TeamDoctrineEvents
{
    private $app_dir;
    private $web_dir;
    private $upload_dir;
    private $container;

    public function __construct($app_dir, $web_dir, $upload_dir, $container) {
        $this->app_dir = $app_dir;
        $this->web_dir = $web_dir;
        $this->upload_dir = $upload_dir;
        $this->container = $container;
    }
    public function setBbRules($bb_rules) {
        $this->bb_rules = $bb_rules;
    }
    protected function getUploadDir()
    {
        return $this->app_dir . $this->web_dir . $this->upload_dir;
    }
    /** postLoad */
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        // Only act on "Team" entity
        if ($entity instanceof Team) {
            $entity->setAbsPath( $this->getUploadDir() );
            $entity->setWebPath( $this->upload_dir );
        }
    }
    /** postPersist */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        // Only act on "TeamByJourney", "Match" entity
        if ($entity instanceof TeamByJourney) {
            $this->addJourneyMen($entity, $entityManager);
        }
        else if($entity instanceof Match) {
            $this->afterMatchSequence($entity, $entityManager);
        }
    }
    /**
     * Generate after match sequency (including TeamJouney entities)
     *
     * @param \BbLeagueBundle\Entity\Match $match
     * @param \Doctrine\ORM\EntitytManager $entityManager
     */
    private function afterMatchSequence(Match $match, EntitytManager $entityManager) {

        $actions_home = array();
        $actions_visitor = array();

        $this->tools = $container->get('bb.league.tools');
        $new_journey_home = $this->tools->generateTeamJourney(
            $match->getJourney(),
            $match->getTeam(),
            $actions_home,
            $actions_visitor
        );
        $new_journey_visitor = $this->tools->generateTeamJourney(
            $match->getJourney(),
            $match->getVisitor(),
            $actions_visitor,
            $actions_home
        );
        $entityManager->persist($new_journey_home);
        $entityManager->persist($new_journey_visitor);
        $entityManager->flush();
    }
    /**
     * Generate Team JourneyMen after an encounter
     *
     * @param \BbLeagueBundle\Entity\TeamByJourney $team_journey
     * @param \Doctrine\ORM\EntitytManager $entityManager
     */
    private function addJourneyMen(TeamByJourney $team_journey, EntitytManager $entityManager) {
        $rules = $this->container->get('bb.rules');
        $diff = 11 - (count($team_journey->getAvailaiblePlayers()) - count($team_journey->getInjuredPlayers()));
        $rule = $rules->getRule($team_journey->getTeam()->getLeague()->getRule())->getRule();
        $base_players = $rule['rosters'][$team_journey->getTeam()->getRoster()]['players'];
        $base_journeyman = false;
        $base_journeyman = false;
        foreach($base_players as $key => $player) {
            if($player['is_journeyman']) {
                $base_journeyman_name = $key;
                $base_journeyman = $player;
            }
        }
        if($diff > 0 && $base_journeyman) {
            for($i = 0; $i < $diff; $i++) {
                $player = new Player();
                $player->setPosition(17 + $i);
                $player->setTeam($team_journey->getTeam());
                $player->setName("Player " . ($i+1));
                $player->setType($base_journeyman_name);
                $jplayer = new PlayerByJourney();
                $jplayer->setJourney($entity);
                $jplayer->setPlayer($player);
                $jplayer->setMove($base_journeyman['ma']);
                $jplayer->setStrenght($base_journeyman['st']);
                $jplayer->setAgility($base_journeyman['ag']);
                $jplayer->setAverage($base_journeyman['av']);
                $jplayer->setSkills($base_journeyman['skills']);
                $jplayer->setValue($base_journeyman['cost']);
                $player->addJourney($jplayer);
                $entity->addPlayer($jplayer);
                $entityManager->persist($player);
                $entityManager->persist($jplayer);
            }
            $entityManager->persist($team_journey);
            $entityManager->flush();
        }
    }
}
