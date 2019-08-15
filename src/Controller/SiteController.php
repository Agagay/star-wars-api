<?php

namespace App\Controller;

use App\Entity\Planet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('site/index.html.twig', []);
    }

    /**
     * @Route("/task1", name="task1")
     */
    public function task1()
    {
        $rPlanets = $this->getDoctrine()->getRepository(Planet::class);
        $planets = $rPlanets->findWithPeople();

        return $this->render('site/task1.html.twig', [
            'planets' => $planets
        ]);
    }

    /**
     * @Route("/task2", name="task2")
     */
    public function task2()
    {
        $rPlanets = $this->getDoctrine()->getRepository(Planet::class);
        $planets = $rPlanets->findPlanetWithResidentCount();

        return $this->render('site/task2.html.twig', [
            'planets' => $planets
        ]);
    }

    /**
     * @Route("/task3", name="task3")
     */
    public function task3()
    {
        $rPlanets = $this->getDoctrine()->getRepository(Planet::class);
        $planets = $rPlanets->findPlanetWith3Resident();

        return $this->render('site/task3.html.twig', [
            'planets' => $planets
        ]);
    }
}
