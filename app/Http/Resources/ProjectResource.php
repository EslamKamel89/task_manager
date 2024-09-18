<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource {
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray( Request $request ): array {
		return [ 
			'title' => $this->title,
			'created_at' => $this->created_at,
			'creator' => new UserResource( $this->whenLoaded( 'creator' ) ),
			'tasks' => new TaskCollection( $this->whenLoaded( 'tasks' ) ),
			'members' => UserResource::collection( $this->whenLoaded( 'members' ) ),
		];
	}
}
