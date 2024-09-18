<?php

namespace App\Providers;

use App\Helpers\CustomJsonResponse;
use App\Models\Project;
use App\Policies\ProjectPolicy;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Register any application services.
	 */
	public function register(): void {
		//
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void {
		$this->app->singleton( CustomJsonResponse::class, function () {
			return new CustomJsonResponse();
		} );
		// Gate::policy( Project::class, ProjectPolicy::class);
	}
}
