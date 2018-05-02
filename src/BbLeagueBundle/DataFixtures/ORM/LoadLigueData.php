<?php

namespace BbLeagueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use BbLeagueBundle\Entity\League;

class LoadLigueData implements FixtureInterface, ContainerAwareInterface {

    private $container;

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        /* Load Features */
        $datas = \Nelmio\Alice\Fixtures::load(__DIR__.'/files/datas.yml', $manager);
        $manager->flush();

        /* Generate Random Matchs */
        $datas['league1']->setValid(true);
        $tools = $this->container->get('bb.league.tools');
        $tools->setNumberOfJourneys(99);
        $tools->setLeague($datas['league1']);
        $league = $tools->renderJourneys();
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
