<?php

namespace Laravel\Spark\Events\User;

use Illuminate\Queue\SerializesModels;

class Subscribed
{
    use Event, SerializesModels;
}
