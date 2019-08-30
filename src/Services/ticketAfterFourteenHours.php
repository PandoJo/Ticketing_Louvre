<?php

namespace App\Services;

use App\Entity\Commande;

class ticketAfterFourteenHours{

     public function testHours(Commande $commande){
         
        $now = new \DateTime();
        $visit = $commande->getVisitDay();
        $type = $commande->getTicketType();

        if ((date_format($visit, 'd/m/Y') === date_format($now,'d/m/Y')) && (date_format($now,'H') >= 14)
            && $type === "j1"){

            return true;
        }

        else{
            
            return false;
        }

     }   
    
        
    
}


