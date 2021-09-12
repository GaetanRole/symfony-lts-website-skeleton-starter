<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Exception;
use App\Entity\User;
use App\Service\GlobalClock;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @see     https://symfony.com/doc/master/bundles/DoctrineFixturesBundle/index.html
 *
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
final class UserFixtures extends Fixture
{
    /** @var int public CONST for Users number in DB */
    public const USER_NB_TUPLE = 20;

    /**
     * To encode password with injected service.
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * Global project's clock.
     * @var GlobalClock
     */
    private $clock;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        GlobalClock $clock,
        ContainerInterface $container
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->clock = $clock;
    }

    /**
     * Load ten users to DB.
     * @see  \Doctrine\Persistence\ObjectManager Real object needed by the load method() to avoid deprecation
     * @throws Exception From DateTimes
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadUsers($manager);
    }

    /**
     * @throws Exception From DateTimes
     */
    private function loadUsers(ObjectManager $manager): void
    {
        // Loading USER_NB_TUPLE users with different information by concat
        // Enter a DateTime now by TimeContinuum service
        // E.g : Login : user0@userfixtures.fixtures
        //     : Password : password0

        $roles = ['ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN'];

        for ($i = 0; $i < self::USER_NB_TUPLE; $i++) {
            $user = new User();
            $user->setFirstName("FirstName" . $i)
                ->setLastName("LastName" . $i)
                ->setPhoneNumber("0600000000")
                ->setBirthDate($this->clock->getBirthDateSample())
                ->setEmail('user' . $i . '@userfixtures.fixtures')
                ->setPassword($this->passwordEncoder->encodePassword($user, 'password' . $i))
                ->setRoles([$roles[array_rand($roles)]])
                ->setCreatedAt($this->clock->getNowInDateTime());

            $manager->persist($user);
        }

        $manager->flush();
    }
}
