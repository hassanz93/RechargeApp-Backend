<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
 
    public function index()  // show all
    {
        return User::all();
    }

 
    public function store(Request $request)  // save data
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'age' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $example = new ExampleModel;
        $example->name = $request->name;
        $example->age = $request->age;
        $example->save();

        return response()->json(['message' => 'Successfully created example.'], 201);
    }


    public function show($id) // save one data
    {
        $example = User::find($id);

        if (!$example) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        return $example;
    }

 
    public function update(Request $request, $id)  // update data
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users',
            'phoneNumber' => 'digits:8|unique:users',
            'role' => 'in:Super admin, manager, resellerA, resellerB',
            'verified' => 'boolean',
            'lbpBalance' => 'integer',
            'usdBalance' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $example = User::find($id);

        if (!$example) {
            return response()->json(['error' => 'User not found.'], 404);
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

        return response()->json(['message' => 'Successfully updated user.'], 200);
    }


    public function destroy($id) // delete data
    {
        $example = User::find($id);

        if (!$example) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $example->delete();

        return response()->json(['message' => 'Successfully deleted user.'], 200);
    }
    }
