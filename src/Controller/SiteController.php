<?php

namespace App\Controller;

use App\Entity\Produits;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SiteController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil(): Response
    {
       
       $produits = $this->getdoctrine()
       ->getRepository(Produits::class)
       ->findAll();

       //dump($produits);//

        return $this->render('site/accueil.html.twig', [
            'controller_name' => 'SiteController',
            'produits' => $produits
        ]);
    }

    /**
     * @Route("/produits", name="produits")
     */
    public function produits (): Response
    {
        $panier = $session->get('panier', []);
       dump($panier);
        $panierWithData = [];

        foreach($panier as $id => $quantity){
            $panierWithData[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }
        $total= 0;

        foreach($panierWithData as $item) {
            $totalItem = $item['product']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }
    
        return $this->render('cart/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total
        ]);
       
        return $this->render('site/produits.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    
    }

     /**
     * @Route("/panier", name="panier")
     */
    public function panier(): Response
    {
        return $this->render('site/panier.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
    
     /**
     * @Route("/compte", name="compte")
     */
    public function compte(): Response
    {
        return $this->render('site/moncompte.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

     /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('site/contact.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

    /**
     * @Route("/conditionsgenerales", name="conditionsgenerales")
     */
    public function conditionsgenerales (): Response
    {
        return $this->render('site/conditions.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

    
}