<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;


class AuthController extends Controller
{
    function index(){
        return view("login");
    }

    function login(Request $request){
        
        try{

            $user = User::where("email", $request->email)->where("role_id", 1)->first();
            if($user){

                if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
                    $url = redirect()->intended()->getTargetUrl();
                    return response()->json(["success" => true, "msg" => "User authenticated", "role_id" => Auth::user()->role_id, "url" => $url]);
                }else{
                    return response()->json(["success" => false, "msg" => "User not found"]);
                }

            }else{
                return response()->json(["success" => false, "msg" => "User not found"]);
            }

        }catch(\Exception $e){

            return response()->json(["success" => false, "err" => $e->getMessage(), "ln" => $e->getLine(), "msg" => "Something went wrong"]);
        }
    }

    function logout(){

        Auth::logout();
        return redirect()->to('/');

    }

}
