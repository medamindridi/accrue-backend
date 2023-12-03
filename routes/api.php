<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

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

Route::post("/xp/add",[userController::class,"addXp"])->name("addxp");
Route::post("/user/add",[userController::class,"adduser"])->name("adduser");
Route::post("/achievement/add",[userController::class,"addachievement"])->name("addachievement");
Route::post("/stat/add",[userController::class,"addstat"])->name("addstat");
Route::get("/users",[userController::class,"getUsers"])->name("getUsers");
Route::get('/user/{id}',[userController::class,"getUser"])->name("getUser");
Route::get('/user/xp/{id}',[userController::class,"getUserXp"])->name("getUserXp");
Route::get("/departments",[userController::class,"departements"])->name("departements");
