<?php

/**
 * Default Controller File
 * Default/Index controller file
 *
 * PHP Version 7.2
 *
 * @category Controller
 * @package  App\Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace App\Controller;

use App\Service\GlobalClock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Default Controller
 *
 * @category Controller
 * @package  App\Controller
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
final class DefaultController extends AbstractController
{
    /**
     * Home page
     *
     * @Route("/{_locale}", defaults={"_locale"="%locale%"},
     *     name="index", methods={"GET", "HEAD"})
     * @return     Response A Response instance
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * A sample method to use GlobalClock service based on TimeContinuum component
     *
     * @param GlobalClock $clock Given project's clock to handle all DateTime objects
     *
     * @Route("/{_locale}/time-continuum", defaults={"_locale"="%locale%"},
     *     name="show_time_continuum", methods={"GET", "HEAD"})
     * @return                   Response A Response instance
     */
    public function showTimeContinuumSample(GlobalClock $clock): Response
    {
        // Getting GlobalClock injection service
        return $this->render(
            'samples/time_continuum.html.twig',
            [
                'clock' => $clock
            ]
        );
    }
}
