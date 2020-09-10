<?php

namespace BBlm\DataFixtures\Teams\Championship1;

use BBlm\DataFixtures\ChampionshipFixtures;
use BBlm\DataFixtures\Teams\CoachFixtures;
use BBlm\DataFixtures\Teams\TeamFixtureTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TeamDwarfFixture extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use TeamFixtureTrait;

    const COACH_NUMBER = 6;

    public function load(ObjectManager $em)
    {
        $this->setChampionship($this->getReference(ChampionshipFixtures::CHAMPIONSHIP_REFERENCE))
            ->setCoach($this->getReference( CoachFixtures::COACH_USER_REFERENCE . '-' . self::COACH_NUMBER));

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