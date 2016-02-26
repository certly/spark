<?php

namespace Laravel\Spark\Http\Controllers\Settings;

use Laravel\Spark\Spark;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Laravel\Spark\Repositories\UserRepository;

class DashboardController extends Controller
{
    /**
     * The user repository instance.
     *
     * @var \Laravel\Spark\Repositories\UserRepository
     */
    protected $users;

    /**
     * Create a new controller instance.
     *
     * @param  \Laravel\Spark\Repositories\UserRepository  $users
     * @return void
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;

        $this->middleware('auth');
    }

    /**
     * Show the settings dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $data = [
            'activeTab' => $request->get('tab', Spark::firstSettingsTabKey()),
            'invoices' => [],
            'user' => $this->users->getCurrentUser(),
        ];

        if (Auth::user()->stripe_id) {
            $data['invoices'] = Cache::remember('spark:invoices:'.Auth::id(), 30, function () {
                return Auth::user()->invoices();
            });
        }

        return view('spark::settings.dashboard', $data);
    }
}
