<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function index()
    {
        return $this->render('admin/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
