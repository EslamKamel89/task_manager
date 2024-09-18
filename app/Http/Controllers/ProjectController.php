<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller {

	use ApiResponse;



	public function index() {
		Gate::authorize( 'viewAny', Project::class);
		$projects = QueryBuilder::for( Project::class)
			->allowedIncludes( [ 'tasks', 'creator', 'members' ] )
			->allowedFilters( [] )
			->defaultSort( '-created_at' )
			->allowedSorts( [ 'created_at', 'title', 'creator_id' ] )
			->paginate( 10 );
		return $this->success(
			new ProjectCollection( $projects ),
			pagination: true );
	}

	public function store( StoreProjectRequest $request ) {
		Gate::authorize( 'create', Project::class);
		$validated = $request->validated();
		$project = auth()->user()->projects()->create( $validated );
		return $this->success( new ProjectResource( $project ) );
	}

	public function show( Project $project ) {
		Gate::authorize( 'view', $project );
		return $this->success( new ProjectResource( ( $project->load( [ 'tasks', 'members', 'creator' ] ) ) ) );
	}

	public function update( UpdateProjectRequest $request, Project $project ) {
		Gate::authorize( 'update', $project );
		$validated = $request->validated();
		$project->update( $validated );
		return $this->success( new ProjectResource( $project ) );
	}

	public function destroy( Project $project ) {
		Gate::authorize( 'delete', $project );
		$project->delete();
		return $this->success( [] );
	}
}
