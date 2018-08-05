<?php

namespace App\Controller;


use App\Entity\Messages;
use App\Entity\Sections;
use App\Entity\Topics;
use App\Form\EditTopicForm;
use App\Service\User\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AddTopic;

class TopicController extends Controller
{

    /**
     * @Route("/delete/topic/{id}", name="delete_topic")
     */
    public function deleteTopic($id)
    {
        $em = $this->getDoctrine()->getManager();

        $topic = $em->getRepository(Topics::class)->findOneBy(['id'=>$id]);
        $messages = $em->getRepository(Messages::class)->findBy(['topics'=>$id]);

        $topic->setLastMessage(null);

        foreach ($messages as $message)
        $em->remove($message);
        $em->flush();

        $em->remove($topic);
        $em->flush();

        return $this->redirectToRoute('form',['id'=>$topic->getSection()->getId()]);
    }

    /**
     * @Route("/edit/topic/{id}", name="edit_topic")
     */
    public function EditTopic(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $topic = $em->getRepository(Topics::class)->find($id);
        $form = $this->createForm(EditTopicForm::class,$topic);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();
            return $this->redirectToRoute('form',['id'=>$topic->getSection()->getId()]);
        }
        $form->handleRequest($request);
    return $this->render('topics/editTopic.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/add_topic/{id}", name="add_topic")
     */
    public function addTopic(Request $request,$id=null)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = new Topics();
        $user->setAuthor($this->getUser());
        $form = $this->createForm(AddTopic::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($user);
            $entity_manager->flush();
            $last_id = $user->getId();

            return $this->redirectToRoute('list',['id'=>$last_id]);
        }
        //$this->addSql("INSERT INTO sections (name) VALUES ('Авто'),('Кино'),('Музыка'),('ИТ'),('Бизнес')");
        return $this->render('topics/addTopic.html.twig',['form'=>$form->createView()]);
    }
    /**
     * @Route("/section/{id}", name="form")
     */
    public function showTopics($id, UserService $service)
    {
        $em = $this->getDoctrine()->getManager();
        $topics = $em->getRepository(Topics::class)->findBy(['section'=>$id]);

        $userId = $service->getUserId();

        return $this->render('topics/topics.html.twig',['topics'=>$topics, 'id'=>$id,'userId'=>$userId]);
    }

    /**
     * @Route("/close_topic/{id}", name="close")
     */
    public function CloseTopic($id)
    {
        $em = $this->getDoctrine()->getManager();

        $topic = $em->getRepository(Topics::class)->findOneBy(['id'=>$id]);
        $topic->setClose(true);

        $em->flush();

        return $this->redirectToRoute('form',['id'=>$topic->getSection()->getId()]);
    }
}