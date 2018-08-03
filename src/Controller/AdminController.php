<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController
{

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        echo '<a href="/userlist">';
        return new Response('u are in adminke');
    }

}