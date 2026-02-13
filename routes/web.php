<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Projeto\ComentarProjeto;
use App\Http\Livewire\Projeto\CriarProjeto;
use App\Http\Livewire\Projeto\MeuProjeto;
use App\Http\Livewire\Projeto\ReverProjeto;
use App\Http\Livewire\Projeto\VerificarProjeto;
use App\Http\Livewire\Projeto\VerProjeto;
use App\Http\Livewire\Utilizador\CriarUtilizadores;
use App\Http\Livewire\Utilizador\EditarUtilizadores;
use App\Http\Livewire\Utilizador\VerUtilizadores;
use App\Models\Anexo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', [LoginController::class, 'index']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login');

//ROTAS LOGOUT
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/ficheiro/{id}', function ($id) {
    $anexo = Anexo::findOrFail($id);

    $caminho = $anexo->anexo;

    if (!Storage::disk('projetos')->exists($caminho)) {
        abort(404, 'Arquivo não encontrado');
    }

    $conteudo = Storage::disk('projetos')->get($caminho);

    $tipo = Storage::disk('projetos')->mimeType($caminho);

    return response($conteudo, 200)
        ->header('Content-Type', $tipo);
})->name('ficheiro');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    //ROTAS PROJETOS
    Route::get('/projetos', VerProjeto::class)->name('projetos');
    Route::get('/projetos/rever/{id}', ReverProjeto::class)->name('projetos.rever');
    Route::get('/projetos/ver/{id}', MeuProjeto::class)->name('projetos.ver');
    Route::get('/projetos/criar', CriarProjeto::class)->name('projetos.criar');
    Route::get('/projetos/editar/{id}', CriarProjeto::class)->name('projetos.editar');
    Route::get('/projetos/verificar/{id}', VerificarProjeto::class)->name('projetos.verificar');
    Route::get('/projetos/comentar/{id}', ComentarProjeto::class)->name('projetos.comentar');

    //ROTAS UTILIZADORES
    Route::get('/utilizadores', VerUtilizadores::class)->name('utilizadores');
    Route::get('/utilizadores/criar', CriarUtilizadores::class)->name('utilizadores.criar');
    Route::get('/utilizadores/editar/{id}', EditarUtilizadores::class)->name('utilizadores.editar');

    
});
