<?php

namespace App\Controller;



use App\Form\EditMessageForm;
use App\Repository\MessagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Messages;
use App\Form\AddMessage;
use App\Entity\Topics;
use Symfony\Component\Security\Core\User\UserInterface;

class MessageController extends Controller
{
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
            $message->setText($message->getText());
            $em->flush();

            $this->redirectToRoute('home');
        }
        return $this->render('editing/editMessage.html.twig',['form'=>$form->createView()]);
    }
    /**
     * @Route("/topic/{id}", name="list")
     */
    public function showMessages(Request $request,$id)
    {
        $topics_repository = $this->getDoctrine()->getRepository(Topics::class);
        $topics_list = $topics_repository->findOneBy(['id'=>$id]);

        $message_repository = $this->getDoctrine()->getRepository(Messages::class);
        $message_list = $message_repository->findBy(['topics'=>$id]);

            foreach($message_list as $message){
                var_dump($message->getId());
            }

        $current_user = $this->getUser()->getId();
        $messages = new Messages();
        $messages->setDate(new \DateTime());
        $form = $this->createForm(AddMessage::class,$messages);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $messages->setTopics($topics_list);
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

        return $this->render('topics/messages.html.twig',['messages'=>$message_list, 'id'=>$id, 'form'=>$form->createView(),'topics_list'=>$topics_list,'user_id'=>$current_user]);
    }
}