<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
   
    public function redirectTo(Request $request): ?string
    {
        if (!Auth::check()) {
            session()->flash('erro', 'Acesso negado! Por favor, inicie sessão.');
        }

        return $request->expectsJson() ? null : route('login');
    }
}
