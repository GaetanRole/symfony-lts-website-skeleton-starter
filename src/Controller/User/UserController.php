<?php

declare(strict_types=1);

namespace App\Controller\User;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user", name="app_user_")
 *
 * @IsGranted("ROLE_USER")
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
final class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="profile", methods={"GET"})
     */
    public function profile(): Response
    {
        /**
         * Getting current user object
         * @var User $user
         */
        $user = $this->getUser();

        return $this->render('user/profile.html.twig', ['user' => $user]);
    }
}
