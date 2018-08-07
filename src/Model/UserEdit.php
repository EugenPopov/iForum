<?php

namespace App\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class UserEdit
{
    private $userName;


    private $email;

    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password"
     * )
     */
    private $Password;

    /**
     * @return mixed
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword(): string
    {
        return $this->Password;
    }

    /**
     * @param mixed $oldPassword
     */
    public function setPassword($Password): void
    {
        $this->Password = $Password;
    }
}
