<?php

/**
 * Default Controller File
 *
 * PHP Version 7.2
 *
 * @category Controller
 * @package  Default
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Default Controller
 *
 * @category Controller
 * @package  Default
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
final class DefaultController extends AbstractController
{
    /**
     * Home page
     *
     * @Route("/", name="index")
     * @return     Response A Response instance
     */
    public function index()
    {
        return $this->render('default/index.html.twig');
    }
}
