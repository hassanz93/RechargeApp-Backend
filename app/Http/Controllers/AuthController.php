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

         $credentials = $request->validate([
           'phoneNumber' => 'required|string',
            'password' => 'required|string'
    ]);

        if (!Auth::attempt($credentials)) {
        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    $user = Auth::user();
    $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => true,
            'message' => 'Login Successfully',
            'data' => json_encode( [
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
            ]
            ])
        ], 200);
    }


        public function register( Request $request ){

            $validator = Validator::make($request->all(),[
                'name' => 'required|string|max:255',
                'email' =>'sometimes|required|email|max:155|unique:users' ,
                'phoneNumber' => 'required|string|size:8|unique:users',
                'password' => 'required|string|min:6',
                'role' => 'in:Reseller, Operator, Agent, SuperAdmin',
                'verified' => 'integer',
                'lbpBalance' => 'integer',
                'usdBalance' => 'integer',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            }
            
            $user = User::create([
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

             // Revoke the token but keep it valid until it expires
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
            