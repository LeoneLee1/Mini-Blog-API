<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::get('/', function (){
    return "Mini Blog API";
});

Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::get('/posts',[PostController::class,'posts'])->middleware('auth:sanctum');
Route::post('/posts/create',[PostController::class,'create'])->middleware('auth:sanctum');
Route::get('/posts/{id}',[PostController::class,'read'])->middleware('auth:sanctum');
Route::put('/posts/update/{id}',[PostController::class,'update'])->middleware('auth:sanctum');
Route::delete('/posts/delete/{id}',[PostController::class,'delete'])->middleware('auth:sanctum');
