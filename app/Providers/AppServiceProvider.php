<?php

namespace App\Providers;

use App\Infrastructure\Storage\AzureBlobStorage;
use App\Infrastructure\Storage\LocalStorage;
use App\Services\BlobServiceManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind('azure_blob', function () {
            return new AzureBlobStorage();
        });

        $this->app->bind('local_blob', function () {
            return new LocalStorage();
        });

        $this->app->singleton(BlobServiceManager::class, function ($app) {
            return new BlobServiceManager($app);
        });
    }


    public function boot(): void
    {
        //
    }
}
