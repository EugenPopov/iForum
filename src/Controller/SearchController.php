<?php

namespace App\Controller;

use App\Service\Searching\FindByQuestion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SearchController extends Controller
{

    /**
     * This method show u results after u submit search form
     *
     * @var question has chosen options in search form
     * @var FindByQuestion is service that return an array of messages and topics found
     *
     * @Route("/search", name="search")
     * @return Response
     */
    public function ShowResult(Request $request, FindByQuestion $query)
    {
        $question = $request->query->get('search');

        $results = $query->index($question, $this->getDoctrine()->getManager());

        return $this->render('search/list.html.twig',['results'=>$results,'filter'=>$question['filter']]);
    }
}