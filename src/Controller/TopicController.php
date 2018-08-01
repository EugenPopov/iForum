<?php

namespace App\Controller;


use App\Entity\Messages;
use App\Entity\Topics;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AddTopic;

class TopicController extends Controller
{
    /**
     * @Route("/add_topic/{id}", name="add_topic")
     */
    public function addTopic(Request $request,$id=null)
    {
        $user = new Topics();
        $user->setDate(new \DateTime());
        $user->setClose(0);
        $form = $this->createForm(AddTopic::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entity_manager = $this->getDoctrine()->getManager();
            $entity_manager->persist($user);
            $entity_manager->flush();

            return $this->redirectToRoute('home');
        }
        //$this->addSql("INSERT INTO sections (name) VALUES ('Авто'),('Кино'),('Музыка'),('ИТ'),('Бизнес')");
        return $this->render('topics/addTopic.html.twig',['form'=>$form->createView()]);
    }
    /**
     * @Route("/section/{id}", name="form")
     */
    public function showTopics($id)
    {
        $repository = $this->getDoctrine()->getRepository(Topics::class);
        $topics = $repository->findBy(['section'=>$id]);
        return $this->render('topics/topics.html.twig',['topics'=>$topics, 'id'=>$id]);
    }
}