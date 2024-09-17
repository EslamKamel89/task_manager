<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource {
	public static $wrap = null;

	public function toArray( Request $request ): array {

		return [
			'createrId' => $this->creater_id,
			'createrName' => $this->creator->name,
			'projectId' => $this->project_id,
			'projectTitle' => $this->project?->title,
			'title' => $this->title,
			'isDone' => $this->is_done,
		];


		// $data = parent::toArray( $request );
		// $data['status'] = $this->is_done ? 'finished' : 'open';
		// $data['creatorName'] = $this->creator->name;
		// return $data;
	}

}
