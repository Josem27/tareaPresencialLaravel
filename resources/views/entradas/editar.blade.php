@extends('base')

@section('contenido')
@foreach ($detalles as $entrada)

<div class="container cuerpo text-center bg-success text-white py-3">
    <div>
        <h2>Editando entrada</h2>
    </div>
    <hr class="bg-light" width="50%">
</div>

<div class="container cuerpo text-center bg-success text-white py-3">
    <div>
        <a class="btn btn-primary" href="{{ route('entradas', [0]) }}" role="button">Volver</a>
    </div>
    <hr class="bg-light" width="50%">
</div>

<div class="container text-center">
    <form action="{{ route('editar', $entrada->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" name="titulo" value="{{ $entrada->titulo }}" required>
        </div>

        <div class="mb-3">
            <img src="{{ asset('images/'.$entrada->imagen) }}" width="260"><br>
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" name="imagen" class="form-control-file">
        </div>

        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <select name="categoria" class="form-control" required>
                @foreach ($categorias as $key)
                    <option value="{{ $key->id }}" {{ $key->id == $entrada->categoria_id ? 'selected' : '' }}>{{ $key->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="ckeditor form-control" name="descripcion" required>{{ $entrada->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" name="fecha" value="{{ $entrada->fecha }}" required>
        </div>

        <div class="mb-3">
            <label for="hora" class="form-label">Hora</label>
            <input type="time" class="form-control" name="hora" value="{{ $entrada->hora }}" required>
        </div>

        <div class="mb-3">
            <label for="lugar" class="form-label">Lugar</label>
            <input type="text" class="form-control" name="lugar" value="{{ $entrada->lugar }}" required>
        </div>

        <div class="mb-3">
            <label for="prioridad" class="form-label">Prioridad</label>
            <select name="prioridad" class="form-control" required>
                <option value="1" {{ $entrada->prioridad == 1 ? 'selected' : '' }}>1 - Muy Baja</option>
                <option value="2" {{ $entrada->prioridad == 2 ? 'selected' : '' }}>2 - Baja</option>
                <option value="3" {{ $entrada->prioridad == 3 ? 'selected' : '' }}>3 - Media</option>
                <option value="4" {{ $entrada->prioridad == 4 ? 'selected' : '' }}>4 - Alta</option>
                <option value="5" {{ $entrada->prioridad == 5 ? 'selected' : '' }}>5 - Muy Alta</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <hr class="bg-secondary" width="100%">
            <div class="form-check">
                <input type="radio" class="form-check-input" id="completado" name="estado" value="completado" {{ $entrada->estado == 'completado' ? 'checked' : '' }} required>
                <label class="form-check-label" for="completado">Completado</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" id="pendiente" name="estado" value="pendiente" {{ $entrada->estado == 'pendiente' ? 'checked' : '' }} required>
                <label class="form-check-label" for="pendiente">Pendiente</label>
            </div>
            <div class="form-check">
                <input type="radio" class="form-check-input" id="cancelado" name="estado" value="cancelado" {{ $entrada->estado == 'cancelado' ? 'checked' : '' }} required>
                <label class="form-check-label" for="cancelado">Cancelado</label>
            </div>
        </div>

        <input type="hidden" name="usuario_id" value="{{ $entrada->usuario_id }}">

        <button type="submit" name="submit" class="btn btn-primary">Editar entrada</button>
    </form>
</div>

@endforeach
@endsection
