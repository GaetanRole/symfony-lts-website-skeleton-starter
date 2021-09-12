<?php

declare(strict_types=1);

namespace App\Listener;

use Exception;
use App\Entity\User;
use App\Service\GlobalClock;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * A simple listener updating User last login attribute.
 *
 * @author  Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
class AuthenticationListener
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * @var GlobalClock
     */
    private $clock;

    public function __construct(EntityManagerInterface $entityManager, GlobalClock $clock)
    {
        $this->entityManager = $entityManager;
        $this->clock = $clock;
    }

    /**
     * @throws Exception From DateTimes
     */
    public function __invoke(InteractiveLoginEvent $event): void
    {
        /** @var User $user Get the User entity. */
        $user = $event->getAuthenticationToken()->getUser();

        // Set the last login attr.
        $user->setLastLogin($this->clock->getNowInDateTime());

        $this->entityManager->flush();
    }
}
