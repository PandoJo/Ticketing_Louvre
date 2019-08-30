<?php

namespace App\Controller;

use App\Entity\Commande;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmailController extends AbstractController
{
       
    
    /**
     * @Route("/mailfor_commande_n°{id}&price={price}", name="mailSend")
     */
    public function mail($id, $price, \Swift_Mailer $mailer)
    {

        $repo = $this->getDoctrine()->getRepository(Commande::class);

        $commande = $repo->find($id);
        $mailSend = $commande->getEmail();

        $characts = 'abcdefghijklmnopqrstuvwxyz';
        $characts .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characts .= '1234567890';

        $codeReservation= '';

        for($i=0;$i < 10;$i++)
        { 
            $codeReservation .= substr($characts,rand()%(strlen($characts)),1);
        }

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('jonall85@gmail.com')
            ->setTo($mailSend)
            ->setBody(
                $this->renderView(
                    //templates/email/email.html.twig,
                'email/email.html.twig',
                    ['commande' => $commande, 'price' => $price, 'codeReservation' => $codeReservation]
                ),
                'text/html'
            );

        $mailer->send($message);

        return $this->redirectToRoute('home');
    }
}

?>