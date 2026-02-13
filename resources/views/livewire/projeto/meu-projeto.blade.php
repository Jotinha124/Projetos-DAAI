@section('titulo')
    Ver Projeto
@endsection
<div>
    <x-breadcrumb layer1="Projetos" layer2="Criar Projetos" layer1route="projetos" />
    <div class="card">
        <div class="card-body">
            <x-alertas />
            <ul class="nav nav-tabs mb-3" id="projetoTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="projetos-tab" data-bs-toggle="tab" href="#projetos" role="tab"
                        aria-controls="projetos" aria-selected="true">Projetos</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="anexos-tab" data-bs-toggle="tab" href="#anexos" role="tab"
                        aria-controls="anexos" aria-selected="false">Anexos</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="equipa-tab" data-bs-toggle="tab" href="#equipa" role="tab"
                        aria-controls="equipa" aria-selected="false">Equipa</a>
                </li>
                @if (Session::get('s_idTipoUtilizador') == env('TIPO_TECNICO'))
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="logs-tab" data-bs-toggle="tab" href="#logs" role="tab"
                            aria-controls="logs" aria-selected="false">Logs</a>
                    </li>
                @endif
            </ul>
            <div class="tab-content" id="projetoTabsContent">
                {{-- Projetos --}}
                <div class="tab-pane fade show active" id="projetos" role="tabpanel" aria-labelledby="projetos-tab">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Nome do Projeto</p>
                            <h5 class="fw-bold">{{ $nomeProjeto }}</h5>
                        </div>

                        <div class="col-md-6">
                            <p class="mb-1 text-muted">Orçamento</p>
                            <h5 class="fw-bold">{{ $orcamento }} €</h5>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <p class="mb-1 text-muted">Sumário</p>
                        <p class="fs-6">{{ $sumario }}</p>
                    </div>

                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <p class="mb-1 text-muted">Tipo de Projeto</p>
                            <span class="badge bg-primary fs-6">{{ $tipoProjeto }}</span>
                        </div>

                        <div class="col-md-4 mb-3">
                            <p class="mb-1 text-muted">Financiamento</p>
                            <span class="badge bg-success fs-6">{{ $Financiamento }}</span>
                        </div>

                        <div class="col-md-4 mb-3">
                            <p class="mb-1 text-muted">Entidades Externas</p>
                            <span class="badge {{ $entidadesExternas ? 'bg-warning text-dark' : 'bg-secondary' }} fs-6">
                                {{ $entidadesExternas ? 'Sim' : 'Não' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Anexos --}}
                <div class="tab-pane fade" id="anexos" role="tabpanel" aria-labelledby="anexos-tab">
                    <h4>Anexos do Projeto:</h4>
                    @forelse ($anexos as $item)
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6"><strong>Nome do anexo:</strong> {{ $item->nome_anexo }}</div>
                                    <div class="col-md-6"><strong>Data:</strong>
                                        {{ \Carbon\Carbon::parse($item->data)->format('d/m/Y H:i') }}</div>
                                    <div class="col-md-6 mt-2"><strong>Utilizador:</strong> {{ $item->nome_user }}</div>
                                    <div class="col-md-6 mt-2">
                                        <strong>Ficheiro:</strong>
                                        <a href="{{ route('ficheiro', ['id' => $item->id]) }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">Ver / Download</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-secondary">Este projeto não tem anexos.</div>
                    @endforelse
                </div>

                {{-- Equipa --}}
                <div class="tab-pane fade" id="equipa" role="tabpanel" aria-labelledby="equipa-tab">
                    <h4>Equipa pertencente ao Projeto:</h4>
                    @forelse($equipa as $item)
                        <div
                            class="d-flex justify-content-between align-items-center border rounded-3 p-3 mb-2 bg-light">
                            <div>
                                <div class="fw-semibold">{{ $item->nome_user }}</div>
                                <small class="text-muted">{{ $item->email_user }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                            Sem membros na equipa.
                        </div>
                    @endforelse
                </div>

                {{-- Logs --}}
                @if (Session::get('s_idTipoUtilizador') == env('TIPO_TECNICO'))
                    <div class="tab-pane fade" id="logs" role="tabpanel" aria-labelledby="logs-tab">
                        <div class="space-y-3">
                            @forelse($logs as $item)
                                <div
                                    class="border rounded-lg shadow-sm p-4 hover:shadow-md transition duration-200 bg-white">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="fw-semibold">{{ $item->logstatus ?? 'Log Sem Título' }}</span>
                                        <span class="text-muted">
                                            [{{ \Carbon\Carbon::parse($item->data)->format('d/m/Y') }}]
                                        </span>
                                    </div>
                                    <div class="text-dark">
                                        {{ $item->nome_user ?? 'Sem detalhes disponíveis.' }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted py-4 fst-italic">
                                    Não existem Logs
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
