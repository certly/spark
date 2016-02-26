<?php

namespace Laravel\Spark\Events\User;

use Laravel\Spark\Teams\Team;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Auth\Authenticatable;

class RemovedFromTeam
{
    use SerializesModels;

    /**
     * The user instance.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $user;

    /**
     * The team instance.
     *
     * @var \Laravel\Spark\Teams\Team
     */
    public $team;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  \Laravel\Spark\Teams\Team $team
     *
     * @return void
     */
    public function __construct(Authenticatable $user, Team $team)
    {
        $this->user = $user;
        $this->team = $team;
    }
}
