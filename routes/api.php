<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PosApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['auth', 'verified'])->prefix('api/client')->name('api.client.')->group(function ()  {
    
     // Búsqueda de productos
    Route::get('/products', [PosApiController::class, 'searchProductsB2B'])->name('products.search');
    
    // Gestión del carrito
    Route::post('/cart/add', [PosApiController::class, 'addToCartB2B'])->name('cart.add');
    Route::get('/cart', [PosApiController::class, 'getCartB2B'])->name('cart.get');
    Route::put('/cart/update', [PosApiController::class, 'updateCartItemB2B'])->name('cart.update');
    Route::delete('/cart/remove', [PosApiController::class, 'removeCartItemB2B'])->name('cart.remove');
    Route::delete('/cart/clear', [PosApiController::class, 'clearCartB2B'])->name('cart.clear');
    
    // Pedidos
    Route::post('/pedidos', [PosApiController::class, 'storePedidoB2B'])->name('pedidos.store');
    Route::get('/pedidos', [PosApiController::class, 'listPedidosB2B'])->name('pedidos.list');

});