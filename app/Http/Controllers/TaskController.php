<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller {
	public function index() {
		// return response()->json( Task::all() );
		return new TaskCollection( Task::all() );
	}

	public function store( StoreTaskRequest $request ) {
		$validated = $request->validated();
		$task = Task::create( $validated );
		return new TaskResource( $task );
	}

	public function show( Task $task ) {
		return new TaskResource( $task );
	}

	public function update( UpdateTaskRequest $request, Task $task ) {
		//
	}

	public function destroy( string $id ) {
		//
	}
}
