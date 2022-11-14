<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\DepartureController;

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


Route::post('login', [UserController::class, 'login'])->middleware('api');

Route::get('users',[UserController::class, 'index'])->middleware('api');
Route::post('register',[UserController::class, 'store'])->middleware('api');
Route::get('user/{id}',[UserController::class, 'show'])->middleware('api');
Route::put('user/{id}',[UserController::class, 'update'])->middleware('api');
Route::delete('user/{id}',[UserController::class, 'destroy'])->middleware('api');
Route::post('logout', [UserController::class, 'logout'])->middleware('api');
Route::post('sendmail', [UserController::class, 'mail'])->middleware('api');


Route::post('arrival/register/{id}',[ArrivalController::class, 'store'])->middleware('api');
Route::get('arrivals',[ArrivalController::class, 'index'])->middleware('api');

Route::post('departure/register/{id}',[DepartureController::class, 'store'])->middleware('api');
Route::get('departures',[DepartureController::class, 'index'])->middleware('api');

Route::get('flights',[FlightController::class, 'index'])->middleware('api');
Route::get('cities',[CityController::class, 'index'])->middleware('api');

