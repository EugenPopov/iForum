<?php

namespace App\Controller;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Messages;
use App\Form\AddMessage;
use App\Entity\Topics;

class MessageController extends Controller
{
    /**
     * @Route("/topic/{id}", name="list")
     */

    public function showMessages(Request $request,$id)
    {
        $topics_repository = $this->getDoctrine()->getRepository(Topics::class);
        $topics_list = $topics_repository->findOneBy(['id'=>$id]);

        $message_repository = $this->getDoctrine()->getRepository(Messages::class);
        $message_list = $message_repository->findBy(['topics'=>$id]);

        $messages = new Messages();
        $messages->setDate(new \DateTime());

        $form = $this->createForm(AddMessage::class,$messages);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $messages->setTopics($topics_list);
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

        return $this->render('topics/messages.html.twig',['messages'=>$message_list, 'id'=>$id, 'form'=>$form->createView(),'topics_list'=>$topics_list]);
    }
}