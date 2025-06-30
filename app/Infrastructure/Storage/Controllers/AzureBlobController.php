<?php

namespace App\Infrastructure\Storage\Controllers;

use App\Http\Controllers\Controller;
use App\Infrastructure\Storage\Services\AzureBlobService;

class AzureBlobController extends Controller
{
    protected $azureBlobService;

    public function __construct(AzureBlobService $azureBlobService)
    {
        $this->azureBlobService = $azureBlobService;
    }

    public function listarBlobs()
    {
        try {
            $blobs = $this->azureBlobService->listarBlobs();
            return response()->json($blobs);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function obtenerBlob($blobName)
    {
        try {
            $blobData = $this->azureBlobService->obtenerBlob($blobName);

            return response()->stream(function () use ($blobData) {
                fpassthru($blobData['stream']);
            }, 200, [
                'Content-Type' => $blobData['mimeType'],
                'Content-Disposition' => 'inline; filename="' . $blobData['blobName'] . '"',
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
