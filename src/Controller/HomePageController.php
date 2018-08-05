<?php

namespace App\Controller;

use App\Entity\Sections;
use App\Form\SearchForm;
use App\Model\Search;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomePageController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request)
    {
        $search = new Search();

        $search_form =$this->createForm(SearchForm::class,$search);
        $search_form->handleRequest($request);

        if ($search_form->isSubmitted() && $search_form->isValid()) {
            return $this->redirectToRoute('search',['search'=>$search]);
        }

        $repository = $this->getDoctrine()->getRepository(Sections::class);
        $sections_list = $repository->findAll();

       return $this->render('home/index.html.twig',['sections_list'=>$sections_list,'form'=>$search_form->createView()]);
    }


















}