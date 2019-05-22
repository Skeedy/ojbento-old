<?php

namespace App\Controller;

use App\Entity\TypePrice;
use App\Form\TypePriceType;
use App\Repository\TypePriceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type/price")
 */
class TypePriceController extends AbstractController
{
    /**
     * @Route("/", name="type_price_index", methods={"GET"})
     */
    public function index(TypePriceRepository $typePriceRepository): Response
    {
        return $this->render('type_price/index.html.twig', [
            'type_prices' => $typePriceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="type_price_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $typePrice = new TypePrice();
        $form = $this->createForm(TypePriceType::class, $typePrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typePrice);
            $entityManager->flush();

            return $this->redirectToRoute('type_price_index');
        }

        return $this->render('type_price/new.html.twig', [
            'type_price' => $typePrice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_price_show", methods={"GET"})
     */
    public function show(TypePrice $typePrice): Response
    {
        return $this->render('type_price/show.html.twig', [
            'type_price' => $typePrice,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_price_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypePrice $typePrice): Response
    {
        $form = $this->createForm(TypePriceType::class, $typePrice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_price_index', [
                'id' => $typePrice->getId(),
            ]);
        }

        return $this->render('type_price/edit.html.twig', [
            'type_price' => $typePrice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_price_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypePrice $typePrice): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typePrice->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typePrice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_price_index');
    }
}
