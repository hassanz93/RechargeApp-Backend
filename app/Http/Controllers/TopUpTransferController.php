<?php

namespace App\Http\Controllers;

use App\Models\AdminTopupHistory;
use App\Models\AgentTopupHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TopUpTransferController extends Controller
{
    public function index()  // show all
    {
        $user = AdminTopupHistory::orderBy('id', 'desc')->get();

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

    public function adminTransferHistory(Request $request)  // show all
    {
        $example1 = new AdminTopupHistory;
        $example1->agentId = $request->agentId;
        $example1->topUpUsd =$request->topUpUsd;
        $example1->topUpLbp =$request->topUpLbp;
        $example1->receivedMoney =$request->receivedMoney;
        $example1->save();

        return response()->json([
            'status' => true], 200);
    }

    public function agentTransferHistory(Request $request)  // show all
    {

        $agentId = Auth::user()->id;

        $example1 = new AgentTopupHistory;
        $example1->agentId = $agentId;
        $example1->resellerId = $request->resellerId;
        $example1->topUpUsd = $request->topUpUsd;
        $example1->topUpLbp = $request->topUpLbp;
        $example1->receivedMoney = $request->receivedMoney;
        $example1->save();

        return response()->json([
            'status' => true], 200);
    }
}
