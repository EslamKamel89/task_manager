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
			'creatorName' => $this->creator->name,
			'created_at' => $this->created_at,
			'tasks' => new TaskCollection( $this->whenLoaded( 'tasks' ) ),
		];
	}
}
