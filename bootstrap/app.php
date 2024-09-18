<?php

use App\Helpers\CustomJsonResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\App;

return Application::configure( basePath: dirname( __DIR__ ) )
	->withRouting(
		web: __DIR__ . '/../routes/web.php',
		api: __DIR__ . '/../routes/api.php',
		commands: __DIR__ . '/../routes/console.php',
		health: '/up',
	)
	->withMiddleware( function (Middleware $middleware) {

	} )
	->withExceptions( function (Exceptions $exceptions) {
		$exceptions->render( function (NotFoundHttpException $e) {
			return App::make( CustomJsonResponse::class)->failure( 'Resource Not Found' );
		} );
		$exceptions->render( function (ValidationException $e) {
			// dump( $e, get_class_methods( $e ) );
			return App::make( CustomJsonResponse::class)->failure( 'Validation Failure', $e->errors(), 422 );
		} );
		$exceptions->render( function (AuthenticationException $e) {
			return App::make( CustomJsonResponse::class)->failure( 'Unauthenticated User', statusCode: 401 );
		} );
		$exceptions->render( function (AccessDeniedHttpException $e) {
			return App::make( CustomJsonResponse::class)->failure( 'This action is unauthorized.', statusCode: 403 );
		} );
	} )->create();
// success( $data, $statusCode = 200, $status = 'success', $message = 'success', $errors = [], $pagination = false ) {
// public function failure( $message = 'failure', $errors = [], $statusCode = 404, $data = [], $status = 'failure', ) {
