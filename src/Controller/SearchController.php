<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 01.08.18
 * Time: 12:19
 */

namespace App\Controller;

use App\Service\Searching\FindByQuestion;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Users;

class SearchController extends Controller
{

    /**
     * @Route("/search", name="search")
     */
    public function ShowResult(Request $request, FindByQuestion $query)
    {
        $question = $request->query->get('search');

        $results = $query->index($question);
        return $this->render('search/list.html.twig',['results'=>$results,'filter'=>$question['filter']]);
    }
}