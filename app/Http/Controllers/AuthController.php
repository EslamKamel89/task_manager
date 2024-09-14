<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller {
	use ApiResponse;
	public function login( Request $request ) {
		$validated = $request->validate( [ 
			'email' => [ 'required', 'email' ],
			'password' => 'required',
		] );
		$user = User::where( 'email', $request->email )->first();

		if ( ! $user || ! Hash::check( $request->password, $user->password ) ) {
			throw ValidationException::withMessages( [ 
				'email' => [ 'The provided credentials are incorrect.' ],
			] );
		}

		return $this->success( [ 
			'access_token' => $user->createToken( $user->email )->plainTextToken,
			'token_type' => 'Bearer'
		] );
	}
	public function register( Request $request ) {
		$validated = $request->validate( [ 
			'name' => [ 'required', 'min:2', 'max:100' ],
			'email' => [ 'required', 'unique:users', 'email' ],
			'password' => [ 'required', 'confirmed', Password::min( 8 ) ]
		] );
		$user = User::create( $validated );
		return $this->success( [ 
			'accessToken' => $user->createToken( $user->email )->plainTextToken,
			'tokenType' => 'Bearer',
			'user' => new UserResource( $user ),
		] );
	}
	public function logout( Request $request ) {
		return $this->success( [] );
	}
}
