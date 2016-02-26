<?php

namespace Laravel\Spark\Events\User;

use Illuminate\Queue\SerializesModels;

class SubscriptionResumed
{
    use Event, SerializesModels;
}
