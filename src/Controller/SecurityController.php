<?php

/**
 * Security Controller File
 *
 * PHP Version 7.2
 *
 * @category Security
 * @package  App\Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Security Controller
 *
 * @category Security
 * @package  App\Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
final class SecurityController extends AbstractController
{
    /**
     * Login method
     *
     * @param AuthenticationUtils $authenticationUtils get last Auth
     * @param Security $security Security injection
     * @param TranslatorInterface $translator Translator injection
     *
     * @Route("/login.{_locale}", defaults={"_locale"="en"},
     *     name="app_login")
     *
     * @return          RedirectResponse|Response A Response instance
     */
    public function login(
        AuthenticationUtils $authenticationUtils,
        Security $security,
        TranslatorInterface $translator
    ): Response {
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash(
                'danger',
                $translator->trans('isauthenticatedfully.flash.redirection')
            );
            return $this->redirectToRoute('index');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error
            ]
        );
    }
}
