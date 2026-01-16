<div>
    @if (session()->has('mensagem_erro'))
        <div>
            <div class="alert alert-danger" role="alert">
                {{ session('mensagem_erro') }}
            </div>
        </div>
    @endif
        @if (session()->has('mensagem'))
        <div>
            <div class="alert alert-success" role="alert">
                {{ session('mensagem') }}
            </div>
        </div>
    @endif
</div>
