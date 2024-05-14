@extends('base')

@section('contenido')
    @extends('menu')

    @if (session('success'))
        <h6 class="alert alert-success">{{ session('success')}}</h6>
    @endif

    @if (session('eliminado'))
        <h6 class="alert alert-success">{{ session('eliminado')}}</h6>
    @endif

    <style>
        .btn-action {
            height: 38px; 
            line-height: 1.5;
        }
    </style>

    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Fecha</th>+
                        <th>Autor</th>
                        <th>Acciones</th> <!-- Columna de acciones al final -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entradas as $datos)
                    <tr>
                        <td>{{ $datos->titulo }}</td>
                        <td>{{ $datos->fecha }}</td>
                        <td>{{ $datos->usuario ? $datos->usuario->nick : 'Usuario no disponible' }}</td> <!-- Cambiado para mostrar fecha y autor -->
                        <td>
                            <div class="btn-group" role="group" aria-label="Acciones">
                                <a class="btn btn-primary btn-action" href="{{ route('detalle',$datos->id) }}" role="button"><i class="bi bi-info-circle"></i></a>
                                @auth
                                    @if (session('esAdmin') || (auth()->user()->nick == $datos->usuario->nick))
                                        <a class="btn btn-warning btn-action" href="{{ route('editar',$datos->id) }}" role="button"><i class="bi bi-pencil"></i></a>
                                        <form action="{{ route('eliminar', $datos->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('¿Estás seguro de que deseas eliminar esta entrada?')"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                @endauth
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('paginado')
@endsection
