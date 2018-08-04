<?php

namespace App\Controller;



use App\Form\EditMessageForm;
use App\Repository\MessagesRepository;
use phpDocumentor\Reflection\Types\Null_;
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
     * @Route("/delete/message/{id}", name="delete_message")
     */
    public function deleteMessage($id, MessagesRepository $query)
    {
        $em = $this->getDoctrine()->getManager();
        $MRepository = $em->getRepository(Messages::class);
        $message = $MRepository->find($id);

        if($message->isAuthorOfMessage($this->getUser()->getId())){
            $topic_id = $message->getTopics()->getId();

            if($message->getTopics()->getLastMessage() != null){
                if($message->getText() == $message->getTopics()->getLastMessage()->getText()) {
                    $message->getTopics()->setLastMessage(null);
                    $em->persist($message);
                }
            }
            $em->remove($message);
            $em->flush();

            $message_list = $query->lastMessage($MRepository->findBy(['topics'=>$topic_id]));
            $message->getTopics()->setLastMessage($message_list);

            $em->persist($message);
            $em->remove($message);
            $em->flush();


            return $this->redirectToRoute('list',['id'=>$message->getTopics()->getId()]);}
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
    public function showMessages(Request $request,$id)
    {
        $doctrine = $this->getDoctrine();

        $topic_repository = $doctrine->getRepository(Topics::class)->findOneBy(['id'=>$id]);

        $message_repository = $doctrine->getRepository(Messages::class);
        $message_list = $message_repository->findBy(['topics'=>$id]);
        if ($this->getUser() == Null){
            $current_user = 0;
        }
        else{
            $current_user = $this->getUser()->getId();
        }

        $messages = new Messages();
        $form = $this->createForm(AddMessage::class,$messages);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messages->setTopics($topic_repository);
            $messages->setAuthor($this->getUser());
            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($messages);
            $entity_manager->flush();
            $last_id = $messages->getId();
            $last_message = $message_repository->findOneBy(['id'=>$last_id]);

            $product = $entity_manager->getRepository(Topics::class)->find($id);

            $product->setLastMessage($last_message);

            $entity_manager->flush();

            return $this->redirectToRoute('list',['id'=>$id]);
        }

        return $this->render('topics/messages.html.twig',['messages'=>$message_list, 'id'=>$id, 'form'=>$form->createView(),'user_id'=>$current_user,'topic'=>$topic_repository]);
    }
}