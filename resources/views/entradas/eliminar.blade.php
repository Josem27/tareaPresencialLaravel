@extends('base')
@section('contenido')

@foreach ($detalles as $datos)

@endforeach
<div class="container cuerpo text-center">
    <?php foreach ($detalles as $datos) : ?>
        <p>
        <h2>Entrada de: {{$datos->usuario->nick}}
            <h2></h2>
            </p>
            <hr width="50%" color="black">
</div>
<div class="container cuerpo text-center">
    <a class="btn btn-primary" href="{{route('entradas',[0])}}" role="button">Volver</a>
    <hr width="50%" color="black">
</div>
<div class="container text-center">
    <label for="titulo" class="form-label"><b>Titulo</b> </label><br>
    <label for="titulo">{{$datos->titulo}}</label><br>

    <label for="imagen"><b>Imagen</b></label><br>
    <img src="{{asset('storage/fotos/'.$datos->imagen)}}" width="260"><br>
    <label for="categoria"><b>Categoria:</b></label><br>
    <label for="categoria">{{$datos->categoria->nombre}}</label><br>

    <div>
        <label for="descripcion"><b>Descripción:</b></label><br>
        <label for="">{{$datos->descripcion}}</label><br>

        <form action="/eliminar/{{$datos->id}}" method="POST">
            @method('DELETE')
            @csrf
            <button class="btn btn-danger" type="submit">Eliminar</button>
        </form>


    </div>
<?php endforeach; ?>
</div>
@endsection