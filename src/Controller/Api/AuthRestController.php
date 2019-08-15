<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/auth")
 */
class AuthRestController extends AbstractFOSRestController
{
    /**
     * Register user
     *
     * @Rest\Post("/register")
     * @param Request $request
     */
    public function register(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $email = $request->get('email');

        $user = new User();
        $user->setUsername($username);
        $user->setPlainPassword($password);
        $user->setEmail($email);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return View::create($user, Response::HTTP_CREATED);
    }
}