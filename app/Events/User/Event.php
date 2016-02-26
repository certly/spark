<?php

namespace Laravel\Spark\Events\User;

use Illuminate\Contracts\Auth\Authenticatable;

trait Event
{
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @return void
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }
}
