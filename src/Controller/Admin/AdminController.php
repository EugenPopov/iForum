<?php

namespace App\Controller\Admin;

use App\Entity\Sections;
use App\Entity\Users;
use App\Form\AddSection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{

    /**
     * This method provides to admin list of all users
     *
     * @var users
     *
     * @Route("/admin/userlist", name="user_list")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function UserList()
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findAll();

        return $this->render('admin/userList.html.twig', ['users'=>$users]);
    }

    /**
     * This method shows all functions allowed to admin
     *
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->render('admin/admin.html.twig');
    }

    /**
     * This method set user role to ROLE_ADMIN
     *
     * @var user get needed user
     *
     * @Route("/admin/give_admin{id}", name="give_admin")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
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
     * This method allow admin to add section
     *
     * @var form create form which u'll have to fill
     *
     * @Route("/admin/add_section", name="add_section")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function AddSection(Request $request)
    {
        $section = new Sections();

        $form = $this->createForm(AddSection::class, $section);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($section);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('admin/addSection.html.twig', ['form'=>$form->createView()]);
    }
}
