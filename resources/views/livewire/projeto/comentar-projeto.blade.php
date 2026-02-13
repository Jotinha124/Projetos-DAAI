@section('titulo')
    Comentar Projetos
@endsection
<div>
    <x-breadcrumb layer1="Projetos" layer2="Comentar Projeto" layer1route="projetos" />

    <x-alertas />

    <div class="card">
        <div class="card-body">
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

            <hr>

            <div class="row">
                <div class="col-md-7 mb-3">
                    <p class="mb-1 text-muted">Comentario:</p>
                    <textarea name="comentario" id="comentario" class="form-control" wire:model="comentario" cols="30" rows="4"></textarea>
                </div>
            </div>
            <div class="mb-4">
                <button type="submit" class="btn btn-primary w-10" wire:click="comentar">
                    Comentar
                </button>
            </div>

            Comentários:

            @forelse($comentarios as $item)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>{{ $item->nomeUtilizador ?? 'Anônimo' }}</strong>
                            </div>

                            <div class="col-md-6 text-end text-muted">
                                {{ $item->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <hr>

                        <p class="mb-0">
                            {{ $item->comentario }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning">
                    Nenhum comentário encontrado.
                </div>
            @endforelse

        </div>
    </div>
</div>
