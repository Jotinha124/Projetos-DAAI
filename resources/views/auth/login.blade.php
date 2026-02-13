@extends('layouts.app')

@section('titulo')
    Iniciar Sessão
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                
                <div class="card-header text-center bg-primary text-white">
                    <h4 class="mb-0">Iniciar Sessão</h4>
                </div>

                <div class="card-body p-4">
                    
                    <x-alertas />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input id="email" 
                                   type="email"
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email"
                                   value="{{ old('email') }}" 
                                   placeholder="exemplo@email.com"
                                   required 
                                   autocomplete="email" 
                                   autofocus>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Palavra-passe --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Palavra-passe</label>
                            <div class="input-group">
                                <input id="password" 
                                       type="password"
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password"
                                       placeholder="Introduza a sua palavra-passe"
                                       required 
                                       autocomplete="current-password">

                                <button class="btn btn-outline-secondary" 
                                        type="button" 
                                        onclick="togglePassword()">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>


                        {{-- Botões --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Entrar
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link text-center" 
                                   href="{{ route('password.request') }}">
                                    Esqueceu-se da palavra-passe?
                                </a>
                            @endif
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Script Mostrar/Ocultar Password --}}
<script>
function togglePassword() {
    const password = document.getElementById("password");
    password.type = password.type === "password" ? "text" : "password";
}
</script>

@endsection
