<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
    public function postPaymentStripe(Request $request)
    {
        dd(request()->all());
        
        $validator = Validator::make($request->all(), [
            "card_no" => "required",
            "ccExpiryMonth" => "required",
            "ccExpiryYear" => "required",
            "cvvNumber" => "required",
            'amount' => 'required | numeric',
            "description" => "required",
            'stripeToken' => 'required',
        ]);

        $input = $request->except("_token");

        if ($validator->passes()) {
            $stripe = Stripe::setApiKey(env("STRIPE_SECRET"));

            try {
                $token = $stripe->tokens()->create([
                    "card" => [
                        "number" => $request->card_no,
                        "exp_month" => $request->ccExpiryMonth,
                        "exp_year" => $request->ccExpiryYear,
                        "cvc" => $request->cvvNumber,
                    ],
                ]);

                if (!isset($token["id"])) {
                    return redirect()->route("stripe.add.money");
                }

                $charge = $stripe->charges()->create([
                    "card" => $token["id"],
                    "currency" => "EUR",
                    "amount" => $request->amount,
                    "description" => $request->description,
                ]);

                if ($charge["status"] == "succeeded") {
                    dd($charge);
                    return redirect()->route("addmoney.paymentstripe");
                } else {
                    return redirect()
                        ->route("addmoney.paymentstripe")
                        ->with("error", "Money not add in wallet!");
                }
            } catch (Exception $e) {
                return redirect()
                    ->route("addmoney.paymentstripe")
                    ->with("error", $e->getMessage());
            } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
                return redirect()
                    ->route("addmoney.paymentstripe")
                    ->with("error", $e->getMessage());
            } catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                return redirect()
                    ->route("addmoney.paymentstripe")
                    ->with("error", $e->getMessage());
            }
        }
    }
}
