<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller {
	use ApiResponse;
	public function index() {
		$projects = QueryBuilder::for( Project::class)
			->allowedIncludes( [ 'tasks', 'creator' ] )
			->allowedFilters( [] )
			->defaultSort( '-created_at' )
			->allowedSorts( [ 'created_at', 'title', 'creator_id' ] )
			->paginate( 10 );
		return $this->success(
			new ProjectCollection( $projects ),
			pagination: true );
	}

	public function store( StoreProjectRequest $request ) {
		$validated = $request->validated();
		$project = auth()->user()->projects()->create( $validated );
		return $this->success( new ProjectResource( $project ) );
	}

	public function show( Project $project ) {
		return $this->success( new ProjectResource( ( $project->load( 'tasks' ) ) ) );
	}

	public function update( UpdateProjectRequest $request, Project $project ) {
		$validated = $request->validated();
		$project->update( $validated );
		return $this->success( new ProjectResource( $project ) );
	}

	public function destroy( Project $project ) {
		$project->delete();
		return $this->success( [] );
	}
}
