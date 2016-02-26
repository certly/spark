<?php

namespace Laravel\Spark\Http\Controllers;

use Laravel\Spark\InteractsWithSparkHooks;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use InteractsWithSparkHooks;
}
