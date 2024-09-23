<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller {
	use ApiResponse;
	public function index() {
		Gate::authorize( 'viewAny', );

		$tasks = QueryBuilder::for( Task::class)
			->allowedFilters( 'is_done' )
			->defaultSort( ( 'created_at' ) )
			->allowedSorts( [ 'title', 'is_done', 'created_at' ] )
			->paginate( 10 );
		return $this->success( new TaskCollection( $tasks ), pagination: true );
	}

	public function store( StoreTaskRequest $request ) {
		Gate::authorize( 'create', );
		$validated = $request->validated();
		$task = auth()->user()->tasks()->create( $validated );
		return new TaskResource( $task );
	}

	public function show( Task $task ) {
		Gate::authorize( 'view', $task );
		return $this->success( new TaskResource( $task ) );
	}

	public function update( UpdateTaskRequest $request, Task $task ) {
		Gate::authorize( 'update', $task );
		$validated = $request->validated();
		// dump( $validated, $request->all() );
		$task->update( $validated );
		return $this->success( new TaskResource( $task ) );
	}

	public function destroy( Task $task ) {
		Gate::authorize( 'delete', $task );
		$task->delete();
		return $this->success( [] );
	}
}
