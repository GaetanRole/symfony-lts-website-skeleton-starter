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
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

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
     *
     * @Route("/login", name="app_login")
     * @return          Response A Response instance
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
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
