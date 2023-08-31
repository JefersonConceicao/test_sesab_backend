<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\PerfisController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'users'], function(){
    Route::GET('/', [UsersController::class, 'index'])->name('users.index');
    Route::GET('/detalhes/{user}', [UsersController::class, 'show'])->name('users.detalhes');
    Route::POST('/save', [UsersController::class, 'store'])->name('users.save');
    Route::PUT('/update/{user}', [UsersController::class, 'update'])->name('users.update');

    Route::POST('/adicionarEndereco/{user}', [UsersController::class, 'adicionarEndereco'])->name('users.adicionarEndereco');
    Route::DELETE('/removerEndereco/{user}/{endereco}', [UsersController::class, 'removerEndereco'])->name('users.removerEndereco');
    Route::DELETE('/excluir/{user}', [UsersController::class, 'excluirUsuario'])->name('users.excluirUsuario');
});

Route::group(['prefix' => 'perfis'], function(){
    Route::GET('/list', [PerfisController::class, 'listPerfis'])->name('perfis.list');
});

