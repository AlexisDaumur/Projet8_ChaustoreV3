<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ColorController extends AbstractController
{
    /**
     * @Route("/color", name="color")
     */
    public function index()
    {
        return $this->render('admin/color/index.html.twig', [
            'controller_name' => 'ColorController',
        ]);
    }
}
