<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use Illuminate\Validation\Rule;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::orderBy('apellido')
            ->orderBy('nombre')
            ->get();

        return view('alumnos', compact('alumnos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'matricula' => 'required|string|max:255|unique:alumnos,matricula',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'age' => 'required|integer|min:1',
            'email' => 'required|email|max:255|unique:alumnos,email',
        ]);

        Alumno::create($data);

        return redirect('/alumnos')
            ->with('success', 'Alumno registrado correctamente.');
    }

    public function update(Request $request, Alumno $alumno)
    {
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

        return redirect('/alumnos')
            ->with('success', 'Alumno actualizado correctamente.');
    }

    public function toggleActivo(Alumno $alumno)
    {
        $alumno->update([
            'activo' => !$alumno->activo,
        ]);

        return redirect('/alumnos')
            ->with('success', $alumno->activo
                ? 'Alumno activado correctamente.'
                : 'Alumno desactivado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();

        return redirect('/alumnos')
            ->with('success', 'Alumno eliminado correctamente.');
    }
}
