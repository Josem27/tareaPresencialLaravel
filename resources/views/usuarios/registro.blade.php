@extends('base')

@section('contenido')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h2 class="text-center">Registrar usuario</h2>
                </div>
                <div class="card-body">
                    @if (session('invalido'))
                    <div class="alert alert-danger">{{ session('invalido')}}</div>
                    @endif
                    <form action="{{ route('registro') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="nick" class="form-label">Nick</label>
                            <input type="text" class="form-control" name="nick">
                            @error('nick')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="nombre">
                            @error('nombre')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos">
                            @error('apellidos')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email">
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password">
                            @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Registrar</button>
                    </form>
                    <br>
                    <div class="text-center">
                        <a href="/login" class="btn btn-info btn-block">Loguearse</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection