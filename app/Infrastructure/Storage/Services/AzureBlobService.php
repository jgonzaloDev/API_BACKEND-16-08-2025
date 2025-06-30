<?php

namespace App\Infrastructure\Storage\Services;

use App\Infrastructure\Storage\Interfaces\BlobServiceInterface;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

class AzureBlobService implements BlobServiceInterface{
    protected $blobClient;
    protected $containerName;

    public function __construct()
    {
        $connectionString = env('AZURE_STORAGE_CONNECTION_STRING');
        $this->containerName = env('AZURE_STORAGE_CONTAINER', 'imagenes');
        $this->blobClient = BlobRestProxy::createBlobService($connectionString);
    }

    public function listarBlobs(){
        try {
            $blobs = $this->blobClient->listBlobs($this->containerName);
            $blobItems = [];

            foreach ($blobs->getBlobs() as $blob) {
                $blobItems[] = [
                    'name' => $blob->getName(),
                ];
            }

            return $blobItems;
        } catch (ServiceException $e) {
            throw new \Exception('Error al listar blobs: ' . $e->getMessage(), 500);
        }
    }

    public function obtenerBlob($blobName){
        try {
            $blob = $this->blobClient->getBlob($this->containerName, $blobName);
            $stream = $blob->getContentStream();
            $properties = $blob->getProperties();
            $mimeType = $properties->getContentType();

            return [
                'stream' => $stream,
                'mimeType' => $mimeType,
                'blobName' => $blobName,
            ];
        } catch (ServiceException $e) {
            throw new \Exception('No se pudo obtener el blob: ' . $e->getMessage(), 500);
        }
    }
}
