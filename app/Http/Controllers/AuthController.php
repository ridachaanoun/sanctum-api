<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
class AuthController extends Controller
{
    public function register(request $request){
        try {
            $validator = validator::make($request->all(),[
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]
        
            );

            if ($validator->fails()) {
                return response()->json(["message "=>"ff","error"=>$validator->errors()],401);
            }

            $user = user::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => hash::make($request->password)
            ]);


            
            return response()->json(["message "=>"user succesfully regitered"],201);

            
        } catch (Exception $e) {
            return response()->json(["msg"=>"error","error"=>$e->getMessage()],500);
        }

    }

    public function login(request $request){
        try {
            $validator = validator::make($request->all(),[
                'email' => 'required|string|email|max:255',
                'password' => 'required|string|min:8',
            ]

            );

            if ($validator->fails()) {
                return response()->json(["message "=>"ff","error"=>$validator->errors()],401);
            }

            $user = user::where("email",$request->email)->first();

            if (!$user || !hash::check($request->password,$user->password)) {
            return response()->json(["message "=>"email or pass is incerct"],401);
                
            }

            $token = $user->createToken("rida",["*"],now()->addMinutes(1))->plainTextToken;
            
            return response()->json(["message "=>"user succesfully login", "token"=>$token],200);

            
        } catch (Exception $e) {
            return response()->json(["msg"=>"error","error"=>$e->getMessage()],500);
        }

    }

    public function logout(request $request){
        try {
            // $request->user()->currentAccessToken()->delete(); delete all tokens

            $request->user()->currentAccessToken()->delete(); //delete just current token you sand in header
            
            return response()->json(["message "=>"user succesfully loged out "],200);

            
        } catch (Exception $e) {
            return response()->json(["msg"=>"error","error"=>$e->getMessage()],500);
        }

    }

}
