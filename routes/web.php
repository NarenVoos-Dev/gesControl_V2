<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController; 
use App\Http\Controllers\ReceiptController;
use App\Http\Middleware\CheckPosAccess; 

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
    CheckPosAccess::class, // Tu middleware que verifica el permiso B2B
])->group(function () {
    
    // Dashboard principal del cliente
    Route::get('/dashboard', [ClientController::class, 'dashboard'])->name('dashboard');

    // Módulos del portal de clientes
    Route::prefix('portal')->name('portal.')->group(function () {
        
        // Catálogo de Productos
        Route::get('catalogo', [ClientController::class, 'showCatalog'])->name('catalogo');
        
        // Historial de Pedidos
        Route::get('pedidos', [ClientController::class, 'showOrders'])->name('pedidos');
        
        // Cuentas por Cobrar
        Route::get('cuentas-por-cobrar', [ClientController::class, 'showAccountsReceivable'])->name('cuentas-por-cobrar');
    });

});
