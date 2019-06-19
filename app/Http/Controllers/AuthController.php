<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;


class AuthController extends Controller
{

    public function register(Request $req){
        $user=User::create([
            'name'=>$req->name,
            'email'=>$req->email,
            'password'=>app('hash')->make($req->password),
            'api_token'=>self::random_string()
        ]);
        return response()->json(['status'=>'success','user'=>$user,'msg'=>'user registered successfully'],200);
    }

    public function login(Request $req){
        $user=User::where('email',$req->email)->first();
        if(!$user){
            return response()->json(['status'=>'error','msg'=>'User not found'],400);
        }
        if(Hash::check($req->password,$user->password)){
            $user->update(['api_token'=>self::random_string()]);
            $user->save();
            return response()->json(['status'=>'success','user'=>$user,'msg'=>'you are login successfully'],200);
        }else{
            return response()->json(['status'=>'error','msg'=>'invalid credinential'],401);
        }
    }

    public function logout(Request $req){
        $api_token=$req->api_token;
        $user=User::where('api_token',$api_token)->first();
        if(!$user){
            return response()->json(['status'=>'error','msg'=>'user not logen in'],401);
        }
        $user->api_token=null;
        $user->save();
        return response()->json(['status'=>'success','msg'=>'user logged out successfully'],200);
    }

    //generate random string
    public static function random_string($length=50){
        $string='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        if($length>60) {
            $length=60;
        }
        $result = substr(str_shuffle($string), 0, $length);

        return $result;
    }

}
