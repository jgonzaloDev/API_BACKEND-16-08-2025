<?php

namespace App\Infrastructure\Storage\Interfaces;

Interface StorageInterface
{
    public function listarBlobs();

    public function obtenerBlob($blobName);
}
