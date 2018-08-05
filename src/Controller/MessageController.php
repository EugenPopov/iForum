<?php

namespace App\Controller;

use App\Form\EditMessageForm;
use App\Repository\MessagesRepository;
use App\Service\Messages\MessageService;
use App\Service\User\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Messages;
use App\Form\AddMessage;
use App\Entity\Topics;


class MessageController extends Controller
{
    /**
     * @Route("/delete/message/{id}", name="delete_message")
     */
    public function deleteMessage($id, MessagesRepository $query, MessageService $messageService)
    {
        $em = $this->getDoctrine()->getManager();
        $MRepository = $em->getRepository(Messages::class);
        $message = $MRepository->findOneBy(['id'=>$id]);

        if($message->isAuthorOfMessage($this->getUser()->getId())){
            $messageService->DeleteMessageAction($message, $em, $MRepository, $query);

            return $this->redirectToRoute('list',['id'=>$message->getTopics()->getId()]);
        }
        else{
            return $this->redirectToRoute('home');
        }
    }
    /**
     * @Route("/edit/message/{id}", name="edit_message")
     */
    public function editMessage($id,Request $request){

        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository(Messages::class)->find($id);

        $form = $this->createForm(EditMessageForm::class,$message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$message) {
                throw $this->createNotFoundException(
                    'No product found for id '.$id
                );
            }
            $em->flush();

            return $this->redirectToRoute('list',['id'=>$message->getTopics()->getId()]);
        }
        return $this->render('editing/editMessage.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/topic/{id}", name="list")
     */
    public function showMessages(Request $request, $id, MessageService $addMessageService, UserService $user)
    {
        $entity_manager = $this->getDoctrine()->getManager();

        $topic_repository = $entity_manager->getRepository(Topics::class)->findOneBy(['id'=>$id]);

        $message_repository = $entity_manager->getRepository(Messages::class);
        $message_list = $message_repository->findBy(['topics'=>$id]);


        $current_user = $user->getUserId();

        $messages = new Messages();
        $form = $this->createForm(AddMessage::class,$messages);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addMessageService->AddMessageAction($entity_manager,$topic_repository,$messages,$message_repository);

            return $this->redirectToRoute('list',['id'=>$id]);
        }

        return $this->render('topics/messages.html.twig',['messages'=>$message_list, 'id'=>$id, 'form'=>$form->createView(),'user_id'=>$current_user,'topic'=>$topic_repository]);
    }
}