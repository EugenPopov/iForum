<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 01.08.18
 * Time: 12:19
 */

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Topics;
use App\Repository\MessagesRepository;
use App\Repository\TopicsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Users;

class SearchController extends Controller
{

    /**
     * @Route("/search", name="search")
     */
    public function ShowResult(Request $request)
    {
        $question = $request->query->get('search');



        switch ($question['filter']){
            case 1:
                /** @var MessagesRepository $MRepository */
                $MRepository = $this->getDoctrine()->getRepository(Messages::class);
                $results = $MRepository->getQuery($question);

            break;
            case 2:
                /** @var TopicsRepository $TRepository */
                $TRepository = $this->getDoctrine()->getRepository(Topics::class);
                $results = $TRepository->getQuery($question);

            break;
            case 3:
                /** @var MessagesRepository $MRepository */
                /** @var TopicsRepository $TRepository */
                $MRepository = $this->getDoctrine()->getRepository(Messages::class);
                $TRepository = $this->getDoctrine()->getRepository(Topics::class);
                $results[] = $MRepository->getQuery($question);
                $results[] = $TRepository->getQuery($question);
            break;
        }

        return $this->render('search/list.html.twig',['results'=>$results,'filter'=>$question['filter']]);
    }
}