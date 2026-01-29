@section('titulo')
    Rever Projeto
@endsection
<div>
    <x-breadcrumb layer1="Projetos" layer2="Criar Projetos" layer1route="projetos" />
    <div class="card">
        <div class="card-body">
            <x-alertas />
            <div class="col-md-8 mb-3">
                <label class="form-label">Nome Projeto:</label>
                <input type="text" class="form-control @error('nomeProjeto') is-invalid @enderror"
                    id="validationCustom01" wire:model="nomeProjeto" placeholder="Escreva o nome do projeto" required
                    @if ($rever == false) disabled @endif>
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
                    wire:model="sumario" @if ($rever == false) disabled @endif></textarea>
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
                    placeholder="Escreva o orçamento do projeto" required
                    @if ($rever == false) disabled @endif>
                @error('orcamento')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo Projeto:</label>
                    <select class="form-select @error('TipoProjeto') is-invalid @enderror" id="validationDefault04"
                        wire:model="TipoProjeto" required @if ($rever == false) disabled @endif>
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
                    <select class="form-select  @error('Financiamento') is-invalid @enderror" id="validationDefault04"
                        wire:model="Financiamento" required @if ($rever == false) disabled @endif>
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
                    id="invalidCheck" @if ($rever == false) disabled @endif>
                <label class="form-check-label" for="invalidCheck">
                    Entidades Externas
                </label>
            </div>

            <hr>
            <h4>Anexos do Projeto:</h4>
            @forelse ($anexos as $item)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <strong>Nome do anexo:</strong>
                                {{ $item->nome_anexo }}
                            </div>

                            <div class="col-md-6">
                                <strong>Data:</strong>
                                {{ \Carbon\Carbon::parse($item->data)->format('d/m/Y H:i') }}
                            </div>

                            <div class="col-md-6 mt-2">
                                <strong>Utilizador:</strong>
                                {{ $item->nome_user }}
                            </div>

                            <div class="col-md-6 mt-2">
                                <strong>Ficheiro:</strong>
                                <a href="{{ route('ficheiro', ['id' => $item->id]) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    Ver / Download
                                </a>
                            </div>

                            @if ($rever == true)
                                <div class="col-md-6 mt-2">
                                    <a wire:click="apagarFicheiro({{ $item->id }})"
                                        class="btn btn-sm btn-outline-danger"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="16" height="16" fill="currentColor" class="bi bi-trash3"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                        </svg> Apagar</a>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-secondary">
                    Este projeto não tem anexos.
                </div>
            @endforelse

            <hr>

            <h4>Equipa pertencente ao Projeto:</h4>
            <div class="row">
                @if ($rever == false)
                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button type="button" class="btn btn-primary" wire:click="setRever">
                            Editar
                        </button>
                        <button type="button" class="btn btn-success" wire:click="enviarProjeto">
                            Enviar para Avaliação
                        </button>
                    </div>
                @endif
            </div>

            @if ($rever == true)
                <div style="overflow:auto;">
                    <div style="float:right">
                        <button type="submit" class="btn btn-success" wire:loading.attr="disabled" wire:click="enviar"
                            wire:target="anexo, documento">
                            Enviar para Avaliação
                        </button>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
