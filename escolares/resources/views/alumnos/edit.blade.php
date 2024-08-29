<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet"> 
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('alumnos.index') }}">Gestión de Alumnos</a>
        </div>
    </nav>

    <div class="container box"> 
        <h1>Editar Alumno</h1>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(isset($alumno) && is_array($alumno))
        <form action="{{ $editRoute }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="curp" class="form-label">CURP</label>
                <input type="text" class="form-control" id="curp" name="curp" value="{{ $alumno['curp'] ?? old('curp') }}" required>
            </div>
            <div class="mb-3">
                <label for="matricula" class="form-label">Matrícula</label>
                <input type="text" class="form-control" id="matricula" name="matricula" value="{{ $alumno['matricula'] ?? old('matricula') }}" required>
            </div>
    
                <div class="mb-3">
                    <label for="paterno" class="form-label">Apellido Paterno</label>
                    <input type="text" class="form-control" id="paterno" name="paterno" value="{{ old('paterno', $alumno['paterno'] ?? $alumno->paterno ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label for="materno" class="form-label">Apellido Materno</label>
                    <input type="text" class="form-control" id="materno" name="materno" value="{{ old('materno', $alumno['materno'] ?? $alumno->materno ?? '') }}">
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $alumno['nombre'] ?? $alumno->nombre ?? '') }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Alumno</button>
            </form>
        @else
            <div class="alert alert-danger">No se pudieron cargar los datos del alumno.</div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
