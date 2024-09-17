<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
	use HasFactory, Notifiable, HasApiTokens;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [ 
		'name',
		'email',
		'password',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [ 
		'password',
		'remember_token',
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array {
		return [ 
			'email_verified_at' => 'datetime',
			'password' => 'hashed',
		];
	}

	//! Relationships
	public function tasks(): HasMany {
		return $this->hasMany( Task::class, 'creater_id' );
	}

	public function Projects(): HasMany {
		return $this->hasMany( Project::class, 'creator_id' );
	}

	/**
	 * Define a many-to-many relationship.
	 *
	 * @template TRelatedModel of \Illuminate\Database\Eloquent\Model
	 *
	 * @param  class-string<TRelatedModel>  $related
	 * @param  string|class-string<\Illuminate\Database\Eloquent\Model>|null  $table
	 * @param  string|null  $foreignPivotKey
	 * @param  string|null  $relatedPivotKey
	 * @param  string|null  $parentKey
	 * @param  string|null  $relatedKey
	 * @param  string|null  $relation
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<TRelatedModel, $this>
	 */
	public function memeberProjects(): BelongsToMany {
		return $this->belongsToMany(
			Project::class,
			Member::class,
		);
	}

}
