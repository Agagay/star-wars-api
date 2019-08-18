<?php

namespace App\Controller\Api;

use App\Entity\Planet;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PlanetRestController extends AbstractFOSRestController
{
    /**
     * Get planet
     *
     * @Rest\Get("/planet/{id}")
     * @param int $id
     * @param Request $request
     * @return View
     */
    public function getOne($id, Request $request): View
    {
        $planet = $this->getDoctrine()->getRepository(Planet::class)->find($id);
        return View::create($planet, Response::HTTP_OK);
    }

    /**
     * Get planets
     *
     * @Rest\Get("/planet")
     * @param Request $request
     * @return View
     */
    public function getAll(Request $request): View
    {
        $planet = $this->getDoctrine()->getRepository(Planet::class)->findAll();
        return View::create($planet, Response::HTTP_OK);
    }

    /**
     * Create planet
     *
     * @Rest\Post("/planet")
     * @param Request $request
     * @return View
     */
    public function add(Request $request, ValidatorInterface $validator): View
    {
        $planet = new Planet();
        $planet->setPopulation($request->get('population'));
        $planet->setName($request->get('name'));
        $planet->setClimate($request->get('climate'));
        $planet->setRotationPeriod($request->get('rotation_period'));
        $planet->setOrbitalPeriod($request->get('orbital_period'));
        $planet->setDiameter($request->get('diameter'));
        $planet->setGravity($request->get('gravity'));
        $planet->setTerrain($request->get('terrain'));
        $planet->setSurfaceWater($request->get('surface_water'));

        $errors = $validator->validate($planet);

        if (count($errors) > 0) {
            return View::create($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($planet);
        $em->flush();

        return View::create($planet, Response::HTTP_CREATED);
    }

    /**
     * Edit planet
     *
     * @Rest\Put("/planet/{id}")
     * @param int $id
     * @param Request $request
     * @return View
     */
    public function edit($id, Request $request, ValidatorInterface $validator): View
    {
        $planet = $this->getDoctrine()->getRepository(Planet::class)->find($id);

        $planet->setPopulation($request->get('population'));
        $planet->setName($request->get('name'));
        $planet->setClimate($request->get('climate'));
        $planet->setRotationPeriod($request->get('rotation_period'));
        $planet->setOrbitalPeriod($request->get('orbital_period'));
        $planet->setDiameter($request->get('diameter'));
        $planet->setGravity($request->get('gravity'));
        $planet->setTerrain($request->get('terrain'));
        $planet->setSurfaceWater($request->get('surface_water'));

        $errors = $validator->validate($planet);

        if (count($errors) > 0) {
            return View::create($errors, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($planet);
        $em->flush();

        return View::create($planet, Response::HTTP_OK);
    }

    /**
     * Delete planet
     *
     * @Rest\Delete("/planet/{id}")
     * @param int $id
     * @param Request $request
     * @return View
     */
    public function delete($id, Request $request): View
    {
        $planet = $this->getDoctrine()->getRepository(Planet::class)->find($id);

        if ($planet) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($planet);
            $em->flush();
        }

        return View::create([], Response::HTTP_NO_CONTENT);
    }
}