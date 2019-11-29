<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class AccueilController extends AbstractController
{
    /**
     * @Route("/accueil", name="accueil")
     * @param ProductRepository $repository
     * @return Response
     */
    public function index(ProductRepository $repository): Response
    {

        $products = $repository->findLatest();
        return $this->render('accueil/accueil/index.html.twig', [
            'products' => $products
        ]);
    }
}
