<?php

namespace App\Providers;

use App\Events\ContractCreated;
use App\Listeners\SendContractCreatedNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Model::unguard();


//        Model::preventLazyLoading(!$this->app->isProduction());
    }
}
