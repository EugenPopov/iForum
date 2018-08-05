<?php

namespace App\Controller;

use App\Form\UserType;
use App\Entity\Users;
use App\Service\FileSystem\FileManager;
use App\Service\Registration\UserRegistration;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder, FileManager $fileManager, UserRegistration $registration)
    {
        $user = new Users();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $registration->registerAction($passwordEncoder,$user,$em,$fileManager);

            return $this->redirectToRoute('home');
        }
        return $this->render(
            'registration/register.html.twig',
            ['form' => $form->createView()]
        );
    }
}