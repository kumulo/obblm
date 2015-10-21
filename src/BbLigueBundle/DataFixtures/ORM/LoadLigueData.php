<?php

namespace BbLigueBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use BbLigueBundle\Entity\Ligue;

class LoadLigueData implements FixtureInterface {

    public function load(ObjectManager $manager) {
        /* Ligue */
        $objects = \Nelmio\Alice\Fixtures::load(__DIR__.'/files/datas.yml', $manager);

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
