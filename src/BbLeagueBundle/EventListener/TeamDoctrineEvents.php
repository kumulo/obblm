<?php
namespace BbLeagueBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use BbLeagueBundle\Entity\Team;
use BbLeagueBundle\Entity\TeamByJourney;
use BbLeagueBundle\Entity\Player;
use BbLeagueBundle\Entity\PlayerByJourney;

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
        $entityManager = $args->getEntityManager();
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
        // Only act on "TeamByJourney" entity
        if ($entity instanceof TeamByJourney) {
            $this->addJourneyMen($entity, $entityManager);
        }
    }
    private function addJourneyMen($entity, $entityManager) {
        $rules = $this->container->get('bb.rules');
        $diff = 11 - (count($entity->getAvailaiblePlayers()) - count($entity->getInjuredPlayers()));
        $rule = $rules->getRule($entity->getTeam()->getLeague()->getRule())->getRule();
        $base_players = $rule['rosters'][$entity->getTeam()->getRoster()]['players'];
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
                $player->setTeam($entity->getTeam());
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
            $entityManager->persist($entity);
            $entityManager->flush();
            dump($entity);
        }
    }
}
