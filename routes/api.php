<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\TagController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [UserController::class, 'signin']);


Route::middleware('auth:sanctum')->group( function () {
    //users route
    Route::resource('users',UserController::class);
    Route::get('logout',[UserController::class,'logout']);
    
    //Articles route 
    Route::resource('articles',ArticleController::class);
    //Tags route 
    Route::resource('tags',TagController::class);

    //roles route
    Route::resource('roles',RoleController::class);
    Route::put('users/{id}/role',[RoleController::class,'assignRole']);

    //permissions route
    Route::resource('permissions',PermissionController::class);
});
