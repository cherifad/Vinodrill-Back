<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;
use App\Models\Client;
use App\Models\CB;
use App\Models\Commande;
use App\Models\Reservation;
use App\Models\Adresse;
use App\Models\Paiement;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\Hash;
use stdClass;
use Carbon\Carbon;
use App\Models\Coupon;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $articles = $request->articles;
        $save_crendentials = $request->save_crendentials;
        $idadresse = $request->idadresse; 
        $redirect_sucess = "/payment/success?session_id={CHECKOUT_SESSION_ID}&idclient=" . $request->idclient . "&idadresse=" . $idadresse;
        $cheque_cadeau = $request->cheque_cadeau;
        $coupon_param = $request->coupon;

        if (session()->has('additional_data')) {
            session()->forget('additional_data');
        }

        // create the local session for storing payments data
        $additional_data = new stdClass();
        $additional_data->reservations = $request->details;
        $additional_data->cheque_cadeau = $cheque_cadeau;
        $additional_data->notecommande = $request->notecommande;
        $additional_data->idclient = $request->idclient;
        $additional_data->estcadeau = $request->estcadeau;
        $additional_data->save_credentials = $save_crendentials;
        
        // Create a null customer
        $customer = null;

        // Retrieve a customer by email address
        $customers = Customer::all([
            'email' => $request->email,
        ]);

        if ($customers->count() > 0) {
            $customer = $customers->first();
        } else {
            $customer = Customer::create([
                'email' => $request->email,
                'name' => $request->name,
                'preferred_locales' => ['fr-FR'],
            ]);
        }

        $additional_data->stripe_customer_id = $customer->id;

        // set customer billing address
        $adresse = Adresse::find($idadresse);

        // set customer billing address
        $customer = Customer::update(
            $customer->id,
            [
                'address' => [
                    'line1' => $adresse->rueadresse,
                    'city' => $adresse->villeadresse,
                    'postal_code' => $adresse->cpadresse,
                    'country' => $adresse->pays,
                ],
            ]
        );

        // Create the Stripe Checkout session
        $stripe_options = [
            'payment_method_types' => ['card'],
            'invoice_creation' => ['enabled' => true],
            'line_items' => 
                array_map(function ($article) {
                    return [
                        '[price_data][product_data][name]' => $article['name'],
                        '[price_data][product_data][description]' => $article['description'],
                        '[price_data][unit_amount]' => $article['unit_amount'],
                        '[price_data][currency]' => 'eur',
                        '[quantity]' => $article['quantity'],
                        '[price_data][product_data][images]' => [$article['image']],
                    ];
                }, $articles),
            'success_url' => url('/payment/success?sessionId={CHECKOUT_SESSION_ID}&idclient=' . $request->idclient),
            'cancel_url' => url(env('FRONTEND_URL') . '/paiement?error=cancel'),
            'mode' => 'payment',
            'customer' => $customer->id,
        ];

        if($coupon_param != null) {
            $coupon = Coupon::where('codebonreduction', $coupon_param)->first();
            $coupon_id = $coupon->codebonreduction;
            $coupon_amount = $coupon->montant($coupon->refcommande);

            $additional_data->coupon = $coupon;

            // create the coupon in stripe if it doesn't exist

            try {
                $coupon = \Stripe\Coupon::retrieve($coupon_id, []);
            } catch (\Stripe\Exception\InvalidRequestException $e) {
                \Stripe\Coupon::create([
                    'id' => $coupon_id,
                    'amount_off' => $coupon_amount * 100,
                    'currency' => 'eur',
                    'duration' => 'once',
                ]);
            }
            // add the coupon to the stripe options
            $discounts = array(
                array(
                  'coupon' => $coupon_id,
                ),
              );
            array_push($stripe_options, [
                'discounts' => $discounts,
            ]);
        }
        
        if ($save_crendentials) {
            // Create the Stripe Checkout session and save the payment method
            array_push($stripe_options, [
                'payment_intent_data' => [
                    'setup_future_usage' => 'on_session',
                ],
            ]);
            $session = Session::create($stripe_options);
        } else {
            // Create the Stripe Checkout session without saving the payment method
            $session = Session::create($stripe_options);
        }        

        $additional_data->session_id = $session->id;
        // save the session id in the local session
        session(['additional_data' => $additional_data]);


        return response()->json(['checkoutURL' => $session->url]);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // get data from url params
        $sessionId = $request->sessionId;

        // get data from stripe checkout session
        $session = Session::retrieve($sessionId);

        // another way to get the payment method
        $payment_intent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

        // get data from the payment method
        $payment_method = \Stripe\PaymentMethod::retrieve($payment_intent->payment_method);

        // get data from the card
        $card = $payment_method->card;

        // get data from local session
        $additional_data = session('additional_data');

        $commande = new Commande();
        $commande->idclient = $additional_data->idclient;
        $commande->datecommande = Carbon::createFromTimestamp($session->created)->format('Y-m-d H:i:s');
        $commande->message = $additional_data->notecommande;
        $commande->prixcommande = $session->amount_total / 100;
        $commande->quantite = 1;
        $commande->cheminfacture = $session->invoice;
        $commande->estcheque = $additional_data->cheque_cadeau;


        // Retrieve the customer using their ID
        $customer = \Stripe\Customer::retrieve($session->customer);

        $paiement = new Paiement();
        $paiement->idclient = $additional_data->idclient;
        $paiement->libellepaiement = $card->brand;
        $paiement->preference = $additional_data->save_credentials;

        $paiement->save();

        // get the last inserted id in the paiement table
        $idpaiement = Paiement::all()->last()->idpaiement;
        $commande->idpaiement = $idpaiement;
        $commande->save();

        if($additional_data->save_credentials) {
            // check if client has not already a card saved
            $client = Client::find($additional_data->idclient);  
            
            // save the card in the client and check if the client has not already a card saved
            if($client->idcb == null) {
                $cb = new CB();
                $cb->cvc = Hash::make(rand(100, 999)); 
                $cb->codecb = Hash::make($card->last4);              
                $cb->anneeexp = $card->exp_year;
                $cb->moisexp = $card->exp_month;
            } else {
                $cb = CB::find($client->idcb);
                $cb->cvc = Hash::make(rand(100, 999)); 
                $cb->codecb = Hash::make($card->last4);              
                $cb->anneeexp = $card->exp_year;
                $cb->moisexp = $card->exp_month;
            }

            $cb->save();

            // get the highest id in the cb table and save it in the client
            $idcb = CB::all()->last()->idcb;
            $client->idcb = $idcb;
            $client->save();
        }

        $refcommande = Commande::orderBy('refcommande', 'desc')->first()->refcommande;

        foreach($additional_data->reservations as $reservation) {
            $res = new Reservation();
            // dd($reservation);
            $res->refcommande = $refcommande;
            $res->idsejour = $reservation["idsejour"];
            $res->datedebutreservation = $reservation["datedebutreservation"];
            // $res->estcadeau = $reservation["estcadeau"];
            $res->estcadeau = $reservation["estcadeau"];
            $res->nbenfant = $reservation["nbEnfants"];
            $res->nbadulte = $reservation["nbAdultes"];
            $res->nbchambre = $reservation["nbChambres"];
            $res->save();
        }

        if(isset($additional_data->coupon)) {
            $additional_data->coupon->estvalide = false;
            $additional_data->coupon->save();
        }

        // wipe the local session
        session()->forget('additional_data');

        return redirect()->to(env('FRONTEND_URL') . '/paiement/merci' . '?session_id=' . $sessionId . '&refcommande=' . $refcommande);
    }

    public function sucess_v2 (Request $request) {
        $event = $request->json();
      
        if ($event['type'] === 'payment_intent.succeeded') {
          $paymentIntent = $event['data']['object'];
      
          // Handle the successful payment here
          // You can retrieve the payment intent data using the PaymentIntent object
          // For example:
          $amount = $paymentIntent['amount'];
          $currency = $paymentIntent['currency'];
          // etc.
        }
    }
}