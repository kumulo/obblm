<?php

namespace BBlm\DataFixtures\Teams\Championship1;

use BBlm\DataFixtures\ChampionshipFixtures;
use BBlm\DataFixtures\Teams\CoachFixtures;
use BBlm\DataFixtures\Teams\TeamFixtureTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TeamHightElfFixture extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    use TeamFixtureTrait;

    const COACH_NUMBER = 10;

    public function load(ObjectManager $em)
    {
        $this->setChampionship($this->getReference(ChampionshipFixtures::CHAMPIONSHIP_REFERENCE))
            ->setCoach($this->getReference( CoachFixtures::COACH_USER_REFERENCE . '-' . self::COACH_NUMBER));

        $data = [
            'name' => 'Team Hight Elf',
            'roster' => 'high_elf',
            'rerolls' => 3,
            'apothecary' => false,
            'positions' => [
                'blitzer' => 2,
                'catcher' => 1,
                'lineman' => 8,
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