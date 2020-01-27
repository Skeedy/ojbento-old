<?php

namespace App\Controller;

use App\Entity\Assoc;
use App\Entity\Menu;
use App\Form\AssocType;
use App\Form\MenuType;
use App\Repository\AssocRepository;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/menu", host="admin.ojbento.pi-ti.fr")
 */
class MenuController extends AbstractController
{
    /**
     * @Route("/", name="menu_index", methods={"GET"})
     */
    public function index(MenuRepository $menuRepository): Response
    {
        return $this->render('menu/index.html.twig', [
            'menus' => $menuRepository->findBy(array(), array('value'=>'asc')),
        ]);
    }

    /**
     * @Route("/new", name="menu_new", methods={"GET","POST"})
     */
    public function new(Request $request, MenuRepository $menuRepository): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        $menulength = count($menuRepository->findAll()) +1;
        $menu->setValue($menulength);


        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $entityManager = $this->getDoctrine()->getManager();
            $image = $menu->getImage();
            $file = $form->get('image')->get('file')->getData();
            if ($file){
                $fileName = $this->generateUniqueFileName().'.'. $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('img_abs_path'), $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $image->setPath($this->getParameter('img_abs_path').'/'.$fileName) ;
                $image->setImgpath($this->getParameter('img_path').'/'.$fileName);
                $entityManager->persist($image);
            }else{
                $menu->setImage(null);
            }
            $entityManager->persist($menu);
            $entityManager->flush();

            return $this->redirectToRoute('menu_index');
        }

        return $this->render('menu/new.html.twig', [
            'menu' => $menu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="menu_show", methods={"GET"})
     */
    public function show(Menu $menu): Response
    {
        return $this->render('menu/show.html.twig', [
            'menu' => $menu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="menu_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Menu $menu): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $image = $menu->getImage();
            $file = $form->get('image')->get('file')->getData();

            if ($file){
                $fileName = $this->generateUniqueFileName().'.'. $file->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('img_abs_path'), $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $this->removeFile($image->getPath());
                $image->setPath($this->getParameter('img_abs_path').'/'.$fileName) ;
                $image->setImgpath($this->getParameter('img_path').'/'.$fileName);
                $entityManager->persist($image);
            }
            if ($image && empty($image->getId()) && !$file ){
                $menu->setImage(null);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('menu_index', [
                'id' => $menu->getId(),
            ]);
        }

        return $this->render('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="menu_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Menu $menu): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
            $image = $menu->getImage();
            if($image) {
                $this->removeFile($image->getPath());
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($menu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('menu_index');
    }

    /**
     * @Route("/patch", name="menu_patch", methods={"PATCH"})
     */

    public function patchMenuValue(Request $request, MenuRepository $menuRepository): Response
    {
        $em = $this->getDoctrine()->getManager();
        $rows = $request->get('orderArray');
        foreach ($rows as $row){
            $typeId = $row['id'];
            $typeNewOrder = $row['order'];
            $menu = $menuRepository->find($typeId);
            $menu->setValue($typeNewOrder);
            $em->persist($menu);
            $em->flush();
        }

        return new JsonResponse(['status' => 'success'], 202);

    }
    /**
     * @return string
     */
    function generateUniqueFileName() {
        return md5(uniqid());
    }
    private function removeFile($path){
        if(file_exists($path)){
            unlink($path);
        }
    }
}
