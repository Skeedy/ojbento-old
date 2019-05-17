<?php

namespace App\ApiController;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Rest\Route(path="/auth", host="api.ojbento.fr")
 */
class AuthController extends AbstractFOSRestController
{
    /**
     * @Rest\Get(
     *     path="/profile",
     *     name="auth_profile_api"
     * )
     * @Rest\View()
     * @return View
     */
    public function profile(): View
    {
        return View::create($this->getUser(),Response::HTTP_OK);
    }
}