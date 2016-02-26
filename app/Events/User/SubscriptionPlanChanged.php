<?php

namespace Laravel\Spark\Events\User;

use Illuminate\Queue\SerializesModels;

class SubscriptionPlanChanged
{
    use Event, SerializesModels;
}
