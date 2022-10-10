<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("property/list", [\App\Http\Controllers\PropertyController::class, 'index']);
Route::get("property/type/list", [\App\Http\Controllers\PropertyController::class, 'propTypeList']);
Route::get("property/find/{search}", [\App\Http\Controllers\PropertyController::class, 'search']);
Route::get("property/get/{uuid}", [\App\Http\Controllers\PropertyController::class, 'show']);
Route::post("property/create", [\App\Http\Controllers\PropertyController::class, 'create']);
Route::post("property/update/{uuid}", [\App\Http\Controllers\PropertyController::class, 'update']);
Route::delete("property/delete/{uuid}", [\App\Http\Controllers\PropertyController::class, 'destroy']);
