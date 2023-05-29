<?php

namespace App\Http\Controllers;

use App\Models\LimitPurchase;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
            'message'=>"New Lbp limit of $setLimitPurchaseLbp has been set to all Resellers, the new limit will be updated for all Resellers at 12:00 AM.",
            'status' => true
        ],200);   
    }

    public function setLimitUSDReseller(Request $request){
        $setLimitPurchaseUsd = $request->input('setLimitUsd') ;
        LimitPurchase::query()->update(['usdLimitReseller' => $setLimitPurchaseUsd]);

        return response()->json([
            'message'=>"New Usd limit of $setLimitPurchaseUsd has been set to all Resellers, the new limit will be updated for all Resellers at 12:00 AM.",
            'status' => true
        ],200);   
    }

    public function setLimitLBPAgent(Request $request){
        $setLimitPurchaseLbp = $request->input('setLimitLbp') ;
        User::query()->where('role', 'Agent')->update(['limitPurchaseLbp' => $setLimitPurchaseLbp]);

        return response()->json([
            'message'=>"New Lbp limit of $setLimitPurchaseLbp has been set to all Agenst, the new limit has been updated now.",
            'status' => true
        ],200);   
    }

    public function setLimitUSDAgent(Request $request){
        $setLimitPurchaseUsd = $request->input('setLimitUsd') ;
        User::query()->where('role', 'Agent')->update(['limitPurchaseUsd' => $setLimitPurchaseUsd]);

        return response()->json([
            'message'=>"New Usd limit of $setLimitPurchaseUsd has been set to all Agents, the new limit has been updated now.",
            'status' => true
        ],200);   
    }

    public function setAgentLimitOne(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'limitPurchaseLbp' => 'integer',
            'limitPurchaseUsd' => 'integer',
        ]);

      
        $example = User::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => 'Limit failed to update'], 400);
        }
        
        $example->limitPurchaseLbp = $request->limitPurchaseLbp ?? $example->limitPurchaseLbp;
        $example->limitPurchaseUsd = $request->limitPurchaseUsd ?? $example->limitPurchaseUsd;

        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully updated limit for Agnet'], 200);
    }
}
