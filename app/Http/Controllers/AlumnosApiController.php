<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Validation\Rule;

class AlumnosApiController extends Controller
{
    public function readAll()
    {
        $alumnos = Alumno::orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return response()->json([
            'mensaje' => 'Lista de alumnos obtenida correctamente',
            'alumnos' => $alumnos
        ], 200);
    }

    public function readOne($id)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return response()->json([
                'mensaje' => 'Alumno no encontrado'
            ], 404);
        }

        return response()->json([
            'mensaje' => 'Alumno encontrado correctamente',
            'alumno' => $alumno
        ], 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'matricula' => 'required|string|max:255|unique:alumnos,matricula',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'email' => 'required|email|max:255|unique:alumnos,email'
        ]);

        $alumno = Alumno::create($data);

        return response()->json([
            'mensaje' => 'Alumno registrado correctamente',
            'alumno' => $alumno
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return response()->json([
                'mensaje' => 'Alumno no encontrado'
            ], 404);
        }

        $data = $request->validate([
            'matricula' => [
                'required', 'string', 'max:255',
                Rule::unique('alumnos', 'matricula')->ignore($alumno->id),
            ],
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('alumnos', 'email')->ignore($alumno->id),
            ],
        ]);

        $alumno->update($data);

        return response()->json([
            'mensaje' => 'Alumno actualizado correctamente',
            'alumno' => $alumno
        ], 200);
    }

    public function toggleActive($id)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return response()->json([
                'mensaje' => 'Alumno no encontrado'
            ], 404);
        }

        $alumno->update([
            'activo' => !$alumno->activo
        ]);

        return response()->json([
            'mensaje' => $alumno->activo
                ? 'Alumno activado correctamente'
                : 'Alumno desactivado correctamente',
            'alumno' => $alumno
        ], 200);
    }

    public function delete($id)
    {
        $alumno = Alumno::find($id);

        if (!$alumno) {
            return response()->json([
                'mensaje' => 'Alumno no encontrado'
            ], 404);
        }

        $alumno->delete();

        return response()->json([
            'mensaje' => 'Alumno eliminado correctamente'
        ], 200);
    }
}
