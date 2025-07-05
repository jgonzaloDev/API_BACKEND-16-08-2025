<?php

namespace App\Http\Controllers;

use App\Infrastructure\Storage\Interfaces\StorageInterface;
use App\Services\BlobServiceManager;

class AzureBlobController extends Controller
{
    protected BlobServiceManager $manager;
    protected StorageInterface $service;

    public function __construct(BlobServiceManager $manager)
    {
        $this->manager = $manager;
        $this->service = $this->manager->driver();
    }

    public function listarBlobs()
    {
        return $this->service->listarBlobs();
    }

    public function obtenerBlob($blobName)
    {
        return $this->service->obtenerBlob($blobName);
    }
}
