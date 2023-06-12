<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/regUser',[UserController::class,'regUser']);
Route::post('/logUser',[UserController::class,'logUser']);
Route::get('/isLogged',[UserController::class,'isLogged']);
Route::post('/logout',[UserController::class,'logout']);
Route::get('/categories',[CategoryController::class,'getCategory']);
Route::post('/addCourse',[CourseController::class,'addCourse']);
Route::get('/getCourse',[CourseController::class,'getCourse']);
Route::post('/delete/{id}',[CourseController::class,'deleteCourse']);
Route::post('/update/{id}',[CourseController::class,'updateCourse']);


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
