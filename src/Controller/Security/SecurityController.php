<?php

declare(strict_types=1);

namespace App\Controller\Security;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/", name="app_security_")
 *
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
final class SecurityController extends AbstractController
{
    /**
     * @Route("login", name="login", methods={"GET", "POST"})
     */
    public function login(
        AuthenticationUtils $authenticationUtils,
        Security $security,
        TranslatorInterface $translator
    ): Response {
        if ($security->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('danger', $translator->trans('is_authenticated_fully.flash.redirection', [], 'flashes'));
            return $this->redirectToRoute('app_index');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("logout", name="logout")
     */
    public function logout(): void
    {
        throw new LogicException('This should never be reached !');
    }
}
