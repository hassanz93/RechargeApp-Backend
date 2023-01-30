<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
 
    public function index()  // show all
    {
        $user = User::all();

        return response()->json([
            'status' => true,
            'data' => $user], 201);
    }

 
    public function store(Request $request)  // save data
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'phoneNumber' => 'required|digits:8|unique:users',
            'password' => 'required|string|min:6',
            'role' => Rule::in(['resellerA', 'manager', 'resellerB']),
            'verified' => 'boolean',
            'lbpBalance' => 'integer',
            'usdBalance' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()], 400);
        }

        $example = new User;
        $example->name = $request->name;
        $example->email = $request->email;
        $example->phoneNumber = $request->phoneNumber;
        $example->password = Hash::make($request->password);
        $example->role = $request->role;
        $example->verified = $request->verified;
        $example->email = $request->email;
        $example->lbpBalance = $request->lbpBalance;
        $example->usdBalance = $request->usdBalance;
        $example->save();

        return response()->json([
            'status' => true,
            'message' => 'Successfully created user'], 201);
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
            'data' => $example ], 404);
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
    }
