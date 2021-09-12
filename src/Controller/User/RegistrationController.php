<?php

declare(strict_types=1);

namespace App\Controller\User;

use Exception;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use App\Service\GlobalClock;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/user", name="app_user_")
 *
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
class RegistrationController extends AbstractController
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** @var GuardAuthenticatorHandler */
    private $handler;

    /** @var LoginFormAuthenticator */
    private $authenticator;

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        GuardAuthenticatorHandler $handler,
        LoginFormAuthenticator $authenticator,
        EntityManagerInterface $entityManager
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->handler = $handler;
        $this->authenticator = $authenticator;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/registration", name="registration", methods={"GET", "POST"})
     * @throws Exception Datetime Exception
     */
    public function register(
        Request $request,
        Security $security,
        GlobalClock $clock,
        TranslatorInterface $translator
    ): Response {
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('danger', $translator->trans('is_authenticated_fully.flash.redirection', [], 'flashes'));
            return $this->redirectToRoute('app_index');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the password (you could also do this via Doctrine listener)
            $user->setPassword($this->passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));
            // Using TimeContinuum to have power on time unit
            $user->setCreatedAt($clock->getNowInDateTime());

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Add a notification on security/login.html.twig
            $this->addFlash(
                'success',
                $translator->trans('account_registered.flash.redirection', [], 'flashes')
            );

            return $this->handler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $this->authenticator,
                'main'
            );
        }

        return $this->render('user/registration.html.twig', ['registrationForm' => $form->createView()]);
    }
}
