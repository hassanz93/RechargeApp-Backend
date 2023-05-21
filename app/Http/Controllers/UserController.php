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
            'data' => $user], 200);
    }

    public function store(Request $request)  // save data
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'phoneNumber' => 'required|string|size:8|unique:users',
            'password' => 'required|string|min:6',
            'role' => Rule::in(['Agent','Operator','Reseller']),
            'verified' => 'required|integer',
            'lbpBalance' => 'integer',
            'usdBalance' => 'integer',
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
            'role' => $request->role ?? 'Reseller',
            'verified' => $request->verified ?? 0,
            'lbpBalance' => $request->lbpBalance ?? 0,
            'usdBalance' => $request->usdBalance ?? 0,
            'limitPurchaseLbp' => $request->limitPurchaseLbp ?? 0,
            'limitPurchaseUsd' => $request->limitPurchaseUsd ?? 0,
            'topUpUsd' => $request->topUpUsd ?? 0,
            'topUpLbp' => $request->topUpLbp ?? 0,
        ]);

   
        $token = Auth::login( $user );

        return response()->json([
            'status' => true,
            'message' => 'Successfully created user'], 200);
    }

    public function show($id) // save one data
    {
        $example = User::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'User found',
            'data' => $example ], 200);
    }

 
    public function update(Request $request, $id)  // update data
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'phoneNumber' => 'string|size:8|unique:users',
            'password' => 'string|min:6',
            'role' => Rule::in(['Agent','Operator','Reseller']),
            'verified' => 'integer',
            'lbpBalance' => 'integer',
            'usdBalance' => 'integer',
        ]);

      
        $example = User::find($id);

        if (!$example) {
            return response()->json([
                'status' => false,
                'message' => 'User failed to update'], 400);
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
        $example->topUpUsd = $request->topUpUsd ?? $example->topUpUsd;
        $example->topUpLbp = $request->topUpLbp ?? $example->topUpLbp;

        if ($request->password !== null && $request->password !== '' ) {
            $example->password = Hash::make($request->password);
        }

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
                'message' => `User can't be deleted`], 400);
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

    public function adminTransferBalance(Request $request, $id){
        
        $example = User::find($id);

        $example->topUpUsd = $request->topUpUsd + $example->topUpUsd ?? $example->topUpUsd;
        $example->topUpLbp = $request->topUpLbp + $example->topUpLbp ?? $example->topUpLbp;

        $example->save();

   

        return response()->json([
            'message'=>"Credit has been transfered to agent",
            'status' => true
        ],200); 

}

    public function agentTransferBalance(Request $request, $id){
        
        $user = Auth::user();
        $example = User::find($id);

        if ($request->usdBalance <= $user->topUpUsd && $request->lbpBalance <= $user->topUpLbp  ){
        $user->topUpUsd = $user->topUpUsd - $request->usdBalance;
        $user->topUpLbp = $user->topUpLbp - $request->lbpBalance;

        $example->usdBalance = $request->usdBalance + $example->usdBalance ?? $example->usdBalance;
        $example->lbpBalance = $request->lbpBalance + $example->lbpBalance ?? $example->lbpBalance;

        $user->save();
        $example->save();

        return response()->json([
            'message'=>"Credit has been transfered to reseller",
            'status' => true
        ],200); 

        }

        else {
            return response()->json([
                'message'=>"Not enough Usd/Lbp balance to transfer to reseller",
                'status' => false
            ],200); 
        }

}

}
