<?php

namespace App\Controller;

use App\Form\EditMessageForm;
use App\Repository\MessagesRepository;
use App\Service\Messages\MessageService;
use App\Service\User\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Messages;
use App\Form\AddMessage;
use App\Entity\Topics;

class MessageController extends Controller
{

    /**
     * This method allow u to DELETE message if u have enough rights
     *
     * @var MessageService is service that have functions to add and delete messages
     *
     * @Route("/delete/message/{id}", name="delete_message")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function deleteMessage($id, MessagesRepository $query, MessageService $messageService)
    {
        $em = $this->getDoctrine()->getManager();
        $MRepository = $em->getRepository(Messages::class);
        $message = $MRepository->findOneBy(['id'=>$id]);

        if(empty($message) or !$message->IsAuthorOf($message,$this->getUser()))
            return $this->render('error.html.twig');

            $messageService->DeleteMessageAction($message, $em, $MRepository, $query);

            return $this->redirectToRoute('list',['id'=>$message->getTopics()->getId()]);
    }

    /**
     * This method allow u to EDIT message if u have enough rights
     *
     * MessageService is service that have functions to add and delete messages
     *
     * @Route("/edit/message/{id}", name="edit_message")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function editMessage($id,Request $request){

        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository(Messages::class)->find($id);

        if(empty($message) or !$message->isAuthorOf($message,$this->getUser()))
            return $this->render('error.html.twig');

        $form = $this->createForm(EditMessageForm::class,$message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->flush();

            return $this->redirectToRoute('list',['id'=>$message->getTopics()->getId()]);
        }
        return $this->render('editing/editMessage.html.twig',['form'=>$form->createView()]);
    }

    /**
     * This is method that show all the messages in topic
     *
     * @var topic_repository get the current topic
     * @var $message_repository get the message list
     *
     * @var paginator call pagination
     * @var result create pagination by chosen properties
     *
     * @var form show form where u can write message if u are authorized
     *
     * @Route("/topic/{id}", name="list")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function showMessages(Request $request, $id, MessageService $addMessageService, UserService $user)
    {
        $entity_manager = $this->getDoctrine()->getManager();

        $topic_repository = $entity_manager->getRepository(Topics::class)->findOneBy(['id'=>$id]);

        $message_repository = $entity_manager->getRepository(Messages::class);
        $message_list = $message_repository->findBy(['topics'=>$id]);

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');

        $result = $paginator->paginate(
            $message_list,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 3)
        );


        $messages = new Messages();
        $form = $this->createForm(AddMessage::class,$messages);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addMessageService->AddMessageAction($entity_manager,$topic_repository,$messages,$message_repository, $this->getUser());

            return $this->redirectToRoute('list',['id'=>$id]);
        }

        return $this->render('topics/messages.html.twig',['messages'=>$result, 'id'=>$id, 'form'=>$form->createView(),'current_user'=>$this->getUser(),'topic'=>$topic_repository,'result'=>$result]);
    }
}