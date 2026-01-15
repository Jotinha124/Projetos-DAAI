@section('titulo')
    Criar Utilizadores
@endsection
<div>
    <x-breadcrumb layer1="Utilizadores" layer2="Criar Utilizadores" layer1route="utilizadores" />

    <div class="card">
        <div class="card-body">
            <form wire:submit="criarUtilizador">
                <h4>Criar Utilizador:</h4>
                <div class="col-md-8 mb-3">
                    <label class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="validationCustom01" placeholder="Escreva o nome" required>
                    @error('nome')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-8 mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" wire:model="email"
                        placeholder="teste@gmail.pt">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <input class="form-check-input" type="checkbox" value="" wire:model="admin" id="invalidCheck">
                    <label class="form-check-label" for="invalidCheck">
                        Administrador
                    </label>
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label">Tipo Utilizador:</label>
                    <select class="form-select" id="validationDefault04" wire:model="TipoUtilizador" required>
                        <option selected value="">Escolha uma opção...</option>
                        @forelse($tipos_utilizador as $item)
                            <option value="{{ $item->id }}">{{ $item->tipo_utilizador }}</option>
                        @empty
                        @endforelse
                    </select>
                    @error('TipoUtilizador')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Inserir</button>
                </div>
            </form>
        </div>
    </div>
</div>
