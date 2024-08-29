<?php
//AlumnoController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class AlumnoController extends Controller
{
    protected $apiUrl = 'http://localhost/api1/alumnos'; 

    public function index()
{
    $response = Http::get('http://localhost/api1/alumnos');
    if ($response->successful()) {
        $responseBody = $response->body();
        // Eliminar el texto adicional antes del JSON
        $jsonStart = strpos($responseBody, '[');
        if ($jsonStart !== false) {
            $jsonData = substr($responseBody, $jsonStart);
            $alumnos = json_decode($jsonData, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return view('alumnos.alumnos', compact('alumnos'));
            } else {
                return back()->with('error', 'Error al decodificar los datos de alumnos');
            }
        } else {
            return back()->with('error', 'Formato de respuesta inesperado');
        }
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

        $response = Http::post($this->apiUrl, [
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
        Log::info("Intentando editar alumno con ID: {$id}");
    
        $response = Http::get("{$this->apiUrl}?id={$id}");
    
        Log::info('Respuesta completa de la API:', [
            'status' => $response->status(),
            'headers' => $response->headers(),
            'body' => $response->body(),
        ]);
    
        if ($response->successful()) {
            $body = $response->body();
            
            // Eliminar cualquier texto antes del JSON válido
            $jsonStart = strpos($body, '{');
            if ($jsonStart !== false) {
                $body = substr($body, $jsonStart);
            }
            
            $data = json_decode($body, true);
    
            if (json_last_error() === JSON_ERROR_NONE) {
                Log::info('Datos decodificados de la API:', ['data' => $data]);
    
                if (is_array($data) && !empty($data)) {
                    // Si es un array de alumnos, tomar el primero
                    $alumno = is_array($data[0] ?? null) ? $data[0] : $data;
    
                    if (isset($alumno['ID'], $alumno['curp'], $alumno['matricula'])) {
                        $editRoute = route('alumnos.update', ['id' => $alumno['ID']]);
                        return view('alumnos.edit', compact('alumno', 'editRoute'));
                    } else {
                        Log::error('Datos de alumno incompletos:', ['alumno' => $alumno]);
                        return back()->with('error', 'Datos del alumno incompletos.');
                    }
                } else {
                    Log::error('La API devolvió un array vacío o no válido:', ['data' => $data]);
                    return back()->with('error', 'No se encontraron datos para el alumno solicitado.');
                }
            } else {
                Log::error('Error al decodificar JSON:', ['error' => json_last_error_msg(), 'body' => $body]);
                return back()->with('error', 'Error al procesar los datos del alumno.');
            }
        } else {
            Log::error("Error de API para el ID de alumno {$id}: " . $response->body(), [
                'status' => $response->status(),
                'headers' => $response->headers(),
            ]);
            return back()->with('error', 'Error al obtener datos del alumno: ' . $response->status());
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
    
        $response = Http::patch($this->apiUrl, [
            'ID' => $id,
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
        $response = Http::delete($this->apiUrl, ['ID' => $id]);

        if ($response->successful()) {
            return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente');
        } else {
            return back()->with('error', 'Error al eliminar alumno: ' . $response->body());
        }
    }
}
