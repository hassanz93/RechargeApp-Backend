<?php

namespace App\Http\Controllers;

use App\Models\LimitPurchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class LimitPurchaseController extends Controller
{

    public function index()  // show all
    {
        $phoneDetails = LimitPurchase::all();

        return response()->json([
            'status' => true,
            'data' => $phoneDetails], 201);
    }

    public function setLimitLBPReseller(Request $request){
        $setLimitPurchaseLbp = $request->input('setLimitLbp') ;
        LimitPurchase::query()->update(['lbpLimitReseller' => $setLimitPurchaseLbp]);

        return response()->json([
            'message'=>"New Lbp limit of $setLimitPurchaseLbp has been set to Reseller, the new limit will be updated for all Resellers at 12:00 AM.",
            'status' => true
        ],200);   
    }

    public function setLimitUSDReseller(Request $request){
        $setLimitPurchaseUsd = $request->input('setLimitUsd') ;
        LimitPurchase::query()->update(['usdLimitReseller' => $setLimitPurchaseUsd]);

        return response()->json([
            'message'=>"New Usd limit of $setLimitPurchaseUsd has been set to Reseller, the new limit will be updated for all Resellers at 12:00 AM.",
            'status' => true
        ],200);   
    }

    public function setLimitLBPAgent(Request $request){
        $setLimitPurchaseLbp = $request->input('setLimitLbp') ;
        LimitPurchase::query()->update(['lbpLimitAgent' => $setLimitPurchaseLbp]);

        return response()->json([
            'message'=>"New Lbp limit of $setLimitPurchaseLbp has been set to Agent, the new limit will be updated for all Agents at 12:00 AM.",
            'status' => true
        ],200);   
    }

    public function setLimitUSDAgent(Request $request){
        $setLimitPurchaseUsd = $request->input('setLimitUsd') ;
        LimitPurchase::query()->update(['usdLimitAgent' => $setLimitPurchaseUsd]);

        return response()->json([
            'message'=>"New Usd limit of $setLimitPurchaseUsd has been set to Agent, the new limit will be updated for all Agents at 12:00 AM.",
            'status' => true
        ],200);   
    }
}
