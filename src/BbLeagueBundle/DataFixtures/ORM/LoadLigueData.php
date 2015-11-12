<?php

namespace BbLeagueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use BbLeagueBundle\Entity\League;

class LoadLeagueData implements FixtureInterface {

    public function load(ObjectManager $manager) {
        /* Load Features */
        \Nelmio\Alice\Fixtures::load(__DIR__.'/files/datas.yml', $manager);

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
