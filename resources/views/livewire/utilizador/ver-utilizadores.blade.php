@section('titulo')
    Ver Utilizadores
@endsection
<div>
    <x-breadcrumb layer1="Utilizadores" layer2="Ver Utilizadores" layer1route="utilizadores" />

    <x-alertas />

    <a class="btn btn-primary" href="{{ route('utilizadores.criar') }}">Criar Utilizador</a>

    <table class="table">
        <thead>
            <td></td>
            <td>Nome</td>
            <td>Email</td>
            <td>Admin</td>
            <td>Tipo Utilizador</td>
            <td>Status Utilizador</td>
        </thead>
        <tbody>
            @forelse ($Utilizadores as $item)
                <tr>
                    <td>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Ações
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('utilizadores.editar', ['id' => Crypt::encrypt($item->id) ]) }}">Editar</a></li>
                                <li><a class="dropdown-item"
                                        onclick="return confirm('Tem a certeza que deseja apagar este utilizador?')"
                                        wire:click="apagarUtilizador('{{ Crypt::encrypt($item->id) }}')">Apagar</a>
                                </li>
                                <hr>
                                <li><a class="dropdown-item" wire:click="resetarPassword('{{ Crypt::encrypt($item->id) }}')">Resetar
                                        Password</a>
                                </li>
                                @if ($item->id_status_utilizador == env('UTILIZADOR_ATIVO'))
                                    <li><a class="dropdown-item"
                                            wire:click="bloquearUtilizador('{{ Crypt::encrypt($item->id) }}')">Bloquear</a>
                                    </li>
                                @else
                                    <li><a class="dropdown-item"
                                            wire:click="ativarUtilizador('{{ Crypt::encrypt($item->id) }}')">Ativar</a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </td>
                    <td>{{ $item->nome }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        @if ($item->admin == 1)
                            <span class="badge text-bg-success">Sim</span>
                        @else
                            <span class="badge text-bg-danger">Não</span>
                        @endif
                    </td>
                    <td>{{ $item->tipo_utilizador }}</td>
                    <td>
                        @php
                            $statusColors = [
                                1 => 'success', // ATIVO
                                2 => 'danger', // BLOQUEADO
                                3 => 'warning', // PENDENTE
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$item->id_status_utilizador] }}">
                            {{ $item->status_utilizador }}
                        </span>
                    </td>
                </tr>
            @empty
                <td colspan="4">Não tem dados</td>
            @endforelse
        </tbody>
    </table>

</div>
@section('script')
    <script>
        function apagarUtilizador(id) {
            if (confirm('Tem a certeza que deseja apagar este utilizador?')) {
                Livewire.dispatch('apagarUtilizador', id);
            }
        }
    </script>
@endsection
