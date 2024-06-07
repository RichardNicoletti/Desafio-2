<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CadastroController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cadastro', [CadastroController::class, 'create'])->name('cadastro.create');
Route::post('/cadastro', [CadastroController::class, 'store'])->name('cadastro.store');
Route::get('/cadastro/{id}/edit', [CadastroController::class, 'edit'])->name('cadastro.edit');
Route::post('/cadastro/{id}/update', [CadastroController::class, 'update'])->name('cadastro.update');
Route::get('/cadastro/{id}/delete', [CadastroController::class, 'delete'])->name('cadastro.delete');
Route::get('/cadastro/search', [CadastroController::class, 'search'])->name('cadastro.search');


Route::get('/cep/{cep}', [CadastroController::class, 'buscarCep']);