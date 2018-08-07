<?php

/*
 * This file is part of the "php-paradise/array-keys-converter" package.
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service\Messages;

use App\Entity\Messages;
use App\Entity\Topics;
use App\Repository\MessagesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;

class MessageService
{
    public function AddMessageAction(ObjectManager $entityManager, Topics $topics, Messages $messages, MessagesRepository $messagesRepository, $loggedUser)
    {
        $messages->setTopics($topics);
        $messages->setAuthor($loggedUser);

        $entityManager->persist($messages);
        $entityManager->flush();
        $last_id = $messages->getId();
        $last_message = $messagesRepository->findOneBy(['id' => $last_id]);

        $topics->setLastMessage($last_message);

        $entityManager->flush();
    }

    public function DeleteMessageAction(Messages $message, EntityManagerInterface $entityManager, MessagesRepository $MRepository, MessagesRepository $query)
    {
        $topic_id = $message->getTopics()->getId();

        if ($message->getText() == $message->getTopics()->getLastMessage()->getText()) {
            $message->getTopics()->setLastMessage(null);
            $entityManager->persist($message);
        }

        $entityManager->remove($message);
        $entityManager->flush();


        if (null != $entityManager->getRepository(Messages::class)->findBy(['topics' => $topic_id])) {
            $message_list = $query->lastMessage($MRepository->findOneBy(['topics' => $topic_id]));
            $topic = $entityManager->getRepository(Topics::class)->findOneBy(['id'=>$topic_id]);

            $topic->setLastMessage($message_list);
            $entityManager->persist($topic);
            $entityManager->flush();
        }
    }
}
