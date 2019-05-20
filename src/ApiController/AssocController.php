<?php
namespace App\ApiController;
use App\Entity\Assoc;
use App\Repository\AllergenRepository;
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
 * @Route("/assoc", host="api.ojbento.fr")
 */
class AssocController extends AbstractFOSRestController
{
    /**
     * @Route("/", name="Assoclist_api", methods={"GET"})
     * @Rest\View()
     */
    public function index(AssocRepository $assocRepository): View
    {
        $assoc = $assocRepository->findAll();
        return View::create($assoc, Response::HTTP_OK);
    }
    /**
     * @Rest\Get(path="/{id}", name="assocshow_api")
     * @Rest\View()
     *
     * @param Assoc $assoc
     * @return View;
     */
    public function show(Assoc $assoc): View
    {
        return View::create($assoc, Response::HTTP_OK);
    }
    /**
     * create a assoc
     * @Rest\Post(
     *      path = "/new",
     *     name = "assoccreate_api",
     * )
     * @param Request $request
     * @Rest\View()
     * @return View;
     */
    public  function create(Request $request, AllergenRepository $allergenRepository): View
    {
        $em = $this->getDoctrine()->getManager();
        $assoc = new Assoc();
        $assoc->setProduct($request->get('product'));

        $allergenId =$request->get('allergen');
        foreach ($allergenId as $allergen){
            $aller = $allergenRepository->find($allergen);
            $assoc->addAllergen($aller);
            $em->persist($aller);
        }
        $em ->persist($assoc);
        $em->flush();
        return View::create($assoc, Response::HTTP_CREATED);
    }
    /**
     * @Rest\Put(
     *     path = "/{id}",
     *     name = "categoryedit_api",
     * )
     * @Rest\View()
     * @param Assoc $assoc
     * @return View;
     */
    public function edit(Request $request, Assoc $assoc): View
    {
        if($assoc){
            $assoc->setName($request->get('name'));
            $assoc->setDescription($request->get('description'));
            $assoc->addAllergen($request->get('allergen'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($assoc);
            $em->flush();
        }
        return View::create($assoc,Response::HTTP_OK);
    }
    /**
     * @Rest\Patch(
     *     path = "/{id}",
     *     name = "productpatch_api",
     * )
     * @Rest\View()
     * @param Assoc $assoc
     * @return View;
     */
    public function patch(Request $request, Assoc $assoc): View
    {
        if($assoc){
            $form = $this->createForm(ApiAssocType::class, $assoc);
            $form->submit($request->request->all(), false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($assoc);
            $em->flush();
        }
        return View::create($assoc,Response::HTTP_OK);
    }
    /**
     * @Rest\Delete(
     *     path = "/{id}",
     *     name = "Productdelete_api",
     * )
     * @Rest\View()
     * @param Assoc $assoc
     * @return View;
     */
    public function delete(Assoc $assoc): View
    {
        if($assoc){
            $em = $this ->getDoctrine()->getManager();
            $em->remove($assoc);
            $em->flush();
        }
        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
