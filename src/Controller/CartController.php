<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseReturned;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ProduitsRepository;
use Stripe\Stripe;


class CartController extends AbstractController
{
    
    /**
     * @Route("/panier", name="cart")
     */
    public function index(SessionInterface $session, ProduitsRepository $productRepository)
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
}


     /**
     * @Route("/panier/ajouter/{id}", name="cart_add")
     */
    public function add($id, SessionInterface $session ) 
    {
        
        $panier = $session->get('panier', []);
        if(!empty($panier[$id])) {
            $panier[$id]++;
        }
        else{
        $panier[$id] = 1;
        }
        $session->set('panier', $panier);
        //dump($session->get('panier'));//
        
        return $this->redirectToRoute("cart");
       
    }
    /**
     * @route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, SessionInterface $session) {
        $panier = $session->get('panier', []);

        if(!empty($panier[$id])) {
            unset($panier[$id]);
        }
        
        $session->set('panier', $panier);

        return $this-> redirectToRoute("cart");
    }

      /**
     * @Route("/create-checkout-session", name="checkout")
     */
    public function checkout(UrlGeneratorInterface $urlGeneratorInterface):response
    {
        \Stripe\Stripe::setApiKey('sk_test_51IYeeVGYmr5sIrV4Gp6kc37Xrk6s2JoK2wrcn0ot2lOi61bldJPK1ASRcD2Bc8x1RenclqOzqbu0sEfdMCCTcQZ500F2TIxabj');
        
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
              'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                  'name' => 'BONBON',
                ],
                'unit_amount' => 20,
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
    // /**
    //  * @Route("/panier/acheter/payment", name="payment")
    //  */
    // public function payment($id,SessionInterface $session, ProduitsRepository $productRepository, UrlGeneratorInterface $urlGeneratorInterface )
    // {
    //     \Stripe\Stripe::setApiKey('sk_test_51IYeeVGYmr5sIrV4Gp6kc37Xrk6s2JoK2wrcn0ot2lOi61bldJPK1ASRcD2Bc8x1RenclqOzqbu0sEfdMCCTcQZ500F2TIxabj');
    //     return $this->render('payment/index.html.twig', [
    //         'controller_name' => 'PaymentController',
    //         'mode' => 'payment',
    //         'success_url' => $this->generateUrl('success', [], UrlGeneratorInterface::ABSOLUTE_URL),
    //         'cancel_url' => $this->generateUrl('error', [], UrlGeneratorInterface::ABSOLUTE_URL),
    //       ]);
    //       return new JsonResponse([ 'id' => $session->id ]);

    //       return $this->redirectToRoute("payment");
    // }


    

