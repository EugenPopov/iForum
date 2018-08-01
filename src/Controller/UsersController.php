<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 01.08.18
 * Time: 12:19
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Users;

class UsersController extends Controller
{

    /**
     * @Route("/user/{id}", name="user")
     */
    public function ShowUser($id)
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $user = $repository->findOneBy(['id'=>$id]);

        return $this->render('users/user.html.twig',['user'=>$user]);
    }

    /**
     * @Route("/userlist", name="user_list")
     */
    public function UserList()
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findAll();

        return $this->render('users/userList.html.twig',['users'=>$users]);
    }
}