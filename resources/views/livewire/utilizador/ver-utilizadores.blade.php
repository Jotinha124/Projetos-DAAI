@section('titulo')
    Ver Utilizadores
@endsection
<div>
    <x-breadcrumb layer1="Utilizadores" layer2="Ver Utilizadores" layer1route="utilizadores" />

    <a class="btn btn-primary" href="{{ route('utilizadores.criar') }}">Criar Utilizador</a>

    <table class="table">
        <thead>
            <td></td>
            <td>Nome</td>
            <td>Email</td>
            <td>Admin</td>
            <td>Tipo Utilizador</td>
        </thead>
        <tbody>
            @forelse ($Utilizadores as $item)
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Ações
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                    href="{{ route('utilizadores.editar', ['id' => $item->id]) }}">Editar</a></li>
                            <li><a class="dropdown-item" onclick="">Apagar</a></li>
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
            @empty
                <td colspan="4">Não tem dados</td>
            @endforelse
        </tbody>
    </table>

</div>
