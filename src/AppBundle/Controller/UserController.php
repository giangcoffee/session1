<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 *
 * @author Smartbox Web Team <si-web@smartbox.com>
 */
class UserController extends AbstractController
{
    public $users = [
        '1' => ['email' => 'user1@example.com', 'name' => 'user 1'],
        '2' => ['email' => 'user2@example.com', 'name' => 'user 2'],
        '3' => ['email' => 'user3@example.com', 'name' => 'user 3'],
    ];

    /**
     * @Route("/user", name="user_list_page", methods={"GET"})
     */
    public function listAction()
    {
        return $this->render(
            'user/list.html.twig',
            [
                'users' => $this->users
            ]
        );
    }

    /**
     * @Route("/user/{id}", name="user_detail_page", methods={"GET"})
     */
    public function detailAction($id)
    {
        $user = null;
        foreach ($this->users as $key=>$value) {
            if ($id == $key) {
                $user = $value;
            }
        }

        return $this->render(
            'user/detail.html.twig',
            [
                'email' => $user['email'],
                'name' => $user['name']
            ]
        );
    }

    /**
     * @Route("/new-user", name="user_new_page")
     */
    public function newAction(Request $request)
    {
        $task = new User();

        $form = $this->createForm(UserType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('user_list_page');
        }

        return $this->render('user/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}