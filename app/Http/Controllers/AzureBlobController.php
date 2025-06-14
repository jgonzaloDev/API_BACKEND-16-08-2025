<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

class AzureBlobController extends Controller
{
    protected $blobClient;
    protected $containerName = 'imagenes'; 

public function __construct()
{
    $connectionString = env('AZURE_STORAGE_CONNECTION_STRING');
    $this->containerName = env('AZURE_STORAGE_CONTAINER', 'imagenes'); // puedes mover esto también al .env
    $this->blobClient = BlobRestProxy::createBlobService($connectionString);
}


    public function listarBlobs()
    {
        try {
            $blobs = $this->blobClient->listBlobs($this->containerName);
            $blobItems = [];

            foreach ($blobs->getBlobs() as $blob) {
                $blobItems[] = [
                    'name' => $blob->getName(),
                    'url' => $this->blobClient->getBlobUrl($this->containerName, $blob->getName()),
                ];
            }

            return response()->json($blobItems);
        } catch (ServiceException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
