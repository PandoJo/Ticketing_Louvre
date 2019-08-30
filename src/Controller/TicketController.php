<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Services\Price;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Services\ticketAfterFourteenHours;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TicketController extends AbstractController
{
    /**
     * @Route("/ticket&error={error}&type={type}", name="ticket_info")
     */
    public function ticket(Request $request, ObjectManager $manager, $error, $type)
    {
        $commande = new Commande();

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $repo = $this->getDoctrine()->getRepository(Commande::class);
            $dateVisit = $commande->getVisitDay();
            $dates = $dateVisit->format('Y/m/d');
            $infoSize = $repo->findLimitDay(new \DateTime($dates));
            $totalTicket = $infoSize['size'];
            
            $hourInfos = new ticketAfterFourteenHours;
            $hourInfo = $hourInfos->testHours($commande);

            if($hourInfo == 0){
                if($totalTicket <= 1000){
                    foreach($commande->getTickets() as $ticket) {
                        $ticket->setCommande($commande);
                        $manager->persist($ticket);
                    }

                    $manager->persist($commande);
                    $manager->flush();

                    return $this->redirectToRoute('recap_commande', ['id' => $commande->getId()]);
                }
                
                else{
                    return $this->redirectToRoute('ticket_info', ['error' => 1, 'type' => 0]);
                }
            }

            else{
                return $this->redirectToRoute('ticket_info', ['type' => 1, 'error' => 0]);
            }
           
        }
        
        return $this->render('ticket/ticket.html.twig', [
            'formCommande' => $form->createView(),
            'error' => $error,
            'type' => $type
        ]);
    }


    /**
     * @Route("/commande_n°{id}", name="recap_commande")
     */
    public function recap($id){

        $repo = $this->getDoctrine()->getRepository(Commande::class);

        $commande = $repo->find($id);

        $priceInfo = new Price;
        $priceInfo->setPrice($commande);
        $price = $priceInfo->getPrice($commande);


        return $this->render('ticket/recap.html.twig', [
                'commande' => $commande,
                'id' => $id,
                'price' => $price,
            ]);

    }
}
