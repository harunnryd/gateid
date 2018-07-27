<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Routing\Gateway;
use App\Services\RestClient;
use App\Services\RestMethod;
use Laravel\Passport\Passport;
use App\Contracts\GatewayContract;
use App\Contracts\RestClientContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Passport::ignoreMigrations();
    }

    /**
     * @return void
     */
    public function boot()
    {
        app()->bind('gateway', function ($app) {
            $app->bind(GatewayContract::class, Gateway::class);
            return $app->make(GatewayContract::class);
        });

        app()->bind('rest-method', function ($app) {
            return $app->make(RestMethod::class);
        });

        app()->bind('say-hi', function ($app) {
            return response()->json([
                'message' => 'welcome to api gateway',
                'version' => 'V2'
            ], 200);
        });

        app()->bind(RestClientContract::class, RestClient::class);
    }
}
