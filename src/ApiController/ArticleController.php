<?php

use App\Entity\Article;
use App\Repository\ArticleRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/article", host="api.ojbento.fr")
 */

class ArticleController extends  AbstractFOSRestController
{
    /**
     * retrieves a collection of Products resources
     * @Route("/", name="article_api", methods={ "GET" })
     * @Rest\View()
     **/
    public function index(ArticleRepository $articleRepository): View
{
    $results = $articleRepository->findAll();

    return View::create($results, Response::HTTP_OK);
}
    /**
     * @Rest\Get(path="/{id}", name="Articleshow_api")
     * @Rest\View()
     *
     * @param Article $article
     * @return View;
     */
    public function show(Article $article): View
{
    return View::create($article, Response::HTTP_OK);
}
}
