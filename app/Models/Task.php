<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model {
	use HasFactory;
	protected $fillable = [
		'title',
		'is_done',
	];
	protected $casts = [
		'is_done' => 'boolean',
	];
	//! casts
	protected $hidden = [
		'updated_at',
		'created_at',
	];
	//! mutators
	public function isDone(): Attribute {
		return Attribute::make(
			get: fn( $value ) => $value,
			set: function ($value) {
				if ( $value == 'true' ) {
					return true;
				} elseif ( $value == 'false' ) {
					return false;
				} else {
					return $value;
				}
			},
		);
	}
}
