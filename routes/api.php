<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get( '/user', function (Request $request) {
	return $request->user();
} )->middleware( 'auth:sanctum' );

Route::middleware( 'auth:sanctum' )->group( function () {
	Route::apiResource( '/tasks', TaskController::class);
} );

Route::prefix( 'auth' )->group( function () {
	Route::post( '/login', [ AuthController::class, 'login' ] )
		->name( 'login' );
	Route::post( '/register', [ AuthController::class, 'register' ] )
		->name( 'register' );
	Route::get( '/logout', [ AuthController::class, 'logout' ] )
		->name( 'logout' )
		->middleware( 'auth:Sanctum' );
} );

