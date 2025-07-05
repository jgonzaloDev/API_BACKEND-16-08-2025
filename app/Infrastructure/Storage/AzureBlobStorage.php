<?php

namespace App\Infrastructure\Storage;

use App\Infrastructure\Storage\Interfaces\StorageInterface;
use Illuminate\Support\Facades\Log;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

class AzureBlobStorage implements StorageInterface
{
    protected $blobClient;
    protected $containerName;

    public function __construct()
    {
        $connectionString = env('AZURE_STORAGE_CONNECTION_STRING');
        $this->containerName = env('AZURE_STORAGE_CONTAINER', 'imagenes');
        $this->blobClient = BlobRestProxy::createBlobService($connectionString);
    }

    public function listarBlobs()
    {
        Log::info("Obteniendo archivos alojados en Azure");
        try {
            $blobs = $this->blobClient->listBlobs($this->containerName);
            $blobItems = [];

            foreach ($blobs->getBlobs() as $blob) {
                $blobItems[] = [
                    'name' => $blob->getName(),
                ];
            }

            Log::info("Se obtuvo el listado de nombres de los archivos");
            return $blobItems;
        } catch (ServiceException $e) {
            Log::error("No se pudo acceder al listado de nombre de los archivos");
            return response()->json(['Error al listar blobs: ' . $e->getMessage(),500]);
        }
    }

    public function obtenerBlob($blobName)
    {
        Log::info("Se esta accediendo para visualizar un archivo alojado en Azure");
        try {
            $blob = $this->blobClient->getBlob($this->containerName, $blobName);
            $stream = $blob->getContentStream();
            $properties = $blob->getProperties();
            $mimeType = $properties->getContentType();

            Log::info("El archivo Blob se ha mostrado exitosamente!!");
            return response()->stream(function () use ($stream) {
                fpassthru($stream);
            }, 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $blobName . '"',
            ]);
        } catch (ServiceException $e) {
            Log::error("Error no se puede visualizar archivo Blob");
            return response()->json(['error' => 'No se pudo obtener el blob: ' . $e->getMessage()], 500);
        }
    }
}
