<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AzureBlobController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::prefix('api')->group(function () {
    Route::get('/blobs', [AzureBlobController::class, 'listarBlobs']);
    Route::get('/blob/{name}', [AzureBlobController::class, 'obtenerBlob']);

    Route::get('alumnos', [AlumnoController::class, 'index']);
    Route::get('alumnos/{id}', [AlumnoController::class, 'show']);
    Route::post('alumnos', [AlumnoController::class, 'store']);
    Route::put('alumnos/{id}', [AlumnoController::class, 'update']);
    Route::delete('alumnos/{id}', [AlumnoController::class, 'delete']);

    Route::get('/test', fn() => response()->json(['status' => 'Laravel OK']));

    // ✅ Ruta de prueba de conexión con la base de datos
    Route::get('/test-db', function () {
        try {
            DB::connection()->getPdo();
            $dbName = DB::connection()->getDatabaseName();
            return response()->json([
                'status' => '✅ Conexión exitosa con la base de datos',
                'database' => $dbName
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => '❌ Error de conexión',
                'message' => $e->getMessage()
            ]);
        }
    });
});
