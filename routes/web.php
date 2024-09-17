<?php

use App\Models\Task;
use Illuminate\Support\Facades\Route;

Route::get( '/', function () {
	return view( 'welcome' );
} );
Route::get( '/test', function () {
	$tasks = Task::withoutGlobalScope( 'creator' )->get();
	// dd( $tasks );
	foreach ( $tasks as $task ) {

		$task->update( [ 'project_id' => fake()->numberBetween( 1, 3 ) ] );
	}
	return redirect( '/' );
} );
