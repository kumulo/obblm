<?php

namespace App\DataFixtures;

use App\Entity\Rule;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TeamFixtures extends Fixture implements DependentFixtureInterface
{
    public const TEAM_REFERENCE = 'team';

    public function load(ObjectManager $em)
    {
        $team = (new Team())
            ->setName('Team test by championship')
            ->setCoach($this->getReference(CoachFixtures::COACH_USER_REFERENCE))
            ->setChampionship($this->getReference(ChampionshipFixtures::CHAMPIONSHIP_REFERENCE));
        $em->persist($team);
        $this->addReference(self::TEAM_REFERENCE_CHAMPIONSHIP, $team);

        $rule = $em->getRepository(Rule::class)->find(1);
        $team2 = (new Team())
            ->setName('Team test by rule')
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