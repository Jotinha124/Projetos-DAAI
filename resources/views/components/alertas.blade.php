<div>
    @if (session()->has('mensagem_erro'))
        <div>
            <div class="alert alert-danger" role="alert">
                {{ session('mensagem_erro') }}
            </div>
        </div>
    @endif
</div>
