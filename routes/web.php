<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController; 
use App\Http\Controllers\PosApiController;

use App\Http\Controllers\ReceiptController;
use App\Http\Middleware\CheckClientAccess; 

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Landing Page)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Ruta para acceso denegado (cuando el middleware lo redirige)
Route::get('/acceso-denegado', function () {
    return view('acceso-denegado'); 
})->name('acceso-denegado');

// Ruta para imprimir recibos/pedidos (reutilizada del POS)
Route::get('sales/{sale}/receipt', [ReceiptController::class, 'print'])->name('sales.receipt.print');


Route::get('/registro-exitoso', function () {
    return view('registered');
})->name('registered')->middleware('guest');

/*
|--------------------------------------------------------------------------
| Portal de Clientes B2B (Rutas Protegidas)
|--------------------------------------------------------------------------
| Requiere autenticación y el permiso 'has_pos_access' (B2B Access Check).
*/
Route::middleware([
    'auth', // CORRECCIÓN CLAVE: Usamos 'auth' en lugar de 'auth:sanctum'
    config('jetstream.auth_session'),
    'verified',
    CheckClientAccess::class, // Tu middleware que verifica el permiso B2B
])->group(function () {
    
    // Dashboard principal del cliente
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');

    // Módulos del portal de clientes
    Route::prefix('pos')->name('pos.')->group(function () {
        
        // Catálogo de Productos
        Route::get('/', [ClientController::class, 'index'])->name('index');

        //web POs anterior 
        // Route::get('/', [PosController::class, 'index'])->name('index');
        Route::get('/sales', [ClientController::class, 'salesList'])->name('sales.list');
        Route::get('/accounts-receivable', [ClientController::class, 'accountsReceivable'])->name('accounts.receivable');
        Route::get('/accounts-receivable/{client}', [ClientController::class, 'clientStatement'])->name('accounts.client.statement');
        // Nuevas rutas para el cierre
        Route::get('/close-cash-register', [ClientController::class, 'showCloseCashRegisterForm'])->name('close_cash_register.form');
        Route::post('/close-cash-register', [ClientController::class, 'closeCashRegister'])->name('close_cash_register.store');
        Route::post('/pos/expense', [ClientController::class, 'storeExpense'])->name('store.expense');
    });

});
