<?php

namespace BbLeagueBundle\DataFixtures\ORM;

use BbLeagueBundle\Services\LeagueService;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadLigueData implements FixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        /* Load Features */
        $datas = Fixtures::load(__DIR__.'/files/datas.yml', $manager);
        $manager->flush();

        /* Generate Random Encounters */
        $datas['league1']->setValid(true);
        /** @var LeagueService $tools */
        $tools = $this->container->get('bb.league.tools');
        $tools->setNumberOfJourneys(99);
        $tools->setLeague($datas['league1']);
        //$league = $tools->renderJourneys();
        /* End */
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }

}
