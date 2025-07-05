<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AzureBlobController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AlumnoController::class, 'index']);

Route::get('alumnos',[AlumnoController::class,'index']);
Route::get('alumnos/{id}',[AlumnoController::class,'show']);
Route::post('alumnos',[AlumnoController::class,'store']);
Route::put('alumnos/{id}',[AlumnoController::class,'update']);
Route::delete('alumnos/{id}',[AlumnoController::class,'delete']);
Route::get('/test', fn() => response()->json(['status' => 'Laravel OK']));

