<?php

namespace App\Service\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserService extends AbstractController
{
    public function getUserId()
    {
        if (null != $this->getUser()) {
            return $this->getUser()->getId();
        }

        return 0;
    }
}
