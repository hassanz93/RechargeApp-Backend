<?php

namespace App\Http\Controllers;

use App\Models\PhoneCardsDetails;
use App\Models\PhoneCardIndividual;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class PhoneCardsDetailsController extends Controller
{
   

    public function index()  // show all
    {
        $phoneDetails = PhoneCardsDetails::all();

        return response()->json([
            'status' => true,
            'data' => $phoneDetails], 201);
    }

    public function getstock()
    {
        $indivDetailsCount = PhoneCardIndividual::all()->count();
        $indivDetails = PhoneCardIndividual::all()->makeHidden(['code', 'userSoldId', 'transactionId']);
        $indivDetails1 = [];
        for($id = 1;$id <= $indivDetailsCount;$id++){
            $indivDetails1[$id-1] = collect($indivDetails)->where('status', 'Available')->where('cardDetailsId', $id)->where('expiryDate', '>' , date('Y-m-d'));
        }

        return response()->json([
            'status' => true,
            'data' => $indivDetails1], 201);
    }

    public function store(Request $request)  // save data
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'categoryId' => Rule::in([1,2]),
            'type' => Rule::in(['Magic','Start','Smart','Alfa']),
            'dollarPrice' => 'required|numeric',
            'validity' => 'required|integer',
            'grace' => 'required|integer',
            'show' => Rule::in(['Enable','Disable']),
            'lowQuantity' => 'required|integer',
            'imageUrl' => 'required|string|max:350',
            'currencySoldIn' => Rule::in(['Dollar','Lira']),
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
        $example->grace = $request->grace;
        $example->show = $request->show;
        $example->lowQuantity = $request->lowQuantity;
        $example->imageUrl = $request->imageUrl;
        $example->currencySoldIn = $request->currencySoldIn;
        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully created item'], 201);
    }

    public function update(Request $request, $id)  // update data
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'categoryId' => Rule::in([1,2]),
            'type' => Rule::in(['Magic','Start','Smart','Alfa']),
            'dollarPrice' => 'numeric',
            'validity' => 'integer',
            'grace' => 'integer',
            'show' => Rule::in(['Enable','Disable']),
            'lowQuantity' => 'integer',
            'imageUrl' => 'string|max:350',
            'currencySoldIn' => Rule::in(['Dollar','Lira']),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()], 400);
        }

      
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
        $example->grace = $request->grace ?? $example->grace;
        $example->show = $request->show ?? $example->show;
        $example->lowQuantity = $request->lowQuantity ?? $example->lowQuantity;
        $example->imageUrl = $request->imageUrl ?? $example->imageUrl;
        $example->currencySoldIn = $request->currencySoldIn ?? $example->currencySoldIn;
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
