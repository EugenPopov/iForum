<?php

namespace App\Controller;


use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends Controller
{

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        $q = $this->getDoctrine()->getRepository(Users::class)->findOneBy(['id'=>3]);

        return new Response(var_dump($q));
    }

}