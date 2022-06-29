<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{   
    public function register(Request $req){
        $user = User::where('email', $req->email)->first();
        if($user === null){
            $newuser = new User;
            $newuser->name = $req->name;
            $newuser->email = $req->email;
            $newuser->password = Hash::make($req->password);
            $newuser->created_at = now();
            $newuser->updated_at = now();
            $newuser->save();
            return 1;
        }
        else {
            return 0;
        }
    }

    public function login(Request $req)
    {
        if ($token = Auth::attempt(['email' => $req->email, 'password' => $req->password])){
            // return Auth::user()->createToken();
            return $this->respondWithToken($token);
            // return 1;
        }
        else return 0;
    }

    public function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function logout()
    {
        auth()->logout();
    }

    // public function getuser()
    // {
    //     // if(Auth::check()){
    //     //     return Auth::user()->name;
    //     // }
    //     // return NULL;
    //     if(Auth::check()) return Auth::user();
    //     else return 0;
    // }

    public function testapi(){
        // if(Auth::check()) return Auth::user();
        // else return 0;
        if(auth()->user() != NULL) return response()->json(auth()->user());
        else return 0;
    }
}
