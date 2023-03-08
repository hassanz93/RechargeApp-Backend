<?php

namespace App\Http\Controllers;

use App\Models\TransactionHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
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

    public function showId($id)  // show one
    {
        $historyDetails = TransactionHistory::all();

        $history = collect($historyDetails)->where('userId', $id)->all();

        return response()->json([
            'status' => true,
            'data' => $history], 201);
    }

    public function store(Request $request)  // save data
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'integer',
            'status' => Rule::in(['In-Progress','Sent']),
            'card' => 'string',
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
