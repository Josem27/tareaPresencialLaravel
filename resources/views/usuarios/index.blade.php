@extends('base')

@section('contenido')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h2 class="text-center">Acceso</h2>
                </div>
                <div class="card-body">
                    @if (session('invalido'))
                    <div class="alert alert-danger">{{ session('invalido')}}</div>
                    @endif
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input type="text" class="form-control" name="usuario">
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password">
                            @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" name="submit" class="btn btn-info btn-block">Acceder</button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a href="{{ route('registro') }}" class="btn btn-success btn-block">Registrarse</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
