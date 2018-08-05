<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{

    /**
     * @Route("/admin/userlist", name="user_list")
     */
    public function UserList()
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findAll();

        return $this->render('users/userList.html.twig',['users'=>$users]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        $q = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['id'=>3]);

        echo '<a href="admin/userlist">User List</a>';

        return new Response('');
    }

    /**
     * @Route("/admin/give_admin{id}", name="give_admin")
     */
    public function giveAdmin($id)
    {
        $em= $this->getDoctrine()->getManager();

        $user = $em->getRepository(Users::class)->findOneBy(['id'=>$id]);

        $user->setRoles(['ROLE_ADMIN']);

        $em->flush();

        return $this->redirectToRoute('user_list');
    }

}