<?php
namespace App\ApiController;
use App\Entity\Menu;
use App\Repository\AllergenRepository;
use App\Repository\AssocRepository;
use App\Repository\MenuRepository;
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
 * @Route("/menu", host="api.ojbento.fr")
 */
class MenuController extends AbstractFOSRestController
{
    /**
     * @Route("/", name="menulist_api", methods={"GET"})
     * @Rest\View()
     */
    public function index(MenuRepository $menuRepository): View
    {
        $menu = $menuRepository->findAll();
        return View::create($menu, Response::HTTP_OK);
    }

    /**
     * @Rest\Get(path="/{id}", name="menushow_api")
     * @Rest\View()
     *
     * @param Menu $menu
     * @return View;
     */
    public function show(Menu $menu): View
    {
        return View::create($menu, Response::HTTP_OK);
    }
}
