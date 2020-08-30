<?php

namespace App\DataFixtures;

use App\Entity\Rule;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TeamFixtures extends Fixture implements DependentFixtureInterface
{
    public const TEAM_REFERENCE_CHAMPIONSHIP = 'team_by_championship';
    public const TEAM_REFERENCE_RULE = 'team_by_rule';

    public function load(ObjectManager $em)
    {
        $rule = $em->getRepository(Rule::class)->find(1);
        $team2 = (new Team())
            ->setName('Team test by rule')
            ->setRoster('dark_elf')
            ->setCoach($this->getReference(CoachFixtures::COACH_USER_REFERENCE))
            ->setRule($rule);
        $em->persist($team2);
        $this->addReference(self::TEAM_REFERENCE_RULE, $team2);

        $em->flush();
    }

    public function getDependencies()
    {
        return array(
            CoachFixtures::class,
            ChampionshipFixtures::class,
        );
    }
}