@extends('base')
@section('contenido')
@extends('menu')

<div class="container cuerpo text-center">
    <table class="table">
        <tr>
            <th>Usuario</th>
            <th>Operacion</th>
            <th>Fecha</th>
        </tr>
        @foreach ($logs as $log)
        <tr>
            <td>{{$log->usuario}}</td>
            <td>{{$log->operacion}}</td>
            <td>{{$log->fecha}}</td>
        </tr>
        @endforeach
    </table>
    <a class="btn btn-primary" href="{{route('entradas',[0])}}" role="button">Volver</a>
    <hr>
</div>

@endsection