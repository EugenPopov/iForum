<?php

namespace App\Service\Adding;


use App\Entity\Messages;
use App\Entity\Topics;
use Doctrine\ORM\EntityManagerInterface;

class MessageService
{
    public function AddMessageAction(EntityManagerInterface $entityManager, Topics $topics, Messages $messages)
    {
        $messages->setTopics($topics);
        $messages->setAuthor($this->getUser());

        $entityManager->persist($messages);
        $entityManager->flush();
        $last_id = $messages->getId();
        $last_message = $messages->findOneBy(['id'=>$last_id]);

        $topics->setLastMessage($last_message);

        $entityManager->flush();
    }

}