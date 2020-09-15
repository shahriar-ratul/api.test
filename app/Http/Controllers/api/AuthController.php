<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Logininfo;
use App\Http\Requests\Registerinfo;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Logininfo $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $accessToken = auth()->user()->createToken('authtoken')->accessToken;
            return response()->json([ 'user' =>  new UserResource(auth()->user()),'access_token' => $accessToken], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    public function register(Registerinfo $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response()->json(['access_token' => $accessToken], 200);
    }

    public function logout(){
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return response()->json(['success' =>'logout_success'],200);
        }else{
            return response()->json(['error' =>'api.something_went_wrong'], 500);
        }
    }

}
