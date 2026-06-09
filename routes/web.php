<?php

/*
|--------------------------------------------------------------------------
| Eu, João Victor, estou criando essa atividade de Cooperativa Agropecuária para a aula de PWIII.
| Este arquivo define as rotas da aplicação, mapeando as URLs para o CooperativaController.
|
| COMENTÁRIO TÉCNICO: Substituímos o retorno direto de views (Route::view) por chamadas de métodos 
| do Controller (CooperativaController::class). Isso segue o padrão MVC do Laravel, permitindo 
| injetar os dados vindos do banco de dados antes da renderização das telas. Incluímos as rotas
| RESTful para edição, atualização e exclusão física para fechar o ciclo do CRUD.
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\CooperativaController;
use Illuminate\Support\Facades\Route;

// Rotas principais mapeadas para as funções do Controller
Route::get('/', [CooperativaController::class, 'home'])->name('coop.home');
Route::get('/operacoes', [CooperativaController::class, 'operation'])->name('coop.operation');
Route::get('/mercado', [CooperativaController::class, 'stock'])->name('coop.stock');
Route::get('/relatorio', [CooperativaController::class, 'report'])->name('coop.report');

// Rota POST para processar e gravar os dados do formulário de safras
Route::post('/relatorio', [CooperativaController::class, 'storeReport'])->name('coop.storeReport');

// NOVAS ROTAS OPERACIONAIS: Implementação do ciclo Update e Delete do CRUD
Route::get('/operacoes/{id}/editar', [CooperativaController::class, 'edit'])->name('coop.edit');
Route::put('/operacoes/{id}', [CooperativaController::class, 'update'])->name('coop.update');
Route::delete('/operacoes/{id}', [CooperativaController::class, 'destroy'])->name('coop.destroy');

// Rota Fallback para capturar erros 404 e exibir a view personalizada
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});