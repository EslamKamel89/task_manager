<?php

namespace App\Policies;

use App\Models\User;
use App\Models\task;
use Illuminate\Auth\Access\Response;

class TaskPolicy {
	/**
	 * Determine whether the user can view any models.
	 */
	public function viewAny( User $user ): bool {

	}

	/**
	 * Determine whether the user can view the model.
	 */
	public function view( User $user, task $task ): bool {
		//
		if ( $user->id == $task->creator_id ) {
			return true;
		}
		// dump( 1 );
		// dump( $task, $task->project );
		return $task->project?->members?->contains( $user->id ) ?? false;
	}

	/**
	 * Determine whether the user can create models.
	 */
	public function create( User $user ): bool {
		return true;
	}

	/**
	 * Determine whether the user can update the model.
	 */
	public function update( User $user, task $task ): bool {
		return $task->creator_id == $user->id;
	}

	/**
	 * Determine whether the user can delete the model.
	 */
	public function delete( User $user, task $task ): bool {
		return $task->creator_id == $user->id;
	}

	/**
	 * Determine whether the user can restore the model.
	 */
	public function restore( User $user, task $task ): bool {
		//
		return $task->creator_id == $user->id;
	}

	/**
	 * Determine whether the user can permanently delete the model.
	 */
	public function forceDelete( User $user, task $task ): bool {
		//
		return $task->creator_id == $user->id;
	}
}
