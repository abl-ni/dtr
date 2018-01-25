<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Notification;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        require_once app_path('Helpers/GlobalHelper.php');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
