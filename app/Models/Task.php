<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Task extends Model {
	use HasFactory;
	protected $fillable = [ 
		'creater_id',
		'title',
		'is_done',
	];
	//! casts
	protected $casts = [ 
		'is_done' => 'boolean',
	];
	protected $hidden = [ 
		'updated_at',
		'created_at',
	];
	//! mutators
	public function isDone(): Attribute {
		return Attribute::make(
			get: fn( $value ) => $value == 0 ? false : true,
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

	//! Relationships
	public function creator(): BelongsTo {
		return $this->belongsTo( User::class, 'creater_id', );
	}

	protected static function booted(): void {
		//! Global Scopes
		static::addGlobalScope(
			'creator',
			function (Builder $query) {
				$query->where( 'creater_id', '=', auth()->id() );
			}
		);
	}
}
