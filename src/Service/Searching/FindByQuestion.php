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
                $results = $TRepository->getQuery($question);

                break;
            case 3:
                /** @var MessagesRepository $MRepository */
                /** @var TopicsRepository $TRepository */
                $MRepository = $entitymanager->getRepository(Messages::class);
                $TRepository = $entitymanager->getRepository(Topics::class);
                $results[] = $MRepository->getQuery($question);
                $results[] = $TRepository->getQuery($question);


                break;
        }

        return $results;
    }
}
