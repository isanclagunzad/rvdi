<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('csv', function($attribute, $value, $parameters, $validator) {
            $extension = strtolower($value->getClientOriginalExtension());
            return in_array($extension, ['csv', 'txt']);
        });

        Validator::extend('dat', function($attribute, $value, $parameters, $validator) {
            $extension = strtolower($value->getClientOriginalExtension());
            return in_array($extension, ['tsv','dat','txt']);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
