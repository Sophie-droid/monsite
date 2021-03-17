<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class ContactController extends AbstractController
{
    
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(Request $request,\Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $contact = $form->getData(); 
            
            //ici nous enverrons le mail//
            $message = (new \Swift_Message('Nouveau contact'))

            // On attribue l'expéditeur //
            ->setFrom($contact['email'])

            // On attribue le destinataire //
            ->setTo('graibissophie@gmail.com')

            // On crée le texte avec la vue //
            ->setBody(
                $this->renderView(
                    'e-mail/contact.html.twig', compact('contact')
                ),
                'text/html'
            );
            //on envoie le message//
            $mailer->send($message);
            $this->addFlash('message', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.'); 
            //return $this->redirectToRoute('accueil');
        }

            return $this->render('contact/index.html.twig',[
            'contactForm' => $form->createView()

        ]);
    }
}
