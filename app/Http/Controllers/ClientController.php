<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sale; // Reutilizaremos este modelo para 'Pedidos'
use App\Models\Client; // Modelo para obtener detalles del cliente

class ClientController extends Controller
{
    /**
     * Muestra el Dashboard principal del Portal de Clientes.
     * Mapea a la ruta /dashboard.
     */
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        // Asumimos que el usuario autenticado (User) tiene una relación 'business'
        // y que el 'business' tiene una relación con la tabla 'clients' (o es el cliente mismo).
        $client = Client::where('document', $user->document)->first(); // Ejemplo de cómo buscar el cliente
        
        // Lógica de datos simulados para un MVP:
        $latestOrders = Sale::where('client_id', $client->id ?? 0)
                             ->latest('date')
                             ->take(5)
                             ->get();

        return view('client.dashboard', [
            'user' => $user,
            'client' => $client,
            'latestOrders' => $latestOrders,
        ]);
    }

    /**
     * Muestra el Catálogo de Productos B2B (Anteriormente pos.index).
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showCatalog(Request $request)
    {
        // NOTA: Esta lógica requerirá ser expandida, pero por ahora solo muestra la vista.
        return view('client.catalogo'); 
    }
    
    /**
     * Muestra el Historial de Pedidos del cliente (Anteriormente pos.sales.list).
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showOrders(Request $request)
    {
        // Muestra el historial de pedidos del cliente logueado
        return view('client.pedidos'); 
    }

    /**
     * Muestra las Cuentas por Cobrar (Anteriormente pos.accounts.receivable)
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function showAccountsReceivable(Request $request)
    {
        return view('client.accounts-receivable');
    }
}
