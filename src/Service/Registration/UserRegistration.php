<?php

namespace App\Service\Registration;

use App\Entity\Users;
use App\Service\FileSystem\FileManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserRegistration
{
    public function registerAction(UserPasswordEncoderInterface $passwordEncoder, Users $users, EntityManagerInterface $entityManager, FileManager $fileManager)
    {
        if($fileName = $fileManager->upload($users->getImage())){
            $users->setImage($fileName);
        }
        $password = $passwordEncoder->encodePassword($users, $users->getPlainPassword());
        $users->setPassword($password);

        $entityManager->persist($users);
        $entityManager->flush();
    }
}