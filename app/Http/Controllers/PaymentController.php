<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\PaymentMethod;
use App\Models\User;
use App\Models\Commande;
use App\Models\Reservation;
use App\Models\Adresse;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $articles = $request->articles;
        $save_crendentials = $request->save_crendentials;
        $idadresse = $request->idadresse; 
        $redirect_sucess = "/payment/success?session_id={CHECKOUT_SESSION_ID}&idclient=" . $request->idclient . "&idadresse=" . $idadresse;

        $adresse = Adresse::find($idadresse);

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
                'metadata' => [
                    'idclient' => $request->idclient,
                ],
            ]);
        }

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
        
        if ($save_crendentials) {
            // Create the Stripe Checkout session
            $session = Session::create([
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
                        ];
                    }, $articles),
                'success_url' => url('/payment/success?session_id={CHECKOUT_SESSION_ID}&idclient=' . $request->idclient),
                'cancel_url' => url(env('FRONTEND_URL') . '/paiement?error=cancel'),
                'mode' => 'payment',
                'customer' => $customer->id,
                'payment_intent_data' => [
                    'setup_future_usage' => 'on_session',
                    'metadata' => [
                        "details" => "test",
                        "gift" => "false",
                    ],
                ],
            ]);
        } else if ($customer != null) {
            $session = Session::create([
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
                        ];
                    }, $articles),
                'success_url' => url('/payment/success?session_id={CHECKOUT_SESSION_ID}&idclient=' . $request->idclient),
                'cancel_url' => url(env('FRONTEND_URL') . '/paiement?error=cancel'),
                'mode' => 'payment',
                'customer' => $customer->id,
                'payment_intent_data' => [
                    'setup_future_usage' => 'off_session',
                ],
            ]);
        } else {
            // Create the Stripe Checkout session
            $session = Session::create([
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
                'success_url' => url('/payment/success?session_id={CHECKOUT_SESSION_ID}&idclient=' . $request->idclient),
                'cancel_url' => url(env('FRONTEND_URL') . '/paiement?error=cancel'),
                'mode' => 'payment',
                'customer_email' => $request->email,
            ]);
        }        

        return response()->json(['checkoutURL' => $session->url]);
    }

    public function success(Request $request)
    {
        // get data from url params
        $session_id = $request->session_id;

        return redirect()->to(env('FRONTEND_URL') . '/paiement/merci' . '?session_id=' . $session_id);
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