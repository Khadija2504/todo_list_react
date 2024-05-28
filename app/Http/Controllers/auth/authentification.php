<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class authentification extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:22',
            'prenom' => 'required|string|max:22',
            'email' => 'required|unique:users|string',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'password' =>  hash::make($request->password),
        ]);
        return response()->json([
            'seccess' => true,
            'msg' => 'User created successfully',
            'user infos' => $user,
        ]);
    }
    public function login (Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required|min:5|string',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        if(!$token = auth()->attempt($validator->validated())){
            return response()->json([
                'seccess'=>false,
                'msg' => 'Wrong email or password'
            ]);
        }
        return $this->responseWithToken($token);
    }
    protected function responseWithToken($token){
        return response()->json([
            'seccess' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_at' => auth()->factory()->getTTL() * 60,
        ]);
    }
    public function logout(){
        try {
            auth()->logout();
            return response()->json(['seccess' => true, 'msg' => 'User logged out successfully']);
        } catch (\Exception $e) {
            return response()->json(['seccess' => false, 'msg' => $e->getMessage()]);
        }
    }
}
