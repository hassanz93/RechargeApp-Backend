<?php

namespace App\Http\Controllers;

use App\Models\LimitPurchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class LimitPurchaseController extends Controller
{
    public function setLimitLBP(Request $request){
        $setLimitPurchaseLbp = $request->input('setLimitLbp') ;
        LimitPurchase::query()->update(['lbpLimit' => $setLimitPurchaseLbp]);

        return response()->json([
            'message'=>"New Lbp limit of $setLimitPurchaseLbp has been set.",
            'status' => true
        ],200);   
    }

    public function setLimitUSD(Request $request){
        $setLimitPurchaseUsd = $request->input('setLimitUsd') ;
        LimitPurchase::query()->update(['usdLimit' => $setLimitPurchaseUsd]);

        return response()->json([
            'message'=>"New Usd limit of $setLimitPurchaseUsd has been set.",
            'status' => true
        ],200);   
    }
}
