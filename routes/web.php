<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Projeto\CriarProjeto;
use App\Http\Livewire\Projeto\VerProjeto;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login');

//ROTAS LOGOUT
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    //ROTAS PROJETOS
    Route::get('/projetos', VerProjeto::class)->name('projetos');
    Route::get('/projetos/criar', CriarProjeto::class)->name('projetos.criar');
    Route::get('/projetos/editar/{id}', CriarProjeto::class)->name('projetos.editar');
    
});
