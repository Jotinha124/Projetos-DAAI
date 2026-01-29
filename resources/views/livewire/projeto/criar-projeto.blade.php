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
            <form wire:submit="criarProjeto">
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

                    <div style="overflow:auto;">
                        <div style="float:right;">

                            <button type="button" class="btn btn-secondary" wire:click="previous">
                                Anterior
                            </button>

                            <button type="submit" class="btn btn-success" wire:loading.attr="disabled"
                                wire:target="anexo, documento">
                                Propor Projeto
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
