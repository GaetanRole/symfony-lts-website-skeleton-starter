<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 * @IsGranted("ROLE_USER")
 */
final class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="app_user_index")
     */
    public function index(): Response
    {
        /**
         * Getting current user object
         * @var User $user
         */
        $user = $this->getUser();

        return $this->render(
            'user/index.html.twig',
            [
            'user' => $user,
            ]
        );
    }
}
