<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/customers", [CustomerController::class, 'index']);
Route::post("/add", [CustomerController::class, 'store']);
Route::post("/register", [UserController::class, 'register']);
Route::post("/login",[UserController::class, 'login']);
Route::post("/delete", [UserController::class, 'delete']);

Route::post("/create", [BlogController::class, 'create']);
Route::get('/posts',[BlogController::class , 'getall']);
Route::get("/post/{blog_id}", [BlogController::class , 'getone']);
Route::post("/blog/delete", [BlogController::class , 'delete']);
Route::post("/update", [BlogController::class , 'Update']);