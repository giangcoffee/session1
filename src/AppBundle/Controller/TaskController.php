<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 *
 * @author Smartbox Web Team <si-web@smartbox.com>
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task_list_page", methods={"GET"})
     */
    public function listAction()
    {
        $tasks = [
            '1' => ['task' => 'title 1', 'dueDate' => new \DateTime()],
            '2' => ['task' => 'title 2', 'dueDate' => new \DateTime()],
            '3' => ['task' => 'title 3', 'dueDate' => new \DateTime()],
        ];

        return $this->render(
            'task/list.html.twig',
            [
                'tasks' => $tasks
            ]
        );
    }

    /**
     * @Route("/task/{id}", name="task_detail_page", methods={"GET"})
     */
    public function detailAction($id)
    {
        $tasks = [
            '1' => ['task' => 'title 1', 'dueDate' => new \DateTime()],
            '2' => ['task' => 'title 2', 'dueDate' => new \DateTime()],
            '3' => ['task' => 'title 3', 'dueDate' => new \DateTime()],
        ];

        $task = null;
        foreach ($tasks as $key=>$value) {
            if ($id == $key) {
                $task = $value;
            }
        }

        return $this->render(
            'task/detail.html.twig',
            [
                'task' => $task['title'],
                'dueDate' => $task['dueDate']
            ]
        );
    }

    /**
     * @Route("/new-task", name="task_new_page")
     */
    public function newAction(Request $request)
    {
        $task = new Task();

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('task_list_page');
        }

        return $this->render('task/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}