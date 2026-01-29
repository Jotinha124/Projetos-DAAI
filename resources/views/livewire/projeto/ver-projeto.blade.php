@section('titulo')
    Ver Projetos
@endsection
<div>
    <x-breadcrumb layer1="Projetos" layer2="Ver Projetos" layer1route="projetos" />

    <x-alertas />

    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Projeto [{{ $NomeProjeto }}]</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div wire:loading>
                        A carregar ...
                    </div>
                    <br>
                    Sumario: {{ $Sumario }} <br>
                    Orçamento: {{ $Orcamento }} € <br>
                    Tipo Projeto: {{ $tipoProjeto }} <br>
                    Financiamento: {{ $Financiamento }} <br>
                    Entidades Externas: {{ $entidadesExternas ? 'Sim' : 'Não' }} <br>
                    <hr>
                    <label class="form-label">Técnico de Apoio:</label>
                    <select class="form-select @error('Tecnico') is-invalid @enderror" id="validationDefault04"
                        wire:model="Tecnico" required>
                        <option selected value="">Escolha um técnico...</option>
                        @forelse($tecnicos as $item)
                            <option value="{{ $item->id }}">{{ $item->nome }}</option>
                        @empty
                            <option value="">Não existem técnicos disponíveis</option>+
                        @endforelse
                    </select>
                    @error('Tecnico')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</a>
                    <a type="button" class="btn btn-primary" wire:click="addTecnico('{{ Crypt::encrypt($id) }}')">Atribuir</a>
                </div>
            </div>
        </div>
    </div>

    @if (Session::get('s_idTipoUtilizador') == env('TIPO_INVESTIGADOR'))
        <a class="btn btn-primary" href="{{ route('projetos.criar') }}">Criar Projeto</a>
    @endif

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
            @if (Session::get('s_idTipoUtilizador') == env('TIPO_TECNICO'))
                <td>Investigador</td>
            @else
                <td>Técnico de Apoio</td>
            @endif
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
                                @if (Session::get('s_idTipoUtilizador') == env('TIPO_TECNICO'))
                                    @if ($item->verificado == 0)
                                        <li><a class="dropdown-item"
                                                href="{{ route('projetos.verificar', ['id' => Crypt::encrypt($item->id)]) }}">Autorizar</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                wire:click="atribuirTecnico('{{ Crypt::encrypt($item->id) }}')">
                                                Atribuir Técnico
                                            </a>
                                        </li>
                                    @endif
                                    <li><a class="dropdown-item">Comentar</a>
                                    </li>
                                @else
                                    @if ($item->id_status == env('STATUS_DRAFT'))
                                        <li><a class="dropdown-item"
                                                href="{{ route('projetos.rever', ['id' => Crypt::encrypt($item->id)]) }}">Editar</a>
                                        </li>
                                    @else
                                        <li><a class="dropdown-item" href="{{-- route('projetos.ver', ['id' => $item->id]) --}}">Ver</a>
                                        </li>
                                    @endif
                                @endif


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
                    @if (Session::get('s_idTipoUtilizador') == env('TIPO_TECNICO'))
                        <td>{{ $item->nome_investigador }}</td>
                    @else
                        <td>{{ $item->nome_tecnico ?? 'Ainda não atribuido' }}</td>
                    @endif
                </tr>
            @empty
                <td colspan="7">Não tem dados</td>
            @endforelse
        </tbody>
    </table>

</div>

@section('script')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-modal', () => {
                const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                modal.show();
            })
        });
    </script>
@endsection
