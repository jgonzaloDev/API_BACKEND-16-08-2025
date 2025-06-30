<?php

namespace App\Services;

use App\DTO\AlumnoDTO;
use App\Models\Alumno;
use Illuminate\Support\Facades\Log;
use Exception;

class AlumnoService
{
    public function listAll()
    {
        Log::info('Obteniendo todos los alumnos');

        try {
            $alumnos = Alumno::all();

            $alumnosDTO = $alumnos->map(function ($alumno) {
                return new AlumnoDTO(
                    $alumno->id,
                    $alumno->matricula,
                    $alumno->nombre,
                    $alumno->fecha_nacimiento,
                    $alumno->telefono,
                    $alumno->email,
                    $alumno->nivel_id
                );
            });

            Log::info('Se obtuvieron ' . count($alumnosDTO) . ' alumnos');

            return $alumnosDTO;
        } catch (Exception $e) {
            Log::error('Error al obtener alumnos: ' . $e->getMessage());
            throw $e;
        }
    }

    public function findDetail($id)
    {
        Log::info("Buscando detalle del alumno con ID: $id");

        try {
            $alumno = Alumno::find($id);

            if (!$alumno) {
                Log::warning("Alumno con ID $id no encontrado");
                return null;
            }

            $alumnoDTO = new AlumnoDTO(
                $alumno->id,
                $alumno->matricula,
                $alumno->nombre,
                $alumno->fecha_nacimiento,
                $alumno->telefono,
                $alumno->email,
                $alumno->nivel_id
            );

            Log::info("Alumno encontrado: ID $id");

            return $alumnoDTO;
        } catch (Exception $e) {
            Log::error("Error al buscar detalle del alumno ID $id: " . $e->getMessage());
            throw $e;
        }
    }

    public function create(AlumnoDTO $alumnoDTO)
    {
        Log::info('Creando nuevo alumno', ['matricula' => $alumnoDTO->matricula]);

        try {
            $alumno = new Alumno();
            $alumno->matricula = $alumnoDTO->matricula;
            $alumno->nombre = $alumnoDTO->nombre;
            $alumno->fecha_nacimiento = $alumnoDTO->fecha_nacimiento;
            $alumno->telefono = $alumnoDTO->telefono;
            $alumno->email = $alumnoDTO->email;
            $alumno->nivel_id = $alumnoDTO->nivel_id;
            $alumno->save();

            Log::info('Alumno creado con ID: ' . $alumno->id);

            return new AlumnoDTO(
                $alumno->id,
                $alumno->matricula,
                $alumno->nombre,
                $alumno->fecha_nacimiento,
                $alumno->telefono,
                $alumno->email,
                $alumno->nivel_id
            );
        } catch (Exception $e) {
            Log::error('Error al crear alumno: ' . $e->getMessage(), ['matricula' => $alumnoDTO->matricula]);
            throw $e;
        }
    }


     public function update(AlumnoDTO $alumnoDTO,$id){
        $alumno=Alumno::find($id);
        $alumno->matricula=$alumnoDTO->matricula;
        $alumno->nombre=$alumnoDTO->nombre;
        $alumno->fecha_nacimiento=$alumnoDTO->fecha_nacimiento;
        $alumno->telefono=$alumnoDTO->telefono;
        $alumno->email=$alumnoDTO->email;
        $alumno->nivel_id=$alumnoDTO->nivel_id;
        $alumno->save();
        $alumnoDTO->id=$id;
        return $alumnoDTO;
    }

    public function elimina($id){
        $alumno=Alumno::find($id);
        // $alumno->delete();
        if($alumno){
            $alumno->delete();
            return response()->json(['message'=>'Alumno eliminado con exito!'],200);
        }else{
            return response()->json(['message'=>'Alumno no encontrado!'],404);
        }
    }
}
