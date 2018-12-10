<?php

/**
 * User Fixture file
 *
 * PHP Version 7.2
 *
 * @category User
 * @package  App\DataFixtures
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace App\DataFixtures;

use App\Entity\User;
use Faker;
use App\Service\GlobalClock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * User Fixture class
 *
 * @category User
 * @package  App\DataFixtures
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
final class UserFixture extends Fixture
{
    /**
     * To encode password with injected service
     *
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * Global project's clock
     *
     * @var GlobalClock
     */
    private $clock;

    /**
     * Injecting Container Interface
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * UserFixture constructor.
     *
     * @param UserPasswordEncoderInterface $passwordEncoder Var to encode password
     * @param GlobalClock $clock Global project's clock
     * @param ContainerInterface $container Container Interface
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        GlobalClock $clock,
        ContainerInterface $container
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->clock = $clock;
        $this->container = $container;
    }

    /**
     * Load ten users to DB
     *
     * @param ObjectManager $manager Doctrine Manager
     *
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // Loading ten users with different information by concat
        // Enter a DateTime now by TimeContinuum service
        // E.g : Login : user0@userfixtures.fixtures
        //     : Password : password0

        $faker
            = Faker\Factory::create($this->container->getParameter('locale'));

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user
                ->setEmail('user' . $i . '@userfixtures.fixtures')
                ->setPassword(
                    $this->passwordEncoder->encodePassword(
                        $user,
                        'password' . $i
                    )
                )
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPhoneNumber($faker->phoneNumber)
                ->setBirthDate($this->clock->getBirthDateSample())
                ->setCreationDate($this->clock->getNowInDateTime());
            $manager->persist($user);
        }
        $manager->flush();
    }
}
