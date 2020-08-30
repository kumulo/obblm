<?php

namespace App\DataFixtures\Teams;

use App\DataFixtures\ChampionshipFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Team6Fixture extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use TeamFixtureTrait;
    
    public function load(ObjectManager $em)
    {
        $this->setChampionship($this->getReference(ChampionshipFixtures::CHAMPIONSHIP_REFERENCE))
            ->setCoach($this->getReference(CoachFixtures::COACH_USER_REFERENCE . '-6'));

        $data = [
            'name' => 'Team Necromantic',
            'roster' => 'necromantic',
            'rerolls' => 3,
            'apothecary' => false,
            'positions' => [
                'golem' => 2,
                'werewolf' => 1,
                'wight' => 2,
                'ghoul' => 1,
                'zombi' => 5,
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