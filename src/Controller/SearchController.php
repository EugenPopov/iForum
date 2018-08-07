<?php

/*
 * This file is part of the "php-paradise/array-keys-converter" package.
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
     *
     * @return Response
     */
    public function ShowResult(Request $request, FindByQuestion $query)
    {
        $question = $request->query->get('search');

        $results = $query->index($question, $this->getDoctrine()->getManager());

//        var_dump($results);
//
//        return new Response('');

        return $this->render('search/list.html.twig', ['results'=>$results,'filter'=>$question['filter']]);
    }
}
