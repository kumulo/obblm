<?php

namespace App\DataFixtures;

use App\Entity\Coach;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CoachFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $coach = (new Coach())
            ->setEmail('toto@toto.com');
        $password = $this->encoder->encodePassword($coach, 'toto');
        $coach->setPassword($password);
        $manager->persist($coach);

        $manager->flush();
    }
}
