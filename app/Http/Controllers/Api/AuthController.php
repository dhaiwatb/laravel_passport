<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use Laravel\Passport\Token;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        $token = $user->createToken('register token')->accessToken;
        
        return response()->json(['token' => $token], 201);
    }
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('login token')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    
    
    public function logout(Request $request){
        $user = $request->user(); 

        // Revoke all tokens associated with the user
        $user->tokens->each(function (Token $token) {
            $token->revoke();
            // $token->delete();
        });
        
        // return response()->json(['message' => 'Successfully logged out']);
        
        return $this->sendSuccessResponse('Successfully logged out');
    }
}
