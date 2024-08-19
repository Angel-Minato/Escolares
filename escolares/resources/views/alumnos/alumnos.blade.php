<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alumnos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('alumnos.index') }}">Gestión de Alumnos</a>
        </div>
    </nav>

    <div class="container">
        <h1>Lista de Alumnos</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <a href="{{ route('alumnos.create') }}" class="btn btn-primary mb-3">Agregar Alumno</a>
        <table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>CURP</th>
            <th>Matrícula</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Nombre</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($alumnos as $alumno)
        <tr>
            <td>{{ $alumno['id'] ?? 'N/A' }}</td>
            <td>{{ $alumno['curp'] ?? 'N/A' }}</td>
            <td>{{ $alumno['matricula'] ?? 'N/A' }}</td>
            <td>{{ $alumno['paterno'] ?? 'N/A' }}</td>
            <td>{{ $alumno['materno'] ?? 'N/A' }}</td>
            <td>{{ $alumno['nombre'] ?? 'N/A' }}</td>
            <td>
                @if(isset($alumno['id']))
                    <a href="{{ route('alumnos.edit', $alumno['id']) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('alumnos.destroy', $alumno['id']) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este alumno?')">Eliminar</button>
                    </form>
                @else
                    <span class="text-muted">Acciones no disponibles</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center">No hay alumnos disponibles</td>
        </tr>
        @endforelse
    </tbody>
</table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>