<?php

namespace App\Controller;

use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaymentController extends AbstractController
{
    /**
     * @Route("/commande_n°{id}&price={price}", name="payment_stripe")
     */
    public function paiement($price, $id)
    {
        return $this->render('payment/payment.html.twig', [
            'price' => $price,
            'id' => $id
            ]);
    }


    /**
     * @Route("/validationfor_commande_n°{id}&price={price}", name="charge")
     */
    public function validation($id, $price){

        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey("sk_test_1rtLIzpkNBcI6rs5pJccWHCZ00ylCyl7oY");

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:
        $token = $_POST['stripeToken'];
        $charge = \Stripe\Charge::create([
            'amount' => $price . '00',
            'currency' => 'eur',
            'description' => 'Example charge',
            'source' => $token,
        ]);
        return $this->redirectToRoute('mailSend', [
            'id' => $id,
            'price' => $price]);
    }
}
