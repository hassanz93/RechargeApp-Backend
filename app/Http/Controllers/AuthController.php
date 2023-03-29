<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    
    public function __construct(){

        $this->middleware( 'auth:api', [ 'except' => ['login','register'] ]);
    }
    
    public function login( Request $request ){

        $request->validate([
            'phoneNumber' => 'required|digits:8',
            'password' => 'required|string',
        ]);

        $credentials = $request->only( 'phoneNumber', 'password' );

        $token = Auth::attempt( $credentials );
        
        if ( !$token ){
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized, try to login again',
            ], 401 );
        }
        
        $user = Auth::user();

        return response()->json([
            'status' => true,
            'message' => 'Login Successfully',
            'data' => json_encode([
                'user' => $user,
                    'authorisation' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ]
                ])
            ]); 
        }
        
        public function register( Request $request ){

            $request->validate([
                'mainResellerId' => 'required|integer',
                'name' => 'required|string|max:255',
                'email' => 'string|email|max:255|unique:users',
                'phoneNumber' => 'required|digits:8|unique:users',
                'password' => 'required|string|min:6',
                'role' => 'in:resellerB, manager, resellerA, SuperAdmin',
                'verified' => 'boolean',
                'lbpBalance' => 'integer',
                'usdBalance' => 'integer',
                'limitPurchaseLbp' => 'integer',
                'limitPurchaseUsd' => 'integer'
            ]);
            
            $user = User::create([
                'mainResellerId' => $request->mainResellerId,
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
                'message' => 'userCreated',
                'data' => json_encode([
                    'user' => $user,
                    'authorisation' => [
                        'token' => $token,
                        'type' => 'bearer',
                    ]
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
            
        public function refresh(){

            return response()->json([
                'status' => true,
                'user' => Auth::user(),
                    'data' => json_encode([
                        'authorisation' => [
                        'token' => Auth::refresh(),
                        'type' => 'bearer',
                    ]
                ])
            ]);
        }
}
            