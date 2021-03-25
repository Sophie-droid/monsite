<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Order;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
  /**
   * @Route("/commande/creation", name="order_create")
   */
  public function create(SessionInterface $session, Security $security, 
  EntityManagerInterface $entityManager, ProduitsRepository $produitsRepository)
  {
    $panier = $session->get('panier', []);
    $order = new Order();
    $user = $security->getUser();

    if (!empty($user)) {
      $order->setUser($user);
    }

    foreach ($panier as $produitId => $produitQuantity) {
      $produit = $produitsRepository->find($produitId);

    //   $orderHasProduits = new OrderHasProduits();
    //   $orderHasProduits->setProduit($produit);
    //   $orderHasProduits->setQuantite($produitQuantity);

    //   $order->addHasProduit($orderHasProduits);
    }

    $entityManager->persist($order);
    $entityManager->flush();
    if($order->getId()){
      $this->addFlash('success', 'Votre commande a bien été enregistrée.');
      $session->set('panier', []);

      return $this->redirectToRoute('order_history');
    } else {
      $this->addFlash('error', 'Votre commande n\'a pu être enregistrée.');

      return $this->redirectToRoute('index');
    }
  }

  /**
   * @Route("/commandes/historique", name="order_history")
   */
  public function getByCurrentUser(Security $security): Response
  {
    $user = $security->getUser();
    $orders = [];

    if($user){
      $bdd_user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($user->getId());

      $orders = $bdd_user->getOrders();
    }

    return $this->render('order/index.html.twig', [
      'orders' => $orders,
    ]);
  }
}