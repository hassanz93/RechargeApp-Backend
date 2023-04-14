<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Console\Scheduling\Schedule;

class UserController extends Controller
{
 
    public function index()  // show all
    {
        $user = User::whereNotIn('role', ['SuperAdmin'])->get();

        return response()->json([
            'status' => true,
            'data' => $user], 201);
    }

    public function getUserPhoneNumber($phoneNumber)
    {
        $resellerA = User::where('role', 'resellerA')->where('phoneNumber', $phoneNumber)->select(['id', 'name' ])->first();

        if ( $resellerA){
        return response()->json([
            'status' => true,
            'data' => $resellerA,
            'message' => 'ResellerA Exists'], 201);
        }
        else {
            return response()->json([
                'status' => false,
                'message' => 'ResellerA does not exist'], 201);
            }
    }

    public function store(Request $request)  // save data
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'phoneNumber' => 'required|digits:8|unique:users',
            'password' => 'required|string|min:6',
            'role' => Rule::in(['resellerA', 'manager', 'resellerB']),
            'verified' => 'required|boolean',
            'lbpBalance' => 'required|integer',
            'usdBalance' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phoneNumber' => $request->phoneNumber,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'resellerB',
            'verified' => $request->verified ?? 0,
            'lbpBalance' => $request->lbpBalance ?? 100000,
            'usdBalance' => $request->usdBalance ?? 10,
            'limitPurchaseLbp' => $request->limitPurchaseLbp ?? 5000000,
            'limitPurchaseUsd' => $request->limitPurchaseUsd ?? 100,
        ]);

   
        $token = Auth::login( $user );

        return response()->json([
            'status' => true,
            'message' => 'Successfully created user'], 201);
    }

    public function addCsv(Request $request)
{

    $validator = Validator::make($request->all(), [
        'name' => 'string|max:255',
        'email' => 'string|email|max:255|unique:users',
        'phoneNumber' => 'digits:8|unique:users',
        'password' => 'string|min:6',
        'role' => Rule::in(['resellerA', 'manager', 'resellerB']),
        'verified' => 'boolean',
        'lbpBalance' => 'integer',
        'usdBalance' => 'integer',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->first()], 400);
    }

    $users = $request->json()->all();
    
    foreach ($users as $user) {
        User::create($user);
    }

    return response()->json([
        'status' => true,
        'message' => 'All Users have been added'], 201);
}


    public function show($id) // save one data
    {
        $example = User::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'User found',
            'data' => $example ], 201);
    }

 
    public function update(Request $request, $id)  // update data
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'phoneNumber' => 'digits:8|unique:users',
            'role' => Rule::in(['resellerA', 'manager', 'resellerB']),
            'verified' => 'boolean',
            'lbpBalance' => 'integer',
            'usdBalance' => 'integer',
        ]);

      
        $example = User::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => 'User failed to update'], 404);
        }
        
        $example->name = $request->name ?? $example->name;
        $example->email = $request->email ?? $example->email;
        $example->phoneNumber = $request->phoneNumber ?? $example->phoneNumber;
        $example->role = $request->role ?? $example->role;
        $example->verified = $request->verified ?? $example->verified;
        $example->email = $request->email ?? $example->email;
        $example->lbpBalance = $request->lbpBalance ?? $example->lbpBalance;
        $example->usdBalance = $request->usdBalance ?? $example->usdBalance;
        $example->limitPurchaseLbp = $request->limitPurchaseLbp ?? $example->limitPurchaseLbp;
        $example->limitPurchaseUsd = $request->limitPurchaseUsd ?? $example->limitPurchaseUsd;
        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully updated user'], 200);
    }

    public function destroy($id) // delete data
    {
        $example = User::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => `User can't be deleted`], 404);
        }

        $example->delete();

        return response()->json([
            'status' => true,
            'message' => 'Successfully deleted user'], 200);
    }

    public function destroyMultiple(Request $request){


        User::destroy($request->ids);

            return response()->json([
                'message'=>"Users Deleted successfully."
            ],200);   
    }

    public function setLimitLBP(Request $request){
        $setLimitPurchaseLbp = $request->input('setLimitLbp') ;
        User::query()->update(['limitPurchaseLbp' => $setLimitPurchaseLbp]);

        return response()->json([
            'message'=>"New Lbp limit of $setLimitPurchaseLbp has been set.",
            'status' => true
        ],200);   
    }

    public function setLimitUSD(Request $request){
        $setLimitPurchaseUsd = $request->input('setLimitUsd') ;
        User::query()->update(['limitPurchaseUsd' => $setLimitPurchaseUsd]);

        return response()->json([
            'message'=>"New Usd limit of $setLimitPurchaseUsd has been set.",
            'status' => true
        ],200);   
    }

    public function resellerATransferBalance(Request $request, $id){
        
        $user = Auth::user();
        $example = User::find($id);

        if ($request->usdBalance <= $user->usdBalance && $request->lbpBalance <= $user->lbpBalance  ){
        $user->usdBalance = $user->usdBalance - $request->usdBalance;
        $user->lbpBalance = $user->lbpBalance - $request->lbpBalance;

        $example->usdBalance = $request->usdBalance + $example->usdBalance  ?? $example->usdBalance;
        $example->lbpBalance = $request->lbpBalance + $example->lbpBalance  ?? $example->lbpBalance;

        $user->save();
        $example->save();

        return response()->json([
            'message'=>"Credit has been transfered",
            'status' => true
        ],200); 

        }

        else {
            return response()->json([
                'message'=>"Not enough Usd/Lbp balance to transfer",
                'status' => false
            ],200); 
        }

    
}

}
