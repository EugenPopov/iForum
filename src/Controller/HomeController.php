<?php

namespace App\Controller;

use App\Entity\Sections;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


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


















}