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
Route::post('/movimentacao/{id}/status', [App\Http\Controllers\MovimentacaoController::class, 'updateStatus']);
Route::delete('/movimentacao/{id}', [App\Http\Controllers\MovimentacaoController::class, 'deleteMovimentacao']);

Route::get('/notion', [App\Http\Controllers\MovimentacaoController::class, 'notion']);

Route::get('/teste', function () {
    return view('teste');
});
