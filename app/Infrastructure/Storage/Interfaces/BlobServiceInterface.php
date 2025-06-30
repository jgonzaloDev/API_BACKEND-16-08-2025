<?php

namespace App\Infrastructure\Storage\Interfaces;

Interface BlobServiceInterface
{
    public function listarBlobs();

    public function obtenerBlob($blobName);
}
