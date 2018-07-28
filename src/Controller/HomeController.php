<?php

namespace App\Controller;

use App\Entity\Sections;
use App\Entity\Topics;
use App\Entity\Users;
use Symfony\Component\Form\Tests\Fixtures\ChoiceSubType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Sections::class);
        $sections_list = $repository->findAll();

        return $this->render('home/index.html.twig',['sections_list'=>$sections_list]);
    }

    /**
     * @Route("/add_topic", name="add_topic")
     */
    public function addTopic(Request $request)

    {
        $topics = new Topics();
        $topics->setDate(new \DateTime());
        $topics->setClose(0);
        $form = $this->createFormBuilder($topics)
            ->add('name',TextType::class)
            ->add('section', EntityType::class, array(
                'class' => Sections::class,
                'choice_label'=>'name',
                ))
            ->add('save',SubmitType::class,['label'=>'Create Topic'])

            ->getForm();
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            echo '<pre>';
                var_dump($data);
            echo '</pre>';

            //return $this->redirectToRoute('home');
        }

        return $this->render('topics/addTopic.html.twig',['form'=>$form->createView()]);





    }

    /**
     * @Route("/section/{id}", name="form")
     */
    public function showTopics($id)
    {
        $repository = $this->getDoctrine()->getRepository(Topics::class);
        $topics = $repository->findBy(['section'=>$id]);
        return $this->render('topics/topics.html.twig',['topics'=>$topics]);
    }

    /**
     * @Route("/list", name="list")
     */














}