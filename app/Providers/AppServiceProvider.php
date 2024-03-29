<?php

namespace App\Providers;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Schema\Blueprint;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadHelpers();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (config('app.force_https')) {
            $this->app['request']->server->set('HTTPS', true);
            URL::forceScheme('https');
        }
        config('app.timezone', 'Asia/Dhaka');

        Fortify::ignoreRoutes();
        Paginator::useBootstrap();

        Schema::defaultStringLength(120);

        Response::macro('success', function ($data = null, $message = null, $code = 200)
        {
            return Response::json([
                'success' => true,
                'data'    => $data,
                'message' => $message,
                JSON_PRESERVE_ZERO_FRACTION,
            ], $code);
        });

        Response::macro('error', function ($data = null, $message = null, $code = 400)
        {
            return Response::json([
                'success' => false,
                'data'    => $data,
                'message' => $message,
                JSON_PRESERVE_ZERO_FRACTION,
            ], $code);
        });
    }

    /**
     * Load helpers.
     */
    protected function loadHelpers()
    {
        foreach (glob(__DIR__ . '/../Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }
}