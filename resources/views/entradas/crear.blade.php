@extends('base')

@section('contenido')
<div class="container cuerpo text-center bg-success text-white py-3">
    <div>
        <h2>Nueva entrada</h2>
    </div>
    <hr class="bg-light" width="50%">
</div>

<div class="container cuerpo text-center bg-success text-white py-3">
    <div>
        <a class="btn btn-primary" href="{{ route('entradas',[0]) }}" role="button">Volver</a>
    </div>
    <hr class="bg-light" width="50%">
</div>

<div class="container text-center">
    <form action="{{ route('nuevaEntrada') }}" method="post" enctype="multipart/form-data">
        @csrf    
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" name="titulo" required>
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" class="form-control-file">
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select name="categoria" class="form-control" required>
                @foreach ($categorias as $key)
                    <option value="{{ $key->id }}">{{ $key->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="ckeditor form-control" name="descripcion" required></textarea>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" name="fecha" required>
        </div>

        <div class="mb-3">
            <label for="hora" class="form-label">Hora</label>
            <input type="time" class="form-control" name="hora" required>
        </div>

        <div class="mb-3">
            <label for="lugar" class="form-label">Lugar</label>
            <input type="text" class="form-control" name="lugar" required>
        </div>

        <div class="mb-3">
            <label for="prioridad" class="form-label">Prioridad</label>
            <select name="prioridad" class="form-control" required>
                <option value="1">1 - Muy Baja</option>
                <option value="2">2 - Baja</option>
                <option value="3">3 - Media</option>
                <option value="4">4 - Alta</option>
                <option value="5">5 - Muy Alta</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <hr class="bg-secondary" width="100%">
            <div class="form-check">
                <input type="radio" class="form-check-input" name="estado" value="completado" required>
                <label class="form-check-label" for="completado">Completado</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="estado" value="pendiente" required>
                <label class="form-check-label" for="pendiente">Pendiente</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" name="estado" value="cancelado" required>
                <label class="form-check-label" for="cancelado">Cancelado</label>
            </div>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Registrar entrada</button>
    </form>
</div>

@endsection
