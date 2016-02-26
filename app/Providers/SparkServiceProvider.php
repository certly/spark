<?php

namespace Laravel\Spark\Providers;

use Laravel\Spark\Auth\Registrar;
use Laravel\Spark\Auth\Subscriber;
use Laravel\Spark\Console\Install;
use Illuminate\Support\ServiceProvider;
use Laravel\Spark\Repositories\UserRepository;
use Laravel\Spark\Repositories\TeamRepository;
use Laravel\Spark\Billing\EmailInvoiceNotifier;
use Laravel\Spark\Contracts\Billing\InvoiceNotifier;
use Laravel\Spark\Contracts\Auth\Registrar as RegistrarContract;
use Laravel\Spark\Contracts\Auth\Subscriber as SubscriberContract;
use Laravel\Spark\Contracts\Repositories\UserRepository as UserRepositoryContract;
use Laravel\Spark\Contracts\Repositories\TeamRepository as TeamRepositoryContract;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->defineRoutes();
        });

        $this->defineResources();
    }

    /**
     * Define the Spark routes.
     *
     * @return void
     */
    protected function defineRoutes()
    {
        if (! $this->app->routesAreCached()) {
            $router = app('router');

            $router->group(['namespace' => 'Laravel\Spark\Http\Controllers'], function ($router) {
                require __DIR__.'/../Http/routes.php';
            });
        }
    }

    /**
     * Define the resources used by Spark.
     *
     * @return void
     */
    protected function defineResources()
    {
        $this->loadViewsFrom(SPARK_PATH.'/resources/views', 'spark');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                SPARK_PATH.'/resources/views' => base_path('resources/views/vendor/spark'),
            ], 'spark-full');

            $this->publishes([
                SPARK_PATH.'/resources/views/emails' => base_path('resources/views/vendor/spark/emails'),
                SPARK_PATH.'/resources/views/welcome.blade.php' => base_path('resources/views/vendor/spark/welcome.blade.php'),
                SPARK_PATH.'/resources/views/nav/guest.blade.php' => base_path('resources/views/vendor/spark/nav/guest.blade.php'),
                SPARK_PATH.'/resources/views/common/footer.blade.php' => base_path('resources/views/vendor/spark/common/footer.blade.php'),
                SPARK_PATH.'/resources/views/nav/authenticated.blade.php' => base_path('resources/views/vendor/spark/nav/authenticated.blade.php'),
                SPARK_PATH.'/resources/views/settings/tabs/profile.blade.php' => base_path('resources/views/vendor/spark/settings/tabs/profile.blade.php'),
                SPARK_PATH.'/resources/views/settings/tabs/security.blade.php' => base_path('resources/views/vendor/spark/settings/tabs/security.blade.php'),
                SPARK_PATH.'/resources/views/settings/team/tabs/owner.blade.php' => base_path('resources/views/vendor/spark/settings/team/tabs/owner.blade.php'),
                SPARK_PATH.'/resources/views/auth/registration/simple/basics.blade.php' => base_path('resources/views/vendor/spark/auth/registration/simple/basics.blade.php'),
                SPARK_PATH.'/resources/views/auth/registration/subscription/basics.blade.php' => base_path('resources/views/vendor/spark/auth/registration/subscription/basics.blade.php'),
                SPARK_PATH.'/resources/views/settings/team/tabs/membership/modals/edit-team-member.blade.php' => base_path('resources/views/vendor/spark/settings/team/tabs/membership/modals/edit-team-member.blade.php'),
            ], 'spark-basics');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (! defined('SPARK_PATH')) {
            define('SPARK_PATH', realpath(__DIR__.'/../../'));
        }

        if (! class_exists('Spark')) {
            class_alias('Laravel\Spark\Spark', 'Spark');
        }

        config([
            'auth.password.email' => 'spark::emails.auth.password.email',
        ]);

        $this->defineServices();

        if ($this->app->runningInConsole()) {
            $this->commands([Install::class]);
        }
    }

    /**
     * Bind the Spark services into the container.
     *
     * @return void
     */
    protected function defineServices()
    {
        $services = [
            RegistrarContract::class => Registrar::class,
            InvoiceNotifier::class => EmailInvoiceNotifier::class,
            UserRepositoryContract::class => UserRepository::class,
            TeamRepositoryContract::class => TeamRepository::class,
        ];

        foreach ($services as $key => $value) {
            $this->app->bindIf($key, $value);
        }
    }
}
