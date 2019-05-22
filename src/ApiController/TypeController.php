<?php
namespace App\ApiController;
use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
/**
 * @Rest\Route(path="/type", host="api.ojbento.fr")
 */
class TypeController extends AbstractFOSRestController
{
    /**
     * @Route("/", name="type_api", methods={"GET"})
     * @Rest\View()
     */
    public function index(TypeRepository $typeRepository): View
    {
        $type = $typeRepository->findAll();
        return View::create($type, Response::HTTP_OK);
    }
    /**
     * @Rest\Get(path="/{id}", name="Typesshow")
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
     * create a type
     * @Rest\Post(
     *      path = "/new",
     *     name = "typecreate",
     * )
     * @param Request $request
     * @Rest\View()
     * @return View;
     */
    public  function create(Request $request, TypeRepository $typeRepository): View
    {
        $em = $this->getDoctrine()->getManager();
        $type = new Type();
        $type->setName($request->get('name'));
        $em ->persist($type);
        $em->flush();
        return View::create($type, Response::HTTP_CREATED);
    }
    /**
     * @Rest\Put(
     *     path = "/{id}",
     *     name = "typeedit_api",
     * )
     */
    public function edit(Request $request, Type $Type)
    {
        if($Type){
            $Type->setName($request->get('name'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($Type);
            $em->flush();
        }
        return View::create($Type,Response::HTTP_OK);
    }
    /**
     * @Rest\Patch(
     *     path = "/{id}",
     *     name = "typepatch_api",
     * )
     * @Rest\View()
     * @param Type $type
     * @return View;
     */
    public function patch(Request $request, Type $type): View
    {
        if($type){
            $form = $this->createForm(TypeType::class, $type);
            $form->submit($request->request->all(), false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
        }
        return View::create($type,Response::HTTP_OK);
    }
    /**
     * @Rest\Delete(
     *     path = "/{id}",
     *     name = "Typedelete",
     * )
     * @Rest\View()
     * @param Type $type
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
