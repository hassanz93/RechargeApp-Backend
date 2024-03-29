<?php

namespace App\Http\Controllers;

use App\Models\TransactionHistory;
use App\Models\PhoneCardIndividual;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;

class TransactionHistoryController extends Controller
{
    public function index()  // show all
    {
        $historyDetails = TransactionHistory::all();

        return response()->json([
            'status' => true,
            'data' => $historyDetails], 201);
    }

    public function showLatestPurchaseId()  // show all
    {
        $latestId = TransactionHistory::orderBy('transactionId', 'desc')->first();

        $latestId = $latestId ? $latestId->id : 0;

        return response()->json([
            'status' => true,
            'data' =>  $latestId + 1], 201);
    }


    public function showId($id)  // show one
    {
        $history = TransactionHistory::where('userId', $id)->get();

        return response()->json([
            'status' => true,
            'data' => $history], 201);
    }

    public function showTransactionId($id, $cardId)  // show one
    {
        $history = PhoneCardIndividual::where('transactionId', $id)->where('cardDetailsId', $cardId )->get();

        return response()->json([
            'status' => true,
            'data' => $history], 201);
    }

    public function showMonth($month)
    {
        $historyByMonth = TransactionHistory::whereMonth('created_at', $month)->get();

        return response()->json([
            'status' => true,
            'data' => $historyByMonth
      ], 201);
    }

    public function showMonthById($month)
    {
        $user = Auth::user()->id;

        $historyByMonthById = TransactionHistory::where('userId', $user)->whereMonth('created_at', $month)->get();

        return response()->json([
            'status' => true,
            'data' => $historyByMonthById
      ], 201);
    }

    public function store(Request $request)  // save data

    {
        $validator = Validator::make($request->all(), [
            'transactionId' => 'integer',
            'userId' => 'integer',
            'card' => 'string',
            'cardId' => 'integer',
            'quantity' => 'integer',
            'usdPayed'=> 'integer',
            'lbpPayed'=> 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator-> errors()->first()
          ], 400);
        }

        $histories = $request->json()->all();

        foreach ($histories as $history) {
            TransactionHistory::create($history);
        }

        return response()->json([
            'status' => true,
            'message' => 'Purchase has been made'], 201);
}
}
