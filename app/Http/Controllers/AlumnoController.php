<?php

namespace App\Http\Controllers;

use App\DTO\AlumnoDTO;
use App\Services\AlumnoService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlumnoController extends Controller
{
    protected $alumnoService;

    public function __construct(AlumnoService $alumnoService)
    {
        $this->alumnoService = $alumnoService;
    }

    public function index()
    {
        Log::info('Petición recibida: listar alumnos');
        try {
            $all = $this->alumnoService->listAll();
            return response()->json($all);
        } catch (Exception $e) {
            Log::error('Error en index(): ' . $e->getMessage());
            return response()->json(['error' => 'Error al listar alumnos'], 500);
        }
    }

    public function show($id)
    {
        Log::info("Petición recibida: mostrar alumno ID $id");
        try {
            $detail = $this->alumnoService->findDetail($id);
            return response()->json($detail);
        } catch (Exception $e) {
            Log::error("Error en show($id): " . $e->getMessage());
            return response()->json(['error' => 'Error al obtener alumno'], 500);
        }
    }

    public function store(Request $request)
    {
        Log::info('Petición recibida: crear alumno', $request->all());
        try {
            $alumnoDTO = new AlumnoDTO(
                0,
                $request->input('matricula'),
                $request->input('nombre'),
                Carbon::parse($request->input('fecha_nacimiento')),
                $request->input('telefono'),
                $request->input('email'),
                $request->input('nivel_id')
            );

            $created = $this->alumnoService->create($alumnoDTO);
            Log::info('Alumno creado exitosamente: ID ' . $created->id);
            return response()->json($created);
        } catch (Exception $e) {
            Log::error('Error en store(): ' . $e->getMessage());
            return response()->json(['error' => 'Error al crear alumno'], 500);
        }
    }

    // public function update(Request $request, $id)
    // {
    //     Log::info("Petición recibida: actualizar alumno ID $id", $request->all());
    //     try {
    //         $dto = new AlumnoDTO(
    //             0,
    //             $request->input('matricula'),
    //             $request->input('nombre'),
    //             Carbon::parse($request->input('fecha_nacimiento')),
    //             $request->input('telefono'),
    //             $request->input('email'),
    //             $request->input('nivel_id')
    //         );

    //         $updated = $this->alumnoService->update($dto, $id);
    //         Log::info("Alumno actualizado exitosamente: ID $id");
    //         return response()->json($updated);
    //     } catch (Exception $e) {
    //         Log::error("Error en update($id): " . $e->getMessage());
    //         return response()->json(['error' => 'Error al actualizar alumno'], 500);
    //     }
    // }

    // public function delete($id)
    // {
    //     Log::info("Petición recibida: eliminar alumno ID $id");
    //     try {
    //         $deleted = $this->alumnoService->elimina($id);
    //         Log::info("Alumno eliminado exitosamente: ID $id");
    //         return response()->json(['message' => 'Alumno eliminado']);
    //     } catch (Exception $e) {
    //         Log::error("Error en delete($id): " . $e->getMessage());
    //         return response()->json(['error' => 'Error al eliminar alumno'], 500);
    //     }
    // }
}
