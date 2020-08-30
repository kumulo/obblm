<?php

namespace App\DataFixtures\Teams;

use App\DataFixtures\ChampionshipFixtures;
use App\Entity\Championship;
use App\Entity\Coach;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CoachFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private $encoder;
    public const COACH_USER_REFERENCE = 'coach-user';

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $em)
    {
        /** @var Championship $championship */
        $championship = $this->getReference(ChampionshipFixtures::CHAMPIONSHIP_REFERENCE);
        for($i=1; $i <= 8; $i++) {
            $coach = (new Coach())
                ->setEmail('coach-' . $i . '@obblm.com')
                ->setUsername('coach' . $i);
            $password = $this->encoder->encodePassword($coach, 'coach');
            $coach->setPassword($password);
            $championship->addGuest($coach);
            $em->persist($coach);
            $em->persist($championship);
            $this->addReference(self::COACH_USER_REFERENCE . '-' . $i, $coach);
        }
        $em->flush();
    }

    public function getDependencies()
    {
        return array(
            ChampionshipFixtures::class,
        );
    }

    public static function getGroups(): array
    {
        return ['coach'];
    }
}
