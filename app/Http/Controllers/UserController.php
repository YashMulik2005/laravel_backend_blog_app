<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index(){

    }

    public function register(Request $request){
        $validated = Validator::make($request->all(),[
            'name'=> "required",
            'email'=>"required|email",
            'password'=>"required|min:8",
        ]);

        if($validated->fails()){
            return response()->json([
                "status"=>401,
                "error"=>$validated->messages()
            ],401);
        }
        else{
            $userexist = User::where('name',$request->name)->first();
            if($userexist){
                return response()->json([
                    "status"=>409,
                    "error"=>"Username is not available"
                ],409);
            }
            else{

                $newuser = User::create([
                    "name"=> $request->name,
                    "email"=>$request->email,
                    "password"=>Hash::make($request->password),
                ]);

                if($newuser){
                    return response()->json([
                        "status"=>201,
                        "data"=>"User created"
                    ],201);
                }
                else{
                    return respone()->json([
                        "status"=>400,
                        "error"=>"Something went wrong."
                    ],400);
                }
            }
        }
    }

    public function login(Request $request){
        $validate = Validator::make($request->all(),[
            "name"=>"required",
            "password"=>"required"
        ]);

        if($validate->fails()){
            return response()->json([
                "status"=>409,
                "error"=>$validate->messages()
            ],409);
        }
        else{
            $existuser = User::where("name", $request->name)->first();
            if($existuser){
                if(!Hash::check($request->password,$existuser->password)){
                    echo $request->password;
                    return response()->json([
                        "status"=>400,
                        "error"=>"username or password is invalid."
                    ],400);
                }
                else{
                    return response()->json([
                        "status"=>200,
                        "data"=>"login sucessful..."
                    ],200);
                }
            }
            else{
                return response()->json([
                    "status"=>400,
                    "error"=>"username or password is invalid."
                ],400);
            }
        }
    }

    public function delete(Request $request){
        $existuser = User::where('name',$request->name)->first();

        if($existuser){
            $existuser->delete();
            return response()->json([
                "status"=>200,
                "data"=>"user deleted sucessfully"
            ],200);
        }
        else{
            return response()->json([
                "status"=>404,
                "error"=>"user not found."
            ],404);
        }
    }
}