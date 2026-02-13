@section('titulo')
    Ver Projetos
@endsection
<div>
    <x-breadcrumb layer1="Projetos" layer2="Ver Projetos" layer1route="projetos" />

    <x-alertas />

    <div wire:ignore.self class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <a type="button" class="btn btn-primary"
                        wire:click="addTecnico('{{ Crypt::encrypt($id) }}')">Atribuir</a>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="mudarEstado" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">
                        Projeto [{{ $NomeProjeto }}]
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($acao == 'iniciar')
                        <p>Deseja realmente iniciar o projeto?</p>
                        <button wire:click="iniciarProjeto('{{ Crypt::encrypt($id) }}')" class="btn btn-success">Sim,
                            iniciar</button>
                    @elseif($acao == 'reprovar')
                        <p>Deseja realmente reprovar o projeto?</p>
                        <button wire:click="reprovarProjeto('{{ Crypt::encrypt($id) }}')" class="btn btn-danger">Sim,
                            reprovar</button>
                    @elseif($acao == 'terminar')
                        <p>Deseja realmente terminar o projeto?</p>
                        <button wire:click="terminarProjeto('{{ Crypt::encrypt($id) }}')" class="btn btn-primary">Sim,
                            terminar</button>
                    @elseif($acao == 'cancelar')
                        <p>Deseja realmente cancelar o projeto?</p>
                        <button wire:click="cancelarProjeto('{{ Crypt::encrypt($id) }}')" class="btn btn-warning">Sim,
                            cancelar</button>
                    @endif
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
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear"></i> Ações
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end shadow">

                                {{-- ================= TÉCNICO ================= --}}
                                @if (Session::get('s_idTipoUtilizador') == env('TIPO_TECNICO'))
                                    @if ($item->verificado == 0 && $item->id_status == env('STATUS_ENVIADO_AUTORIZACAO'))
                                        <li>
                                            <a class="dropdown-item text-success"
                                                href="{{ route('projetos.verificar', ['id' => Crypt::encrypt($item->id)]) }}">
                                                <i class="bi bi-check-circle"></i> Autorizar
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    @endif

                                    @if ($item->id_tecnico_apoio == null)
                                        <li>
                                            <a class="dropdown-item text-success"
                                                wire:click="atribuirTecnico('{{ Crypt::encrypt($item->id) }}')">
                                                <i class="bi bi-person-plus"></i> Atribuir Técnico
                                            </a>
                                        </li>
                                    @endif

                                    @if ($item->id_status == env('STATUS_AUTORIZACAO'))
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <li>
                                            <a class="dropdown-item text-primary"
                                                wire:click="abrirModal('iniciar', '{{ Crypt::encrypt($item->id) }}')">
                                                <i class="bi bi-play-circle"></i> Iniciar
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item text-danger"
                                                wire:click="abrirModal('reprovar', '{{ Crypt::encrypt($item->id) }}')">
                                                <i class="bi bi-x-circle"></i> Reprovar
                                            </a>
                                        </li>
                                    @endif

                                    @if ($item->id_status == env('STATUS_INICIADO'))
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <li>
                                            <a class="dropdown-item text-warning"
                                                wire:click="abrirModal('terminar', '{{ Crypt::encrypt($item->id) }}')">
                                                <i class="bi bi-flag"></i> Terminar
                                            </a>
                                        </li>

                                        <li>
                                            <a class="dropdown-item text-danger"
                                                wire:click="abrirModal('cancelar', '{{ Crypt::encrypt($item->id) }}')">
                                                <i class="bi bi-slash-circle"></i> Cancelar
                                            </a>
                                        </li>
                                    @endif

                                    <li>
                                        <a class="dropdown-item text-primary"
                                            href="{{ route('projetos.comentar', ['id' => Crypt::encrypt($item->id)]) }}">
                                            <i class="bi bi-chat-dots"></i> Comentar
                                        </a>
                                    </li>

                                    {{-- ================= UTILIZADOR NORMAL ================= --}}
                                @else
                                    @if ($item->id_status == env('STATUS_DRAFT'))
                                        <li>
                                            <a class="dropdown-item text-primary"
                                                href="{{ route('projetos.rever', ['id' => Crypt::encrypt($item->id)]) }}">
                                                <i class="bi bi-pencil-square"></i> Editar
                                            </a>
                                        </li>
                                    @endif

                                    <li>
                                        <a class="dropdown-item text-danger"
                                            wire:click="abrirModal('cancelar', '{{ Crypt::encrypt($item->id) }}')">
                                            <i class="bi bi-slash-circle"></i> Cancelar
                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endif

                                {{-- ================= VER (COMUM A TODOS) ================= --}}
                                <li>
                                    <a class="dropdown-item text-secondary"
                                        href="{{ route('projetos.ver', ['id' => Crypt::encrypt($item->id)]) }}">
                                        <i class="bi bi-eye"></i> Ver
                                    </a>
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                                <path
                                    d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                <path
                                    d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z" />
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-dash-square" viewBox="0 0 16 16">
                                <path
                                    d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                            </svg>
                        @endif
                    </td>
                    <td>{{ $item->tipo_projeto }}</td>
                    <td>
                        @php
                            $statusColors = [
                                1 => 'secondary', // DRAFT
                                2 => 'info', // ENVIADO
                                3 => 'primary', // ENVIADO_AUTORIZACAO
                                4 => 'warning', // AUTORIZACAO
                                5 => 'primary', // INICIADO
                                6 => 'success', // TERMINADO
                                7 => 'danger', // REPROVADO
                                8 => 'dark', // CANCELADO
                            ];

                            $color = $statusColors[$item->id_status_projeto] ?? 'secondary';
                        @endphp

                        <span class="badge bg-{{ $color }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    @if (Session::get('s_idTipoUtilizador') == env('TIPO_TECNICO'))
                        <td>{{ $item->nome_investigador }}</td>
                    @else
                        <td>{{ $item->nome_tecnico ?? 'Ainda não atribuido' }}</td>
                    @endif
                </tr>
            @empty
                <td colspan="9">Não tem dados</td>
            @endforelse
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-1">
            <select class="form-select" aria-label="Selecione o número de resultados por página"
                wire:model.live="porPagina">
                <option value="10" selected>10</option>
                <option value="20">20</option>
                <option value="50">50</option>
            </select>
        </div>
        <div class="col-md-11">
            {{ $projetos->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@section('script')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-modal', () => {
                const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                modal.show();
            })

            Livewire.on('open-modal-mudar', () => {
                const modalMudar = new bootstrap.Modal(document.getElementById('mudarEstado'));
                modalMudar.show();
            })
        });
    </script>
@endsection
