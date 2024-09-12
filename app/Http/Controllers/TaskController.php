<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller {
	public function index() {

		$tasks = QueryBuilder::for( Task::class)
			->allowedFilters( 'is_done' )
			->paginate( 10 );
		return new TaskCollection( $tasks );
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
		$validated = $request->validated();
		// dump( $validated, $request->all() );
		$task->update( $validated );
		return new TaskResource( $task );
	}

	public function destroy( Task $task ) {
		$task->delete();
		return response()->noContent();
	}
}
