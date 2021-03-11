<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil(): Response
    {
        return $this->render('site/accueil.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }

    /**
     * @Route("/produits", name="produits")
     */
    public function produits (): Response
    {
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