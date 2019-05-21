<?php
namespace App\ApiController;

use App\Entity\Allergen;
use App\Entity\Product;
use App\Form\ApiProductType;
use App\Form\ProductType;
use App\Repository\AllergenRepository;
use App\Repository\ProductRepository;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\Collection;

/**
 * @Route("/product", host="api.ojbento.fr")
 */
class ProductController extends AbstractFOSRestController
{
    /**
     * @Route("/", name="Productlist_api", methods={"GET"})
     * @Rest\View()
     */
    public function index(ProductRepository $productRepository, Request $request): View
    {
        $typeId = $request->get('type');
        if (!empty($typeId)){
            $products = $productRepository->findBy(array('type'=>$typeId));
        }else{
            $products = $productRepository->findAll();
        }


        return View::create($products, Response::HTTP_OK);
    }
    /**
     * @Rest\Get(path="/{id}", name="Productshow_api")
     * @Rest\View()
     *
     * @param Product $product
     * @return View;
     */
    public function show(Product $product): View
    {
        return View::create($product, Response::HTTP_OK);
    }
    /**
     * create a product
     * @Rest\Post(
     *      path = "/new",
     *     name = "productcreate_api",
     * )
     * @param Request $request
     * @Rest\View()
     * @return View;
     */
    public  function create(Request $request, AllergenRepository $allergenRepository, TypeRepository $typeRepository): View
    {
        $em = $this->getDoctrine()->getManager();
        $product = new Product();
        $product->setName($request->get('name'));
        $product->setDescription($request->get('description'));
        $product->setComposition($request->get('composition'));
        $type = $typeRepository->find($request->get('type'));
        $product->setType($type);
        $allergenId =$request->get('allergen');
        foreach ($allergenId as $allergen){
            $aller = $allergenRepository->find($allergen);
            $product->addAllergen($aller);
            $em->persist($aller);
        }
        $em ->persist($product);
        $em->flush();
        return View::create($product, Response::HTTP_CREATED);
    }
    /**
     * @Rest\Put(
     *     path = "/{id}",
     *     name = "categoryedit_api",
     * )
     * @Rest\View()
     * @param Product $product
     * @return View;
     */
    public function edit( Request $request, Product $product, TypeRepository $typeRepository, AllergenRepository $allergenRepository): View
    {
        if($product){
            $em = $this->getDoctrine()->getManager();
            $product->setName($request->get('name'));
            $product->setDescription($request->get('description'));
            $product->setComposition($request->get('composition'));
            $type = $typeRepository->find($request->get('type'));
            $product->setType($type);
            $allergenIds = $request->get('allergen');
            $allergens = new ArrayCollection();
            foreach ($allergenIds as $allergen){
                $aller = $allergenRepository->find($allergen);
                $allergens->add($aller);
            }
            $product->setAllergens($allergens);
            $em->persist($product);
            $em->flush();
        }
        return View::create($product,Response::HTTP_OK);
    }
    /**
     * @Rest\Patch(
     *     path = "/{id}",
     *     name = "productpatch_api",
     * )
     * @Rest\View()
     * @param Product $product
     * @return View;
     */
    public function patch(Request $request, Product $product, AllergenRepository $allergenRepository): View
    {
        if($product){
            $form = $this->createForm(ProductType::class, $product);
            $form->submit($request->request->all(), false);
            $em = $this->getDoctrine()->getManager();
            $allergenIds = $request->get('allergen');
            if (!empty($allergenIds)) {
                $allergens = new ArrayCollection();
                foreach ($allergenIds as $allergen) {
                    $aller = $allergenRepository->find($allergen);
                    $allergens->add($aller);
                }
                $product->setAllergens($allergens);
            }
            $em->persist($product);
            $em->flush();
        }
        return View::create($product,Response::HTTP_OK);
    }
    /**
     * @Rest\Delete(
     *     path = "/{id}",
     *     name = "Productdelete_api",
     * )
     * @Rest\View()
     * @param Product $product
     * @return View;
     */
    public function delete(Product $product): View
    {
        if($product){
            $em = $this ->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }
        return View::create([], Response::HTTP_NO_CONTENT);
    }
}
