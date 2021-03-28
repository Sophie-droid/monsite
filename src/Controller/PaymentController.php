<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseReturned;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

use Stripe\Stripe;

class PaymentController extends AbstractController
{
    /**
     * @Route("/payment", name="payment")
     */
    public function index(UrlGeneratorInterface $urlGeneratorInterface)
    {
        return $this->render('payment/index.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
    /**
     * @Route("/success", name="success")
     */
    public function success(): response
    {
        return $this->render('payment/success.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
    /**
     * @Route("/error", name="error")
     */
    public function error():response 
    {
        return $this->render('payment/error.html.twig', [
            'controller_name' => 'PaymentController',
        ]);
    }
     /**
     * @Route("/create-checkout-session /{id}", name="checkout")
     */
    public function checkout($id):JsonResponse
    {
        \Stripe\Stripe::setApiKey('sk_test_51IYyyULDcAnwvEyZPGHybF6JZCVdaCXRzbT2JvPur8StsbpvmyZXOQTF9jFBu8Ybsdiu7DPxyLEw208Rodk7dfgm00adufznh4');
        
//RECUPERER LA COMMANDE EN BASE DE DONNEES //

//     $create = $this->getDoctrine(): ManagerRegistry
//     ->getRepository(checkout::class)
//         ->find($id) ;

//         return $this->render('order/index.html.twig', [
//             'checkout' => $create-checkout-session
           
//           ]);
// }

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
              'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                  'name' => '',
                ],
                'unit_amount' => 2000,//ordertotal//
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('error', [], UrlGeneratorInterface::ABSOLUTE_URL),
          ]);
          return new JsonResponse([ 'id' => $session->id ]);
         
       
    }
}
