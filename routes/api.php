<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\WebhookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/


Route::get('users',[UserController::class,'index']);
Route::post('users',[UserController::class,'store']);


Route::post('/webhook/stripe', [WebhookController::class, 'handle']);
