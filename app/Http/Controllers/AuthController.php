<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    
    public function __construct(){

        $this->middleware( 'auth:api', [ 'except' => ['login','register'] ]);
    }
    
    public function login( Request $request ){

        $validator = Validator::make($request->all(), [
            'phoneNumber' => 'required|string',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('phoneNumber', 'password');

    
        $user = User::where('phoneNumber', $credentials['phoneNumber'])->first();
        $hashedPassword = $user->password;

        if (!$user) {
            return response()->json(['message' => 'Invalid phone number'], 401);
        }

        if (!Hash::check($credentials['password'], $hashedPassword)) {
            return response()->json(['message' => 'Invalid password'], 401);
        }


            $token = JWTAuth::fromUser($user, [
                'expires_in' => 60
            ]);

        $expires_in = (time() + 3600);

        return response()->json([
            'status' => true,
            'message' => 'Login Successfully',
            'data' => json_encode( [
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                    'expires_in' => $expires_in
            ]
            ])
        ], 200);
    }


        public function register( Request $request ){

            $validator = Validator::make($request->all(),[
                'mainResellerId' => 'required|integer',
                'name' => 'required|string|max:255',
                'email' =>'sometimes|required|email|max:155|unique:users' ,
                'phoneNumber' => 'required|string|size:8|unique:users',
                'password' => 'required|string|min:6',
                'role' => 'in:Reseller, Operator, Agent, SuperAdmin',
                'verified' => 'boolean',
                'lbpBalance' => 'integer',
                'usdBalance' => 'integer',
                'limitPurchaseLbp' => 'integer',
                'limitPurchaseUsd' => 'integer',
                'topUpUsd' =>'integer',
                'topUpLbp' => 'integer',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            
            $user = User::create([
                'mainResellerId' => $request->mainResellerId,
                'name' => $request->name,
                'email' => $request->email ?? '',
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

            return response()->json([
                'status' => true,
                'message' => 'User Created',
                'data' => json_encode([
                    'user' => $user,
            ])
        ]);
        }
            
        public function logout(){

            Auth::logout();

            return response()->json([
                'status' => true,
                'message' => 'Signed Out Successfully',
            ]);
        }
            
 
        public function password(Request $request){

            # Validation
            $validator = Validator::make($request->all(), [
                'oldPassword'=>'string|required',
                'newPassword'=>'string|required|confirmed',
            ]);


        #Match The Old Password
        if(!Hash::check($request->oldPassword, auth()->user()->password)){
            return response()->json([
                'status' => false,
                'message' => 'Old Password entered is incorrect',
            ]);
            }

        #Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->newPassword)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password updated',
        ]);
    }
}
            