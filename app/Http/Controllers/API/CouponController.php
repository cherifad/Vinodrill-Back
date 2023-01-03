<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Boncommande;
use App\Models\Reservation;

class CouponController extends Controller
{
    public function check(Request $request)
    {
        $coupon = Coupon::where('codebonreduction', $request->coupon)->first();
        if ($coupon && $coupon->estvalide) {
            $coupon_amount = Commande::find($coupon->refcommande)->prixcommande;
            return response()->json(['amount' => $coupon_amount, 'id' => $coupon->idbonreduction]);
        }    

        $bon_commande = Boncommande::where('codeboncommande', $request->coupon)->first();
        if ($bon_commande && $bon_commande->estvalide) {
            $reservations = Reservation::where('refcommande', $bon_commande->refcommande)->get();
            return response()->json(['reservations' => $reservations, 'id' => $bon_commande->idboncommande]);
        } else {
            return response()->json(['amount' => null, 'request' => $request->coupon]);
        }
    }    
}
