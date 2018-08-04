<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 01.08.18
 * Time: 12:19
 */

namespace App\Controller;

use App\Form\EditUserForm;
use App\Model\UserEdit;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Users;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends Controller
{


    /**
     * @Route("/edit/user", name="esit_user")
     */

    public function EditUser(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Users::class)->findOneBy(['id'=>$this->getUser()->getId()]);

        $newUser = new UserEdit();
        $newUser->setUserName($user->getUsername());
        $newUser->setEmail($user->getEmail());

        $form = $this->createForm(EditUserForm::class,$newUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $encoder->encodePassword($user, $newUser->getPlainPassword());
            $user->setUsername($newUser->getUserName());
            $user->setEmail($newUser->getEmail());
            $user->setPassword($password);

            $em->flush();

            return $this->redirectToRoute('profile');
        }
        return $this->render('users/edituser.html.twig',['form'=>$form->createView()]);
    }


    /**
     * @Route("/profile", name="profile")
     */
    public function ShowUser()


    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repository = $this->getDoctrine()->getRepository(Users::class);
        $user = $repository->findOneBy(['id'=>$this->getUser()->getId()]);

        return $this->render('users/user.html.twig',['user'=>$user]);
    }

    /**
     * @Route("/admin/userlist", name="user_list")
     */
    public function UserList()
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findAll();

        return $this->render('users/userList.html.twig',['users'=>$users]);
    }
}