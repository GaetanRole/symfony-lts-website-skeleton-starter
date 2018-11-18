<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        /*
         * $user = new User();
         *  $user->setPassword($this->passwordEncoder->encodePassword(
         *  $user,
         *  'the_new_password'
         * ));

           -> Add all necessary fields.

         * $manager->flush();
         *
         */
    }
}
