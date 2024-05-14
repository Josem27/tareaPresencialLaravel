<div class="container cuerpo text-center bg-info text-white py-3">
    @auth
        <p><h2>Bienvenido {{ auth()->user()->nick }}</h2></p>
    @endauth
    <hr class="bg-light" width="50%">
</div>

<div class="container cuerpo text-center bg-info text-white py-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="text-center">
                <div class="btn-group me-2" role="group" aria-label="First group">
                    <a class="btn btn-info btn-lg" href="{{ route('nuevaEntrada') }}" role="button">Añadir entrada</a>
                </div>
                <div class="btn-group me-2" role="group" aria-label="Second group">
                    <a class="btn btn-info btn-lg" href="{{ route('generar.pdf') }}" role="button">Imprimir PDF</a>
                </div>
                @auth
                    <div class="btn-group" role="group" aria-label="Fourth group">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info btn-lg">Cerrar Sesión</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>
    <hr class="bg-light" width="50%">
</div>

@yield('contenidoMenu')