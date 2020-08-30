<?php

namespace App\DataFixtures;

use App\Entity\Championship;
use App\Entity\Rule;
use App\Service\ChampionshipFormat\OpenChampionshipFormat;
use App\Service\TieBreaker\InjuryPlusTieBreak;
use App\Service\TieBreaker\TouchdownPlusTieBreak;
use App\Service\TieBreaker\VictoryTieBreak;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ChampionshipFixtures extends Fixture implements DependentFixtureInterface
{
    public const CHAMPIONSHIP_REFERENCE = 'championship';

    public function load(ObjectManager $em)
    {
        $rule = $em->getRepository(Rule::class)->find(1);
        $championship = (new Championship())
            ->setName('Championship test')
            ->setRule($rule)
            ->setFormat(OpenChampionshipFormat::FORMAT)
            ->setTieBreak1(VictoryTieBreak::KEY)
            ->setTieBreak2(TouchdownPlusTieBreak::KEY)
            ->setTieBreak3(InjuryPlusTieBreak::KEY)
            ->setMaxTeams(16)
            ->setLeague($this->getReference(LeagueFixtures::LEAGUE_REFERENCE))
            ->addManager($this->getReference(CoachFixtures::MANAGER_USER_REFERENCE));
        $em->persist($championship);
        $this->addReference(self::CHAMPIONSHIP_REFERENCE, $championship);

        $em->flush();
    }

    public function getDependencies()
    {
        return array(
            LeagueFixtures::class,
        );
    }
}