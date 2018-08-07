<?php

namespace App\Traits;

trait IsAuthorTrait
{
    public function IsAuthorOf($entity, $user)
    {
        if (empty($user) or empty($entity)) {
            return false;
        }

        if ($user->getRoles() == 'ROLE_ADMIN') {
            return true;
        }

        return $entity->getAuthor()->getId() === $user->getId();
    }
}
