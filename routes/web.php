<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/', [IndexController::class, 'index']);

Route::post('/update-mes-atual', [IndexController::class, 'updateMesAtual']);
Route::post('/contas/salvar', [IndexController::class, 'salvarContas']);

Route::post('/movimentacao/{id}/status', [App\Http\Controllers\MovimentacaoController::class, 'updateStatus']);
Route::post('/movimentacao/{id}/editar', [App\Http\Controllers\MovimentacaoController::class, 'editar']);
Route::post('/movimentacao/{id}/cartao', [App\Http\Controllers\MovimentacaoController::class, 'updateCartao']);
Route::post('/movimentacao/{id}/itau', [App\Http\Controllers\MovimentacaoController::class, 'updateItau']);
Route::post('/movimentacao/{id}/nb', [App\Http\Controllers\MovimentacaoController::class, 'updateNb']);
Route::delete('/movimentacao/{id}', [App\Http\Controllers\MovimentacaoController::class, 'deleteMovimentacao']);
Route::get('/movimentacao/notion', [App\Http\Controllers\MovimentacaoController::class, 'notion']);
Route::get('/movimentacao/fechar_mes/{mes}', [App\Http\Controllers\MovimentacaoController::class, 'fecharMes']);

Route::get('exportar', [App\Http\Controllers\ExportarController::class, 'exportar']);

Route::get('/teste', function () {
    return view('teste');
});
