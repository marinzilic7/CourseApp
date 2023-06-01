<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/regUser',[UserController::class,'regUser']);
Route::post('/logUser',[UserController::class,'logUser']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
