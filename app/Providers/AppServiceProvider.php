<?php

namespace App\Providers;

use App\Http\View\Composers\UserPermissionsComposer;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        $this->loadHelpers();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('PRODUCTION') && env('PRODUCTION') == 1) {
            URL::forceScheme('https');
        }

        View::composer([
            'user.modules.*'
        ], UserPermissionsComposer::class);
    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__ . '/../Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }
}
