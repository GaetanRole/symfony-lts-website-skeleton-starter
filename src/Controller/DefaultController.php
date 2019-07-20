<?php

namespace App\Controller;

use App\Service\GlobalClock;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
final class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * A sample method to use GlobalClock service based on TimeContinuum component.
     * @Route("/time-continuum", name="app_time_continuum")
     */
    public function showTimeContinuumSample(GlobalClock $clock): Response
    {
        // Getting GlobalClock Service injection
        return $this->render('samples/time_continuum.html.twig', ['clock' => $clock]);
    }
}
