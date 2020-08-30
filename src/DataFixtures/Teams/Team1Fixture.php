<?php

namespace App\DataFixtures\Teams;

use App\DataFixtures\ChampionshipFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class Team1Fixture extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use TeamFixtureTrait;

    public function load(ObjectManager $em)
    {
        $this->setChampionship($this->getReference(ChampionshipFixtures::CHAMPIONSHIP_REFERENCE))
            ->setCoach($this->getReference(CoachFixtures::COACH_USER_REFERENCE . '-1'));

        $data = [
            'name' => 'Team Dwarf',
            'roster' => 'dwarf',
            'rerolls' => 3,
            'apothecary' => false,
            'positions' => [
                'slayer' => 2,
                'runner' => 2,
                'blitzer' => 2,
                'blocker' => 5,
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