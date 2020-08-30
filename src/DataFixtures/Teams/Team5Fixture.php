<?php

namespace App\DataFixtures\Teams;

use App\DataFixtures\ChampionshipFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Team5Fixture extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use TeamFixtureTrait;
    
    public function load(ObjectManager $em)
    {
        $this->setChampionship($this->getReference(ChampionshipFixtures::CHAMPIONSHIP_REFERENCE))
            ->setCoach($this->getReference(CoachFixtures::COACH_USER_REFERENCE . '-5'));

        $data = [
            'name' => 'Team Ogre',
            'roster' => 'ogre',
            'rerolls' => 3,
            'apothecary' => true,
            'positions' => [
                'ogre' => 4,
                'snotling' => 9,
            ],
        ];

        $team = $this->loadTeamByArray($data);
        $em->persist($team);
        $em->flush();
    }

    public function getDependencies()
    {
        return array(
            CoachFixtures::class,
            ChampionshipFixtures::class,
        );
    }

    public static function getGroups(): array
    {
        return ['teams'];
    }
}