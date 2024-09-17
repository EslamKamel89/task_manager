<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model {
	use HasFactory;
	protected $fillable = [ 
		'creator_id',
		'title',
	];

	//! Relationships
	public function creator(): BelongsTo {
		return $this->belongsTo( User::class, 'creator_id' );
	}
	public function tasks(): HasMany {
		return $this->hasMany( Task::class, );
	}

	public function members(): BelongsToMany {
		return $this->belongsToMany(
			User::class,
			Member::class,
		);
	}

	//! Global Scopes
	protected static function booted(): void {
		static::addGlobalScope( 'creator', function (Builder $query) {
			$query->where( 'creator_id', auth()->id() );
		} );
	}

}
