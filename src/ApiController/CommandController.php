<?php

namespace App\ApiController;

use App\Entity\Command;
use App\Entity\Commandassoc;
use App\Entity\Commandmenu;
use App\Form\CommandType;
use App\Form\StateType;
use App\Repository\AssocRepository;
use App\Repository\CommandassocRepository;
use App\Repository\CommandmenuRepository;
use App\Repository\CommandRepository;
use App\Repository\MenuRepository;
use App\Repository\StateRepository;
use App\Repository\TimeRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Rest\Route("/command", host="api.ojbento.fr")
 */
class CommandController extends AbstractFOSRestController
{
    /**
     * Retrieves a collection of Command resource
     * @Rest\Get(
     *     path = "/",
     *     name = "command_list_api",
     * )
     * @Rest\View()
     */
    public function index(CommandRepository $commandRepository): View
    {
        $results = $commandRepository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK
        // response with the collection of task object
        $serializer = new Serializer([new ObjectNormalizer()]);

        $commands = [];
        foreach ( $results as $command ) {
            $d = $serializer->normalize($command, null,
                ['attributes' => [
                    'id',
                    'user'=>['id', 'username'],
                    'commandassocs' => ['id', 'quantity',
                        'assoc' => ['id', 'quantity', 'isDish',
                            'product'=>['id', 'name'],
                            'type'=>['id', 'name'],
                            'prices'=>['id', 'value',
                                'type'=>['name', 'id']],
                        ]
                    ],
                    'commandmenus'=> ['id', 'quantity',
                        'menu' =>['id', 'name']]
                ]]);
            array_push($commands, $d);
        }
        return View::create($commands, Response::HTTP_OK);
    }

    /**
     * Retrieves a Command
     * @Rest\Get(
     *     path = "/{id}",
     *     name = "commandshow_api"
     * )
     * @Rest\View()
     */
    public function show(Command $command): View
    {
        $serializer = new Serializer([new ObjectNormalizer()]);

        {
            $d = $serializer->normalize($command, null,
                ['attributes' => [
                    'id',
                    'time' => ['hourCommand'],
                    'state' => ['name'],
                    'user'=>['id', 'username'],
                    'commandassocs' => ['id', 'quantity',
                        'assoc' => ['id', 'quantity', 'isDish',
                            'product'=>['id', 'name'],
                            'type'=>['id', 'name'],
                            'prices'=>['id', 'value',
                                'type'=>['name', 'id']],
                        ]
                    ],
                    'commandmenus'=> ['id', 'quantity',
                        'menu' =>['id', 'name']]
                ]]);
        }
        return View::create($d, Response::HTTP_OK);
    }

    /**
     * Create a command
     * @Rest\Post(
     *     path = "/new",
     *     name = "command_create_api",
     * )
     * @param Request $request
     * @Rest\View()
     * @return View;
     */
    public function create(Request $request,StateRepository $stateRepository,TimeRepository $timeRepository, MenuRepository $menuRepository, AssocRepository $assocRepository): View
    {
        $serializer = new Serializer([new ObjectNormalizer()]);
        $em = $this->getDoctrine()->getManager();
        $command = new Command();
        $command->setUser($this->getUser());

        $state = $stateRepository->findOneBy(["value"=>"1"]);
        $command->setState($state);
        $rows =$request->get('cartrows');


        foreach ($rows as $row){
            if ($row['isMenuRow'] == "true") {
                $menuId = $row['menu']['id'];
                $menu = $menuRepository->find($menuId);
                $commandMenu = new Commandmenu();
                $commandMenu->setMenu($menu);
                $commandMenu->setQuantity($row['nbCart']);
                $commandMenu->setCommand($command);
                $command->addCommandmenu($commandMenu);
                $em->persist($commandMenu);
            } else {
                $assocId = $row['assoc']['id'];
                $assoc = $assocRepository->find($assocId);
                $commandAssoc = new Commandassoc();
                $commandAssoc->setAssoc($assoc);
                $commandAssoc->setQuantity($row['nbCart']);
                $commandAssoc->setCommand($command);
                $command->addCommandassoc($commandAssoc);
                $em->persist($commandAssoc);
            }
        }

        $em->persist($command);
        $em->flush();

        /*$commandassocId =$request->get('commandassocs');
        foreach ($commandassocId as $commandassoc){
            $ca = $commandassocRepository->find($commandassoc);
            $command->addCommandassoc($ca);
            $em->persist($ca);
        }
        $commandmenuId =$request->get('commandmenus');
        foreach ($commandmenuId as $commandmenu){
            $cm = $commandmenuRepository->find($commandmenu);
            $command->addCommandmenu($cm);
            $em->persist($cm);
        }*/
        /*$state = $stateRepository->find('4');
        $command->setState($state);
        $time = $timeRepository->find($request->get('hour_command'));
        $command->setTime($time);
        $em->persist($command);
        $em->flush();
        $d = $serializer->normalize($command, null,
            ['attributes' => [
                'id',
                'user'=>['id', 'username'],
                'commandassocs' => ['id', 'quantity',
                    'assoc' => ['id', 'quantity', 'isDish',
                        'product'=>['id', 'name'],
                        'type'=>['id', 'name'],
                        'prices'=>['id', 'value',
                            'type'=>['name', 'id']],
                    ]
                ],
                'commandmenus'=> ['id', 'quantity',
                    'menu' =>['id', 'name']]
            ]]);*/
        return View::create($command, Response::HTTP_CREATED);
    }

//    /**
//     * Edit a Priority
//     * @Rest\Put(
//     *     path = "/{id}",
//     *     name = "priority_edit_api",
//     * )
//     * @Rest\View()
//     *
//     * @param Request $request
//     * @param Priority $priority
//     * @return View;
//     */
//    public function edit(Request $request, Priority $priority): View
//    {
//        if ($priority){
//            $priority->setName($request->get('name'));
//            $priority->setValue($request->get('value'));
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($priority);
//            $em->flush();
//        }
//        return View::create($priority, Response::HTTP_OK);
//    }
//
//    /**
//     * Edit a Priority
//     * @Rest\Patch(
//     *     path = "/{id}",
//     *     name = "priority_patch_api",
//     * )
//     * @Rest\View()
//     *
//     * @param Request $request
//     * @param Priority $priority
//     * @return View;
//     */
//    public function patch(Request $request, Priority $priority): View
//    {
//        if ($priority){
//            $form = $this->createForm(PriorityType::class, $priority);
//            $form->submit($request->request->all(), false);
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($priority);
//            $em->flush();
//        }
//        return View::create($priority, Response::HTTP_OK);
//    }
//
//    /**
//     * Delete a Priority
//     * @Rest\Delete(
//     *     path = "/{id}",
//     *     name = "priority_delete_api",
//     * )
//     * @Rest\View()
//     *
//     * @param Priority $priority
//     * @return View;
//     */
//    public function delete(Priority $priority): View
//    {
//        if ($priority){
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($priority);
//            $em->flush();
//        }
//        return View::create([], Response::HTTP_NO_CONTENT);
//    }
}
