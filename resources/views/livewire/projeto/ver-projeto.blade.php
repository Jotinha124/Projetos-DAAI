@section('titulo')
    Ver Projetos
@endsection
<div>
    <x-breadcrumb layer1="Projetos" layer2="Ver Projetos" layer1route="projetos" />

    <x-alertas />

    <a class="btn btn-primary" href="{{ route('projetos.criar') }}">Criar Projeto</a>

    <table class="table">
        <thead>
            <td></td>
            <td>Projeto</td>
            <td>Sumario</td>
            <td>Orçamento</td>
            <td>Data Inicio</td>
            <td>Verificado</td>
            <td>Tipo Projeto</td>
            <td>Status</td>
        </thead>
        <tbody>
            @forelse ($projetos as $item)
                <tr>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Ações
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('projetos.editar', ['id' => $item->id]) }}">Editar</a></li>
                                <li><a class="dropdown-item"
                                        onclick="return confirm('Tem a certeza que deseja apagar este utilizador?')"
                                        wire:click="apagarUtilizador({{ $item->id }})">Apagar</a>
                                </li>
                                <hr>
                                <li><a class="dropdown-item" href="{{-- route('projetos.ver', ['id' => $item->id]) --}}">Ver Anexos</a>
                                </li>
                                <li><a class="dropdown-item" href="{{-- route('projetos.ver', ['id' => $item->id]) --}}">Ver Comentarios</a>
                                </li>
                            </ul>
                        </div>
                    </td>
                    <td>{{ $item->projeto }}</td>
                    <td>{{ $item->sumario }}</td>
                    <td>{{ $item->orcamento }} €</td>
                    <td>{{ $item->data }}</td>
                    <td>
                        @if ($item->verificado == 1)
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-check-square" viewBox="0 0 16 16">
                                <path
                                    d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                <path
                                    d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-dash-square" viewBox="0 0 16 16">
                                <path
                                    d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                            </svg>
                        @endif
                    </td>
                    <td>{{ $item->tipo_projeto }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @empty
                <td colspan="7">Não tem dados</td>
            @endforelse
        </tbody>
    </table>

</div>
