<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Client;
use App\Models\UnitOfMeasure;
use App\Models\Sale;
use App\Models\Zone;
use App\Models\Product;
use App\Models\{CashSession, CashSessionTransaction,Location};
use Carbon\Carbon;

class ClientController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        
        // Simulación: Buscamos el objeto Client asociado al User logueado.
        // **IMPORTANTE**: Ajusta esta lógica para encontrar el Client real.
        $client = Client::find($user->client_id ?? 1); 

        // --- 1. Lógica de Métricas (KPIs) ---
        // Usaremos datos simulados ya que la conexión real requiere modelos de Pedido.
        
        $stats = [
            'total_pendientes' => 24,
            'total_facturados' => 18,
            'total_entregados' => 156,
            'gasto_total' => 2400000,
        ];
        
        // --- 2. Lógica de Gráfico (Simulada) ---
        $chartData = [
            'labels' => ['Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre', 'Enero'],
            'data' => [1800000, 2100000, 1950000, 2300000, 2150000, 2400000],
        ];

        // --- 3. Lógica de Últimos Pedidos (Simulada) ---
        // NOTA: En la realidad, esto sería $client->sales()->latest()->take(3)->get();
        $latestOrders = collect([
            (object)['id' => 101, 'date' => Carbon::parse('2024-01-15'), 'total' => 45200, 'status' => 'Entregado'],
            (object)['id' => 102, 'date' => Carbon::parse('2024-01-18'), 'total' => 32800, 'status' => 'Facturado'],
            (object)['id' => 103, 'date' => Carbon::parse('2024-01-22'), 'total' => 67500, 'status' => 'Pendiente'],
        ]);

        return view('client.dashboard', [
            'user' => $user,
            'client' => $client,
            'stats' => $stats,
            'chartData' => $chartData,
            'latestOrders' => $latestOrders,
        ]);
    }
    
    // Este método carga los datos iniciales y muestra la vista principal del POS.
    public function catalogo()
    {
        $user = auth()->user();
        $businessId = $user->business_id;
        // Solo pasamos los datos esenciales para la carga inicial
        $categories = Category::where('business_id', $user->business_id)->get(['id', 'name']);
        $hasUncategorized = Product::where('business_id', $businessId)->whereNull('category_id')->exists();
        if ($hasUncategorized) {
            $categories->push((object)['id' => 'uncategorized', 'name' => 'Sin Categoría']);
        }
        $units = UnitOfMeasure::where('business_id', $user->business_id)->get();

        return view('pos.index', compact('categories', 'units'));
    }

     // A partir de aquí, se agregarán los nuevos métodos para el carrito y los pedidos.
    // public function addToCart(Request $request) { ... }
    // public function viewCart() { ... }
    // public function storePedido(Request $request) { ... }
    // public function listPedidos() { ... }
}