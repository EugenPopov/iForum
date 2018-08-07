<?php

/*
 * This file is part of the "php-paradise/array-keys-converter" package.
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Searching;

use App\Entity\Messages;
use App\Entity\Topics;
use App\Repository\MessagesRepository;
use App\Repository\TopicsRepository;
use Doctrine\ORM\EntityManager;

class FindByQuestion
{
    public function index($question, EntityManager $entitymanager)
    {
        switch ($question['filter']) {
            case 1:
                /** @var MessagesRepository $MRepository */
                $MRepository = $entitymanager->getRepository(Messages::class);
                $results = $MRepository->getQuery($question);

                break;
            case 2:
                /** @var TopicsRepository $TRepository */
                $TRepository = $entitymanager->getRepository(Topics::class);
                $topics = $TRepository->getQuery($question);

                if(empty($topics))
                    return null;

                foreach ($topics as $topic) {
                    $topic = $entitymanager->getRepository(Topics::class)->findOneBy(['section'=>$topic[1]]);
                    $results[] = ['1' => $topic->getId(),'name'=>$topic->getName()];
                }

                break;
            case 3:
                /** @var MessagesRepository $MRepository */
                /** @var TopicsRepository $TRepository */
                $MRepository = $entitymanager->getRepository(Messages::class);
                $TRepository = $entitymanager->getRepository(Topics::class);
                $results[] = $MRepository->getQuery($question);
                $topics = $TRepository->getQuery($question);

                foreach ($topics as $topic) {
                    $topic = $entitymanager->getRepository(Topics::class)->findOneBy(['section'=>$topic[1]]);
                    $results[1][] = ['1' => $topic->getId(),'name'=>$topic->getName()];
                }


                break;
        }

        return $results;
    }
}
