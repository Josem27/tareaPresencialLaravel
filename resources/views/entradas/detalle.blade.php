@extends('base')

@section('contenido')

@foreach ($detalles as $datos)
<div class="container cuerpo text-center">
    <div class="bg-info text-white py-3">
        <h2>Entrada de: {{$datos->usuario->nick}}</h2>
        <hr class="bg-light" width="50%">
    </div>

    <div class="text-center">
        <div class="bg-info text-white py-3">
            <h3>{{$datos->titulo}}</h3>
            <hr class="bg-light" width="50%">
        </div><br>

        <label for="imagen"><b>Imagen</b></label><br>
        <img src="{{asset('storage/'.$datos->imagen)}}" width="260"><br>

        <label for="categoria"><b>Categoría:</b></label><br>
        <label for="categoria">{{$datos->categoria->nombre}}</label><br>

        <div>
            <label for="descripcion"><b>Descripción:</b></label><br>
            <label>{!! $datos->descripcion !!}</label><br>
        </div>
    </div>

    <div class="bg-info text-white py-3">
        <hr class="bg-light" width="50%">
        <a class="btn btn-primary" href="{{route('entradas',[0])}}" role="button">Volver</a>
    </div>
</div>
@endforeach

@endsection
