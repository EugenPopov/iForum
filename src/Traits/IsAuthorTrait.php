<?php

/*
 * This file is part of the "php-paradise/array-keys-converter" package.
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Traits;

trait IsAuthorTrait
{
    public function IsAuthorOf($entity, $user)
    {
        if (empty($user) or empty($entity)) {
            return false;
        }
        if (['ROLE_ADMIN'] == $user->getRoles()) {
            return true;
        }
        return $entity->getAuthor()->getId() === $user->getId();
    }
}
