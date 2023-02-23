<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExchangeRateController extends Controller
{

    public function index()  // show all
    {
        $user = ExchangeRate::all();

        return response()->json([
            'status' => true,
            'data' => $user], 201);
    }


    public function update(Request $request, $id)  // update data
    {
        $validator = Validator::make($request->all(), [
            'exchangeRate' => 'required|integer',
        ]);

      
        $example = ExchangeRate::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => 'Exchange Rate failed to update'], 404);
        }

        $example->exchangeRate = $request->exchangeRate ?? $example->exchangeRate;
        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Exchange Rate has been updated'], 200);
    }
}
