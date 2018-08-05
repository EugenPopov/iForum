<?php

namespace App\Controller;

use App\Entity\Sections;
use App\Entity\Users;
use App\Form\AddSection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

        return $this->render('admin/userList.html.twig',['users'=>$users]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {

        return $this->render('admin/admin.html.twig');
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

    /**
     * @Route("/admin/add_section", name="add_section")
     */
    public function AddSection(Request $request)
    {
        $section = new Sections();

        $form = $this->createForm(AddSection::class,$section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($section);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render('admin/addSection.html.twig',['form'=>$form->createView()]);
    }

}