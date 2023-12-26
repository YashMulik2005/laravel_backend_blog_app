<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            "name"=>"required",
            "email"=>"required|email",
            "order_placed"=>"required",
        ]);

        if($validator->fails()){
             return response()->json([
                "status"=>422,
                "erros"=>$validator->messages()
             ],422);
        }else{

            $newcustomer = Customer::create([
                "name"=> $request->name,
                "email"=> $request->email,
                "order_placed" => $request->order_placed,
            ]);

            if($newcustomer){
                return response()->json(['data'=>'cretated'],200); 
            }
            else{
                return response()->json(["err"=>"somting went wrong"],400);
            }
        }
        
    }

    public function index(){
        $customer = Customer::all();
        // $data = compact('customer');

        return response()->json(["status"=>200,"data"=>$customer],200);
    }
}