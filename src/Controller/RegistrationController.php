<?php

/**
 * Registration Controller File
 *
 * PHP Version 7.2
 *
 * @category Registration
 * @package  App\Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace App\Controller;

use App\Form\UserType;
use App\Entity\User;
use App\Service\GlobalClock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Registration Controller
 *
 * @category Registration
 * @package  App\Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
final class RegistrationController extends AbstractController
{
    /**
     * Register an user
     *
     * @param Request                      $request         POST'ed data
     * @param UserPasswordEncoderInterface $passwordEncoder Encoder
     * @param GlobalClock $clock Given project's clock to handle all DateTime objects
     * @param Security $security Security injection
     * @param TranslatorInterface $translator Translator injection
     *
     * @Route("/register.{_locale}", defaults={"_locale"="en"},
     *     name="user_registration")
     *
     * @return RedirectResponse|Response
     */
    public function register(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        GlobalClock $clock,
        Security $security,
        TranslatorInterface $translator
    ) {
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash(
                'danger',
                $translator->trans('isauthenticatedfully.flash.redirection')
            );
            return $this->redirectToRoute('index');
        }

        // Build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // Handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the password (you could also do this via Doctrine listener)
            $password
                = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // Using TimeContinuum to have power on time
            $user->setCreationDate($clock->getNowInDateTime());

            // Save the User object
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Add a notification on security/login.html.twig
            $this->addFlash(
                'registration-success',
                $translator->trans('account.registered')
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }
}
