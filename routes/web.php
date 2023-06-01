<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/regUser',[UserController::class,'regUser']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
