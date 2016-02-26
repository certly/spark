<?php

namespace Laravel\Spark\Http\Controllers\API;

use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Spark\Contracts\Repositories\UserRepository;

class UserController extends Controller
{
	/**
	 * The user repository instance.
	 *
	 * @var \Laravel\Spark\Contracts\Repositories\UserRepository
	 */
	protected $users;

	/**
	 * Create a new controller instance.
	 *
	 * @param  \Laravel\Spark\Contracts\Repositories\UserRepository  $users
	 * @return void
	 */
	public function __construct(UserRepository $users)
	{
		$this->users = $users;

		$this->middleware('auth');
	}

	/**
	 * Get the current user of the application.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getCurrentUser()
	{
		return $this->users->getCurrentUser();
	}
}
