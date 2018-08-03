<?php

namespace App\Service\Searching;

use App\Entity\Messages;
use App\Entity\Topics;
use App\Repository\MessagesRepository;
use App\Repository\TopicsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FindByQuestion extends AbstractController
{
    public function index($question)
    {
        $doctrine = $this->getDoctrine();
        switch ($question['filter']){
            case 1:
                /** @var MessagesRepository $MRepository */
                $MRepository = $doctrine->getRepository(Messages::class);
                $results = $MRepository->getQuery($question);

                break;
            case 2:
                /** @var TopicsRepository $TRepository */
                $TRepository = $doctrine->getRepository(Topics::class);
                $results = $TRepository->getQuery($question);

                break;
            case 3:
                /** @var MessagesRepository $MRepository */
                /** @var TopicsRepository $TRepository */
                $MRepository = $doctrine->getRepository(Messages::class);
                $TRepository = $doctrine->getRepository(Topics::class);
                $results[] = $MRepository->getQuery($question);
                $results[] = $TRepository->getQuery($question);
                break;
        }
        return $results;
    }

}