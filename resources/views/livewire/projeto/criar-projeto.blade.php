@section('titulo')
    Criar Projetos
@endsection
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/css/form.css') }}" type="text/css" />
@endsection
<div>
    <x-breadcrumb layer1="Projetos" layer2="Criar Projetos" layer1route="projetos" />
    <div class="card">
        <div class="card-body">
            <x-alertas />
            <form wire:submit="criarProjeto" enctype="multipart/form-data">
                <h4>Criar Projeto:</h4>
                {{-- PASSO 1 --}}
                @if ($passo === 1)
                    <h6>Dados iniciais projeto:</h6>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Nome Projeto:</label>
                        <input type="text" class="form-control @error('nomeProjeto') is-invalid @enderror"
                            id="validationCustom01" wire:model="nomeProjeto" placeholder="Escreva o nome do projeto"
                            required>
                        @error('nomeProjeto')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Sumario:</label>
                        <textarea name="sumario" id="sumario" cols="30" rows="5"
                            class="form-control @error('sumario') is-invalid @enderror" placeholder="Escreva o sumario do projeto"
                            wire:model="sumario"></textarea>
                        @error('sumario')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">Orçamento Projeto:</label>
                        <input type="number" class="form-control @error('orcamento') is-invalid @enderror"
                            id="validationCustom01" wire:model="orcamento"min="1" step="0.01"
                            placeholder="Escreva o orçamento do projeto" required>
                        @error('orcamento')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipo Projeto:</label>
                            <select class="form-select @error('TipoProjeto') is-invalid @enderror"
                                id="validationDefault04" wire:model="TipoProjeto" required>
                                <option selected value="">Escolha uma opção...</option>
                                @forelse($tipos_projeto as $item)
                                    <option value="{{ $item->id }}">{{ $item->tipoprojeto }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('TipoProjeto')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Financiamento:</label>
                            <select class="form-select @error('Financiamento') is-invalid @enderror"
                                id="validationDefault04" wire:model="Financiamento" required>
                                <option selected value="">Escolha uma opção...</option>
                                @forelse($financiamento as $item)
                                    <option value="{{ $item->id }}">{{ $item->financiamento }}</option>
                                @empty
                                @endforelse
                            </select>
                            @error('Financiamento')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input class="form-check-input" type="checkbox" value="" wire:model="entidadesexternas"
                            id="invalidCheck">
                        <label class="form-check-label" for="invalidCheck">
                            Entidades Externas
                        </label>
                    </div>
                    <div style="overflow:auto;">
                        <div style="float:right;">
                            <button type="button" class="btn btn-primary" wire:click="next">
                                Seguinte
                            </button>
                        </div>
                    </div>
                    </button>
                @endif

                {{-- PASSO 2 --}}
                @if ($passo === 2)
                    <h6>Adicionar Anexos:</h6>

                    <div class="col-md-3 mb-3">
                        <small class="text-danger">*Pode selecionar mais que um ficheiro</small><br>
                        <label for="formFile" class="form-label">Anexos</label>
                        <input class="form-control @error('anexo')  is-invalid @enderror" type="file"
                            id="formFileMultiple" wire:model="anexo" multiple>
                        @error('anexo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <span wire:loading wire:target="anexo, documento" class="text-danger">
                        A carregar ficheiros...
                    </span>
                    <div style="overflow:auto;">
                        <div style="float:right;">
                            <button type="button" class="btn btn-secondary" wire:click="previous">
                                Anterior
                            </button>

                            <button type="button" class="btn btn-primary" wire:click="next">
                                Seguinte
                            </button>
                        </div>
                    </div>
                @endif

                {{-- PASSO 3 --}}
                @if ($passo === 3)
                    <h6>Equipa do Projeto</h6>
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Investigador:</label>
                                <div class="input-group mb-3">
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Escreva o email do investigador" wire:model.live="email">
                                    <button class="btn btn-outline-secondary" wire:click="searchEmail" type="button"
                                        id="button-addon2">Pesquisar</button>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-3">
                                @if ($pesquisou)
                                    {{-- CASO 1: Encontrou investigadores --}}
                                    @if ($investigadores->count())
                                        @foreach ($investigadores as $item)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    wire:click="addEquipa('{{ Crypt::encrypt($item->id) }}')"
                                                    @if (collect($equipa)->pluck('email')->contains($item->email)) checked @endif>
                                                {{ $item->nome }} ({{ $item->email }})
                                            </div>
                                        @endforeach

                                        {{-- CASO 2: Não encontrou --}}
                                    @else
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Nome Utilizador:</label>
                                            <input type="text"
                                                class="form-control @error('nomeUtilizador') is-invalid @enderror"
                                                wire:model="nomeUtilizador" placeholder="Nome do investigador">
                                        </div>
                                        @error('nomeUtilizador')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Email:</label>
                                            <input type="text" class="form-control bg-light"
                                                wire:model="emailInvestigador" readonly>
                                        </div>

                                        <a class="btn btn-primary" wire:click="addInvestigador">
                                            Adicionar Investigador
                                        </a>
                                    @endif
                                @endif

                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card shadow-sm border-0 rounded-4">
                                <div class="card-body">
                                    <h6 class="fw-bold mb-3">
                                        <i class="bi bi-people-fill text-primary me-2"></i>
                                        Equipa do Projeto
                                    </h6>

                                    @forelse($equipa as $item)
                                        <div
                                            class="d-flex justify-content-between align-items-center border rounded-3 p-3 mb-2 bg-light">

                                            <div>
                                                <div class="fw-semibold">
                                                    {{ $item['nome'] }}
                                                </div>
                                                <small class="text-muted">
                                                    {{ $item['email'] }}
                                                </small>
                                            </div>

                                            <button class="btn btn-sm btn-outline-danger rounded-pill"
                                                wire:click="removerMembro({{ Crypt::encrypt($item['id']) }})"
                                                type="button">
                                                Remover
                                            </button>

                                        </div>
                                    @empty
                                        <div class="text-center text-muted py-4">
                                            <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                            Sem membros na equipa.
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                        </div>
                    </div>
                    <div style="overflow:auto;">
                        <div style="float:right;">

                            <button type="button" class="btn btn-secondary" wire:click="previous">
                                Anterior
                            </button>

                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                                wire:target="addInvestigador">

                                <span wire:loading.remove wire:target="addInvestigador">
                                    Propor Projeto
                                </span>

                                <span wire:loading wire:target="addInvestigador">
                                    Aguarde...
                                </span>
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Circles which indicates the steps of the form: -->
                <div class="text-center mt-4">
                    <span class="step {{ $passo >= 1 ? 'active' : '' }}"></span>
                    <span class="step {{ $passo >= 2 ? 'active' : '' }}"></span>
                    <span class="step {{ $passo >= 3 ? 'active' : '' }}"></span>
                </div>


            </form>
        </div>
    </div>
</div>
@section('script')
    <script src="{{ URL::asset('build/js/form.js') }}"></script>
@endsection
