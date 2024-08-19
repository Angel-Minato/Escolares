<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlumnoController extends Controller
{
    public function index()
    {
        $response = Http::get('https://webservices.mx/escolares/test/alumnos/listar');
        if ($response->successful()) {
            $alumnos = $response->json();
            // Asegúrate de que $alumnos sea un array, incluso si está vacío
            $alumnos = is_array($alumnos) ? $alumnos : [];
            return view('alumnos.alumnos', compact('alumnos'));
        } else {
            return back()->with('error', 'Error al obtener la lista de alumnos: ' . $response->body());
        }
    }

    public function create()
    {
        return view('alumnos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'curp' => 'required|size:18',
            'matricula' => 'required|max:20',
            'paterno' => 'required|max:50',
            'materno' => 'nullable|max:50',
            'nombre' => 'required|max:50',
        ]);

        $response = Http::get('https://webservices.mx/escolares/test/alumnos/agregar', [
            'curp' => $request->curp,
            'matricula' => $request->matricula,
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'nombre' => $request->nombre,
        ]);

        if ($response->successful()) {
            return redirect()->route('alumnos.index')->with('success', 'Alumno agregado correctamente');
        } else {
            return back()->withInput()->with('error', 'Error al agregar alumno: ' . $response->body());
        }
    }

    public function edit($id)
    {
        $response = Http::get("https://webservices.mx/escolares/test/alumnos/obtener", ['id' => $id]);
        if ($response->successful()) {
            $alumno = $response->json();
            return view('edit', compact('alumno'));  // Cambiado de 'alumnos.edit' a 'edit'
        } else {
            return back()->with('error', 'Error al obtener datos del alumno: ' . $response->body());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'curp' => 'required|size:18',
            'matricula' => 'required|max:20',
            'paterno' => 'required|max:50',
            'materno' => 'nullable|max:50',
            'nombre' => 'required|max:50',
        ]);

        $response = Http::get('https://webservices.mx/escolares/test/alumnos/guardar', [
            'id' => $id,
            'curp' => $request->curp,
            'matricula' => $request->matricula,
            'paterno' => $request->paterno,
            'materno' => $request->materno,
            'nombre' => $request->nombre,
        ]);

        if ($response->successful()) {
            return redirect()->route('alumnos.index')->with('success', 'Alumno modificado correctamente');
        } else {
            return back()->withInput()->with('error', 'Error al modificar alumno: ' . $response->body());
        }
    }

    public function destroy($id)
    {
        $response = Http::get("https://webservices.mx/escolares/test/alumnos/eliminar", ['id' => $id]);

        if ($response->successful()) {
            return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente');
        } else {
            return back()->with('error', 'Error al eliminar alumno: ' . $response->body());
        }
    }
}