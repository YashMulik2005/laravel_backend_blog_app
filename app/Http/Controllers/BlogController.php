<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function create(Request $request){
        $validate = Validator::make($request->all(),[
            'title'=>'required',
            'description' => 'required'
        ]);

        if($validate->fails()){
            return response()->json([
                "status"=>409,
                "error"=>$validate->messages()
            ],409);
        }
        else{
            $blog = Blog::create([
                "title"=>$request->title,
                "description"=> $request->description,
            ]);
            if($blog){
                return response()->json([
                    "status"=>201,
                    "data"=>"blog created sucessfully."
                ],201);
            }else{
                return response()->json([
                    "status"=>400,
                    "data"=>"Something went wrong try again."
                ],400);
            }
        }
    }

    public function getall(){
        $blogs = Blog::all();

        return response()->json([
            "status"=>200,
            "data"=> $blogs,
        ],200);
    }

    public function getone($blog_id){
        $blog = Blog::where("blog_id", $blog_id)->get();
        if($blog){
            return response()->json([
                "status"=>200,
                "data"=>$blog,
            ],200);
        }else{
            return response()->json([
                "status"=>404,
                "data"=>"Blog not found",
            ],404);
        }
    }

    public function delete(Request $request){
        $validate = Validator::make($request->all(),[
            'id'=> "required"
        ]);

        if(!$validate->fails()){
            $blog = Blog::where('blog_id', $request->id);

            if($blog){
                $blog->delete();
                return response()->json([
                    "status"=>200,
                    "data"=>"deleted sucessfully."
                ],200);
            }else{
                return response()->json([
                    "status"=>404,
                    "data"=>"Blog not found."
                ],404);
            }
        }
    }

    public function Update(Request $request){
        $validate = Validator::make($request->all(),[
            "id"=>"required",
            "title"=>"required",
            "description"=> "required"
        ]);

        if(!$validate->fails()){
            $blog = Blog::where("blog_id", $request->id)->Update([
                'title'=>$request->title,
                'description'=> $request->description
            ]);
                if($blog){
                    return response()->json([
                        "status"=>200,
                        "data"=>"Updated Sucessfully."
                    ],200);
                }else{
                    return response()->json([
                        "status"=>404,
                        "data"=>"Blog not found."
                    ],404);
                }
            }
        else{
            return response()->json([
                "status"=>409,
                "data"=> $validate->messages()
            ],409);
         }
    }
}