<?php

namespace App\Providers;

use App\Services\CsvReaderService;
use Illuminate\Support\ServiceProvider;

class CSVReaderProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CsvReaderService::class, function ($app) {
            return new CsvReaderService();
        });
    }
}
