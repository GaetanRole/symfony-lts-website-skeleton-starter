<?php

/**
 * User Controller File
 *
 * PHP Version 7.2
 *
 * @category User
 * @package  App\Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 *
 * @Route("/profile")
 * @IsGranted("ROLE_USER")
 *
 * @category User
 * @package  App\Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
final class UserController extends AbstractController
{
    /**
     * Profile index page
     *
     * @Route("/", name="user_index")
     * @return     Response A Response instance
     */
    public function index(): Response
    {
        /**
         * Getting current user object
         *
         * @var \App\Entity\User $user
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
