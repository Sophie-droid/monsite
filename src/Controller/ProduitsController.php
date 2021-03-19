<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Produits;

class ProduitsController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(SessionInterface $session, ProduitsRepository $productRepository): response
    
    {
        $bdd_products = $this->getDoctrine()
        ->getRepository(Produits::class)
        ->findAll();
        return $this->render('product/index.html.twig', [
            'product'=> $bdd_products
        ]);
    }
    /**
     * @Route("/produit/{id}", name="product")
     */
    public function detail(int $id):Response
    {
        
        $produit = $this->getDoctrine()
        ->getRepository(Produits::class)
            ->find($id);


            return $this->render('product/index.html.twig', [
                'produit' => $produit
               
              ]);
    }

}