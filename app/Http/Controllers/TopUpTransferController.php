<?php

namespace App\Http\Controllers;

use App\Models\AdminTopupHistory;
use App\Models\AgentTopupHistory;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TopUpTransferController extends Controller
{
    public function index()  // show all
    {
        $user = AdminTopupHistory::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $user], 200);
    }

    public function getAllAgents()  // show all
    {
        $user = AgentTopupHistory::orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'data' => $user], 200);
    }


    public function getByAgent($id)  // show all
    {
        $user = AgentTopupHistory::orderBy('id', 'desc')->where('agentId', $id )->get();

        return response()->json([
            'status' => true,
            'data' => $user], 200);
    }

  
    public function showMonthAdmin($month)
    {
        $historyByMonth = AdminTopupHistory::whereMonth('created_at', $month)->get();

        return response()->json([
            'status' => true,
            'data' => $historyByMonth
      ], 201);
    }

    public function showMonthByAgent($month)
    {
        $user = Auth::user()->id;

        $historyByMonthById = AgentTopupHistory::where('agentId', $user)->whereMonth('created_at', $month)->get();

        return response()->json([
            'status' => true,
            'data' => $historyByMonthById
      ], 201);
    }

    public function agentTransferHistory(Request $request)  // show all
    {

        $agentId = Auth::user()->id;

        $example1 = new AgentTopupHistory;
        $example1->agentId = $agentId;
        $example1->resellerId = $request->resellerId;
        $example1->topUpUsd = $request->topUpUsd;
        $example1->topUpLbp = $request->topUpLbp;
        $example1->topUpUsdLeft =$request->topUpUsd;
        $example1->topUpLbpLeft =$request->topUpLbp;
        $example1->receivedMoney = $request->receivedMoney;
        $example1->save();

        return response()->json([
            'status' => true], 200);
    }

    public function updateAdmin(Request $request, $id)  // update data
    {
        $validator = Validator::make($request->all(), [
            'receivedMoney' => 'integer',
            'topUpUsdLeft' => 'integer',
            'topUpLbpLeft' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator-> errors()->first()], 400);
        }

        $example = AdminTopupHistory::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => 'Top up failed to update'], 404);
        }
    
        $example->topUpUsdLeft = $request->topUpUsdLeft ?? $example->topUpUsdLeft;
        $example->topUpLbpLeft = $request->topUpLbpLeft ?? $example->topUpLbpLeft;
        $example->receivedMoney = $request->receivedMoney ?? $example->receivedMoney;
        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully updated Top up'], 200);
    }

    public function updateAgent(Request $request, $id)  // update data
    {
        $validator = Validator::make($request->all(), [
            'receivedMoney' => 'integer',
            'topUpUsdLeft' => 'integer',
            'topUpLbpLeft' => 'integer',
            'topUpUsd' => 'integer',
            'topUpLbp' => 'integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator-> errors()->first()], 400);
        }

        $example = AgentTopupHistory::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => 'Top up failed to update'], 404);
        }
   
        $example->topUpUsdLeft = $request->topUpUsdLeft ?? $example->topUpUsdLeft;
        $example->topUpLbpLeft = $request->topUpLbpLeft ?? $example->topUpLbpLeft;
        $example->receivedMoney = $request->receivedMoney ?? $example->receivedMoney;
        $example->save();

    

        return response()->json([
            'status' => true,
            'message' => 'Successfully updated Top up'], 200);
    }
}
