<?php

namespace App\Services;

use App\Entity\Commande;
use Symfony\Component\Yaml\Yaml;


class Price
{

    private $ages = [];
    private $reducedPrice = [];


    public function getPrice(Commande $commande){

        $priceInfo = Yaml::parseFile('../config/parameters.yaml');
        $price = 0;

        foreach($this->ages as $info){
            if ($info >= 4 AND $info <= 11)
            {
                $price = $price + $priceInfo['childPrice'];
            }

            elseif($info >= 12 AND $info <= 59){
                $price = $price + $priceInfo['normalPrice'];
            }

            elseif($info >= 60){
                $price = $price + $priceInfo['seniorPrice'];
            }

            else
            {
                $price = $price + 0;
            }
        }

        foreach($this->reducedPrice as $reduced){
            if($reduced == 1)
            {
                $price = $price - $priceInfo['reducedPrice'];
            }
        }

        if($commande->getTicketType() == 'j2'){
            $price = $price / 2;
        }

        return $price;
    }

    public function setPrice(Commande $commande){
        $tickets = $commande->getTickets();

        foreach($tickets as $ticket){
            $birthday = $ticket->getBirthday();
            $reduced = $ticket->getReducedPrice();
            $age = $birthday->diff(new \DateTime())->format('%Y');
            array_push($this->ages, $age);
            array_push($this->reducedPrice, $reduced);
        }
    }
}