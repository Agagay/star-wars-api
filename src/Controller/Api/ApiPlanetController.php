<?php

namespace App\Controller\Api;

use App\Entity\Planet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * @Route("/planet")
 */
class ApiPlanetController extends AbstractController
{
    /**
     * @Route("/{id}", name="api_planet", methods={"GET"})
     * @return JsonResponse
     */
    public function getOne($id)
    {
        $planet = $this->getDoctrine()->getRepository(Planet::class)->find($id);
        return new JsonResponse($this->serialize($planet), 200);
    }

    /**
     * @Route("/", name="api_planets", methods={"GET"})
     * @return JsonResponse
     */
    public function getAll()
    {
        $planets = $this->getDoctrine()->getRepository(Planet::class)->findAll();
        return new JsonResponse($this->serialize($planets), 200);
    }

    protected function serialize($obj)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceLimit(1);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return $object->getId();
        });
        $normalizers = [$normalizer];
        $serializer = new Serializer($normalizers, $encoders);
        $json = $serializer->serialize($obj, 'json');
        return $json;
    }
}