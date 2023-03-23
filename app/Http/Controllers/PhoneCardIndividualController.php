<?php

namespace App\Http\Controllers;

use App\Models\PhoneCardIndividual;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PhoneCardIndividualController extends Controller
{
    public function index()  // show all
    {
        $cardDetail = PhoneCardIndividual::all();
        $cardDetail ->makeHidden(['code']);
        return response()->json([
            'status' => true,
            'data' => $cardDetail], 201);
    }

    public function store(Request $request)  // save data
    {
        $validator = Validator::make($request->all(), [
            'serial' => 'required|integer',
            'cardDetailsId' => 'required|integer',
            'code' => 'required|integer|digits:14',
            'expiryDate' => 'required|date',
            'status' => Rule::in(['Available','Expired','Sold'])
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator-> errors()->first()
          ], 400);
        }

        $example = new PhoneCardIndividual;
        $example->serial = $request->serial;
        $example->cardDetailsId = $request->cardDetailsId;
        $example->code = $request->code;
        $example->expiryDate =$request->expiryDate;
        $example->status=$request->status;
        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully add card'], 201);
    }

    public function addCsv(Request $request)
{

    $validator = Validator::make($request->all(), [
        'serial' => 'integer',
        'cardDetailsId' => 'integer',
        'code' => 'integer|digits:14',
        'expiryDate' => 'string',
        'status' => Rule::in(['Available','Expired','Sold'])
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator-> errors()->first()], 400);
    }

    $cards = $request->json()->all();
    
    foreach ($cards as $card) {
        PhoneCardIndividual::create($card);
    }

    return response()->json([
        'status' => true,
        'message' => 'All Cards have been added'], 201);
}

public function purchaseStatus(Request $request, $id){

  $validator = Validator::make($request->all(), [
        'status' => Rule::in(['Sold'])
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator-> errors()->first()], 400);
    }

     $example = PhoneCardIndividual::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => 'Card not purchased'], 404);
        }

        $example->status=$request->status;
        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully purchased card'], 200);
}


    public function update(Request $request, $id)  // update data
    {
        $validator = Validator::make($request->all(), [
            'serial' => 'required|integer',
            'cardDetailsId' => 'required|integer',
            'expiryDate' => 'required|date',
            'status' => Rule::in(['Available','Expired','Sold'])
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator-> errors()->first()], 400);
        }

        $example = PhoneCardIndividual::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => 'Card failed to update'], 404);
        }

        $example->serial = $request->serial;
        $example->cardDetailsId = $request->cardDetailsId;
        $example->expiryDate =$request->expiryDate;
        $example->status=$request->status;
        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully updated card'], 200);
    }

    public function destroy($id) // delete data
    {
        $example = PhoneCardIndividual::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => `Card can't be deleted`], 404);
        }

        $example->delete();

        return response()->json([
            'status' => true,
            'message' => 'Successfully deleted item'], 200);
    }


    public function destroyMultiple(Request $request){

        PhoneCardIndividual::destroy($request->ids);

        return response()->json([
            'status' => true,
            'message'=>"Items Deleted successfully."
        ],200);   
    }

        public function purchase( $id, $quantity) {

            $example = PhoneCardIndividual::where('status', 'Available')
        ->where('cardDetailsId', $id) 
        ->orderBy('expiryDate') // assuming you want to order by expiryDate
        ->select(['id', 'serial', 'code', 'cardDetailsId', 'expiryDate' ])
        ->take($quantity) // assuming you want to return only 5 records per ID
        ->get();

  
    return response()->json([
        'status' => true,
        'data' =>  $example], 200);

    }
}