<?php

/**
 * Default/Index controller file
 *
 * PHP Version 7.2
 *
 * @category Controller
 * @package  Default
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace App\Controller;

use App\Service\GlobalClock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Default controller.
 *
 * @category Controller
 * @package  Default
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class DefaultController extends AbstractController
{
    /**
     * Home page
     *
     * @Route("/", name="index", methods={"GET", "HEAD"})
     * @return     Response A Response instance
     */
    public function index()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * A sample method to use GlobalClock service based on TimeContinuum component
     *
     * @param GlobalClock $clock Given project's clock to handle all DateTime objects
     *
     * @Route("/time-continuum", name="show_time_continuum", methods={"GET", "HEAD"})
     * @return                   Response A Response instance
     */
    public function showTimeContinuumSample(GlobalClock $clock)
    {
        return $this->render(
            'samples/time_continuum.html.twig',
            ['clock' => $clock]
        );
    }
}
