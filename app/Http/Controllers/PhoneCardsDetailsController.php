<?php

namespace App\Http\Controllers;

use App\Models\PhoneCardsDetails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PhoneCardsDetailsController extends Controller
{

    public function index()  // show all
    {
        $phoneDetails = PhoneCardsDetails::all();

        return response()->json([
            'status' => true,
            'data' => $phoneDetails], 201);
    }

    public function store(Request $request)  // save data
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'categoryId' => Rule::in([1,2]),
            'type' => Rule::in(['Magic','Start','Smart','Alpha']),
            'dollarPrice' => 'required|integer',
            'validity' => 'required|integer',
            'purchaseQuantity' => 'integer',
            'grace' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()], 400);
        }

        $example = new PhoneCardsDetails;
        $example->name = $request->name;
        $example->categoryId = $request->categoryId;
        $example->type = $request->type;
        $example->dollarPrice =$request->dollarPrice;
        $example->validity = $request->validity;
        $example->purchaseQuantity = $request->purchaseQuantity;
        $example->grace = $request->grace;
        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully created item'], 201);
    }

    public function addCsv(Request $request)
{

    $validator = Validator::make($request->all(), [
        'name' => 'string',
        'categoryId' => Rule::in([1,2]),
        'type' => Rule::in(['Magic','Start','Smart','Alpha']),
        'dollarPrice' => 'integer',
        'validity' => 'integer',
        'purchaseQuantity' => 'integer',
        'grace' => 'integer',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->first()], 400);
    }

    $cards = $request->json()->all();
    
    foreach ($cards as $card) {
        PhoneCardsDetails::create($card);
    }

    return response()->json([
        'status' => true,
        'message' => 'All Cards have been added'], 201);
}


    public function update(Request $request, $id)  // update data
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'categoryId' => Rule::in([1,2]),
            'type' => Rule::in(['Magic','Start','Smart','Alpha']),
            'dollarPrice' => 'required|integer',
            'validity' => 'required|integer',
            'purchaseQuantity' => 'integer',
            'grace' => 'required|integer',
        ]);

      
        $example = PhoneCardsDetails::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => 'Item failed to update'], 404);
        }

        $example->name = $request->name ?? $example->name;
        $example->categoryId = $request->categoryId ?? $example->categoryId;
        $example->type = $request->type ?? $example->type;
        $example->dollarPrice = $request->dollarPrice ?? $example->dollarPrice;
        $example->validity = $request->validity ?? $example->validity;
        $example->purchaseQuantity = $request->purchaseQuantity ?? $example->purchaseQuantity;
        $example->grace = $request->grace ?? $example->grace;
        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully updated item'], 200);
    }

    public function destroy($id) // delete data
    {
        $example = PhoneCardsDetails::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => `Item can't be deleted`], 404);
        }

        $example->delete();

        return response()->json([
            'status' => true,
            'message' => 'Successfully deleted item'], 200);
    }

    public function destroyMultiple(Request $request){


        PhoneCardsDetails::destroy($request->ids);

        return response()->json([
            'status' => true,
            'message'=>"Items Deleted successfully."
        ],200);   
}

 
}
