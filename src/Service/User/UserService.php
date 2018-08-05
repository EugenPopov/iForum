<?php

namespace App\Service\User;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserService extends AbstractController
{

    public function getUserId()
    {
        if($this->getUser() != null)
            return $this->getUser()->getId();
        else
            return 0;
    }
}