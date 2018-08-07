<?php

namespace App\Controller\Api;

use App\Entity\Messages;
use App\Entity\Users;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends FOSRestController
{
    /**
     * This API method allow u to get Message and it's info
     *
     * @param  $id
     * @return \FOS\RestBundle\View\View
     *
     * @Rest\Get("/message/{id}")
     */
    public function getMessage(int $id)
    {
        $message = $this->getDoctrine()
            ->getRepository(Messages::class)
            ->findOneById($id);

        $results['message'] = [
            'name'=>$message->getId(),
            'text'=>$message->getText(),
            'date'=>$message->getDate(),
        ];
        $topic = $message->getTopics();
        $results['topic'] = [
            'id'=>$topic->getId(),
            'name'=>$topic->getName(),
            'close'=>$topic->getClose(),
        ];

        $results['status'] = [Response::HTTP_OK];
        return View::create($results, Response::HTTP_OK);
    }

    /**
     * This API method allow u to get user info
     *
     * @param  $id
     * @return \FOS\RestBundle\View\View
     *
     * @Rest\Get("/user/{id}")
     */
    public function getUser(int $id)
    {
        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->findOneById($id);

        $results['results'] = [
            'name'=>$user->getId(),
            'username'=>$user->getUserName(),
            'email'=>$user->getEmail(),
            'roles'=>$user->getRoles(),
        ];
        $results['status'] = [Response::HTTP_OK];

        return View::create($results, Response::HTTP_OK);
    }

    /**
     * This API method allow u to delete message
     *
     * @param  $id
     * @return \FOS\RestBundle\View\View
     * @throws
     *
     *
     * @Rest\Get("/delete_message/{id}")
     */
    public function DeleteMessage(int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $message = $em->getRepository(Messages::class)->findOneBy(['id'=>$id]);

        $em->remove($message);
        $em->flush();


        return View::create([], Response::HTTP_NO_CONTENT);
    }
}