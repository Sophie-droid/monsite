<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produits;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        $bdd_products = $this->getDoctrine()
        ->getRepository(Produits::class)
        ->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $bdd_products,
        ]);
    }
   
}
