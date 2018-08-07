<?php

namespace App\Traits;

trait IsAuthorTrait
{
    public function IsAuthorOf($entity, $user)
    {
        if (empty($user) or empty($entity)) {
            return false;
        }

        if ('ROLE_ADMIN' == $user->getRoles()) {
            return true;
        }

        return $entity->getAuthor()->getId() === $user->getId();
    }
}
