<?php

namespace App\Controller;

use App\Entity\Sections;
use App\Entity\Topics;
use App\Entity\Users;
use App\Entity\Messages;
use App\Form\AddMessage;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AddTopic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


class HomeController extends Controller
{
    /**
     * @Route("/users", name="users")
     */
    public function users()
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findAll();
        echo '<pre>';
        var_dump($users);
        echo '</pre>';

        return new Response('');
    }
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Sections::class);
        $sections_list = $repository->findAll();

       return $this->render('home/index.html.twig',['sections_list'=>$sections_list]);
    }


















}