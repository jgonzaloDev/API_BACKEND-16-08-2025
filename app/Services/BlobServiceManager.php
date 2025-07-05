<?php

namespace App\Services;

use App\Infrastructure\Storage\Interfaces\StorageInterface;
use Illuminate\Contracts\Container\Container;

class BlobServiceManager{
    protected $app;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

     public function driver(): StorageInterface
    {
        $name ??= env('APP_ENV','local')=='production' ?'azure':'public';

        return match ($name) {
            'azure' => $this->app->make('azure_blob'),
            'public'   => $this->app->make('local_blob'),
            default => throw new \Exception("Driver [$name] no soportado"),
        };
    }

}
