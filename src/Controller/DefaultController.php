<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\GlobalClock;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/", name="app_")
 *
 * @author  Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
final class DefaultController extends AbstractController
{
    /**
     * @Route(name="index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * A sample method to use GlobalClock service based on TimeContinuum component.
     * @Route("time-continuum", name="time_continuum", methods={"GET"})
     */
    public function showTimeContinuumSample(GlobalClock $clock): Response
    {
        // Getting GlobalClock Service injection
        return $this->render('samples/time_continuum.html.twig', ['clock' => $clock]);
    }
}
