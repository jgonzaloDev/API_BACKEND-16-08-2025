<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

class AzureBlobControllerOld extends Controller
{
    protected $blobClient;
    protected $containerName = 'imagenes'; 

public function __construct()
{
    $connectionString = env('AZURE_STORAGE_CONNECTION_STRING');
    $this->containerName = env('AZURE_STORAGE_CONTAINER', 'imagenes'); 
    $this->blobClient = BlobRestProxy::createBlobService($connectionString);
}


    public function listarBlobs()
    {
        try {
            $blobs = $this->blobClient->listBlobs($this->containerName);
            $blobItems = [];

            foreach ($blobs->getBlobs() as $blob) {
                $blobItems[] = [
                    'name' => $blob->getName()
                ];
            }
            

            return response()->json($blobItems);
        } catch (ServiceException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function obtenerBlob($blobName)
{
    try {
        $blob = $this->blobClient->getBlob($this->containerName, $blobName);
        $stream = $blob->getContentStream();
        $properties = $blob->getProperties();
        $mimeType = $properties->getContentType();

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $blobName . '"',
        ]);
    } catch (ServiceException $e) {
        return response()->json([
            'error' => 'No se pudo obtener el blob: ' . $e->getMessage()
        ], 500);
    }
}

}
