@section('titulo')
    Verificar Projetos
@endsection
<div>
    <x-breadcrumb layer1="Projetos" layer2="Verificar Projetos" layer1route="projetos" />

    <x-alertas />


    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p>
                        <span class="h4">Nome do Projeto:</span>
                        {{ $nomeProjeto }}
                    </p>
                </div>

                <div class="col-md-6">
                    <p>
                        <span class="h4">Orçamento:</span>
                        {{ $orcamento }} €
                    </p>
                </div>
            </div>

            <h4>Sumário:</h4>
            {{ $sumario }}

            <div class="row mb-3">
                <div class="col-md-4">
                    <p>
                        <span class="h4">Tipo Projeto:</span>
                        {{ $tipoProjeto }}
                    </p>
                </div>

                <div class="col-md-4">
                    <p>
                        <span class="h4">Financiamento:</span>
                        {{ $Financiamento }}
                    </p>
                </div>
                <div class="col-md-4">
                    <p>
                        <span class="h4">Entidades Externas:</span>
                        {{ $entidadesExternas ? 'Sim' : 'Não' }}
                    </p>
                </div>
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
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-secondary">
                    Este projeto não tem anexos.
                </div>
            @endforelse


            <div style="overflow:auto;">
                <div style="float:right">
                    <button type="submit" class="btn btn-success" wire:click="verificar">
                        Verificar Projeto
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
