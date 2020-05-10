<?php

namespace App\Providers;

use Google\Cloud\PubSub\PubSubClient;
use Illuminate\Support\ServiceProvider;
use App\Contracts\PubSubClientContract;
use App\PubSubClient as AppPubSubClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PubSubClient::class, function () {
            return new PubSubClient([
                'projectId' => env('GOOGLE_CLOUD_PROJECT', 'emulator-project')
            ]);
        });
        $this->app->bind(PubSubClientContract::class, function ($app) {
            return new AppPubSubClient($app->make(PubSubClient::class));
        });
    }
}
