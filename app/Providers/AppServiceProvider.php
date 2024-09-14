<?php

namespace App\Providers;

use App\Helpers\CustomJsonResponse;
use Illuminate\Support\ServiceProvider;

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
	}
}
