<div class="container text-center">
    <nav aria-label="...">
        <ul class="pagination">                    
            @if ($page > 0)
                <li class="page-item">
                    <a href="{{ route('entradas', $page - 1) }}">
                        <span class="page-link">Anterior</span>
                    </a>
                </li>
            @endif
            
            @for ($i = max(0, $page - 1); $i <= min($contador, $page + 1); $i++)
                <li class="page-item {{ $i == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ route('entradas', $i) }}">{{ $i + 1 }}</a>
                </li>
            @endfor
            
            @if ($page < $contador - 1)
                <li class="page-item">
                    <a class="page-link" href="{{ route('entradas', $page + 1) }}">Siguiente</a>
                </li>
            @endif
        </ul>
    </nav>
</div>