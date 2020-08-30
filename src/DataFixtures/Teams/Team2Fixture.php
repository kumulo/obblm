<?php

namespace App\DataFixtures\Teams;

use App\DataFixtures\ChampionshipFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Team2Fixture extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use TeamFixtureTrait;
    
    public function load(ObjectManager $em)
    {
        $this->setChampionship($this->getReference(ChampionshipFixtures::CHAMPIONSHIP_REFERENCE))
            ->setCoach($this->getReference(CoachFixtures::COACH_USER_REFERENCE . '-2'));

        $data = [
            'name' => 'Team Snot',
            'roster' => 'snotling',
            'rerolls' => 4,
            'apothecary' => true,
            'positions' => [
                'troll' => 2,
                'pump_wagon' => 2,
                'runna' => 2,
                'hoppa' => 2,
                'fungus' => 2,
                'snotling' => 6,
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