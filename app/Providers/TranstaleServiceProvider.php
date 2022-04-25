<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;

class TranstaleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $lang = \Session::get('website_language', config('app.locale'));
        View::share(
            'translationJson',
            File::get(resource_path('lang/' . $lang . '.json'))
        );
    }
}
