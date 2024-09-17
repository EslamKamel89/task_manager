<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get( '/', function () {
	return view( 'welcome' );
} );
Route::get( '/test', function () {
	// $tasks = Task::withoutGlobalScope( 'creator' )->get();
	// // dd( $tasks );
	// foreach ( $tasks as $task ) {

	// 	$task->update( [ 'project_id' => fake()->numberBetween( 1, 4 ) ] );
	// }
	$user = User::find( 2 );
	$user->memeberProjects()->attach( 1 );
	return redirect( '/' );
} );
