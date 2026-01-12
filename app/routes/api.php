<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonsController;
use App\Http\Middleware\CheckJsonRequest;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('persons', PersonsController::class)->middleware(CheckJsonRequest::class);
Route::post('persons', PersonsController::class)->middleware(CheckJsonRequest::class);
