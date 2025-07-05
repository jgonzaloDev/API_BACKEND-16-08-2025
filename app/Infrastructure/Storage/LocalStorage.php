<?php

namespace App\Infrastructure\Storage;

use App\Infrastructure\Storage\Interfaces\StorageInterface;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;

class LocalStorage implements StorageInterface{
    public function __construct() {}

    public function listarBlobs()
    {
        Log::info("Obteniendo archivos alojados en Storage/app/public");
        try {
            $files = Storage::disk("public")->allFiles();
            $names = array_map(function ($file) {
                return basename($file);
            }, $files);
            Log::info("Se obtuvo el listado de nombres de los archivos");

            return response()->json(['listado'=>$names],200) ;
        } catch (ServiceException $e) {
            Log::error("No se pudo acceder al listado de nombre de los archivos");
            return response()->json(['Error al listar blobs: ' . $e->getMessage(),500]);
        }
    }

    public function obtenerBlob($blobName)
    {
        Log::info("Se esta accediendo para visualizar un archivo alojado en Storage/app/public");
        try {
            $path = storage_path('app/public/' . $blobName);

            if (!file_exists($path)) {
                Log::warning("No existe archivo con ese nombre!!!");
                return  response()->json(['mensaje'=>'Archivo no encontrado'],404);
            }

            Log::info("El archivo Blob se ha mostrado exitosamente!!");
            return response()->file($path);
        } catch (ServiceException $e) {
            Log::error("Error no se puede visualizar archivo Blob");
            return response()->json(['error' => 'No se pudo obtener el blob: ' . $e->getMessage() ], 500);
        }
    }
}
