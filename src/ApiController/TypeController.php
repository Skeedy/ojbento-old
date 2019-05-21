<?php
namespace App\ApiController;

use App\Entity\Assoc;
use App\Entity\Type;
use App\Repository\AssocRepository;
use App\Repository\ProductRepository;
use App\Repository\TypeRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/type", host="api.ojbento.fr")
 */
class TypeController extends AbstractFOSRestController
{
    /**
     * @Route("/", name="typelist_api", methods={"GET"})
     * @Rest\View()
     */
    public function index(TypeRepository $typeRepository): View
    {
        $type = $typeRepository->findAll();
        return View::create($type, Response::HTTP_OK);
    }

    /**
     * @Rest\Get(path="/{id}", name="typeshow_api")
     * @Rest\View()
     *
     * @param Type $type
     * @return View;
     */
    public function show(Type $type): View
    {
        return View::create($type, Response::HTTP_OK);
    }

    /**
     * @Rest\Delete(
     *     path = "/{id}",
     *     name = "assocdelete_api",
     * )
     * @Rest\View()
     * @param Assoc $assoc
     * @return View;
     */
    public function delete(Type $type): View
    {
        if($type){
            $em = $this ->getDoctrine()->getManager();
            $em->remove($type);
            $em->flush();
        }
        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
