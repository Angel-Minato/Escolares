<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('alumnos.index') }}">Gestión de Alumnos</a>
        </div>
    </nav>

    <div class="container">
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
        <form action="{{ route('alumnos.update', $alumno['id']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="curp" class="form-label">CURP</label>
                <input type="text" class="form-control" id="curp" name="curp" value="{{ old('curp', $alumno['curp']) }}" required>
            </div>
            <div class="mb-3">
                <label for="matricula" class="form-label">Matrícula</label>
                <input type="text" class="form-control" id="matricula" name="matricula" value="{{ old('matricula', $alumno['matricula']) }}" required>
            </div>
            <div class="mb-3">
                <label for="paterno" class="form-label">Apellido Paterno</label>
                <input type="text" class="form-control" id="paterno" name="paterno" value="{{ old('paterno', $alumno['paterno']) }}" required>
            </div>
            <div class="mb-3">
                <label for="materno" class="form-label">Apellido Materno</label>
                <input type="text" class="form-control" id="materno" name="materno" value="{{ old('materno', $alumno['materno']) }}">
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $alumno['nombre']) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar Alumno</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>