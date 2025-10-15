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
    /* public function dashboard(Request $request)
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $client = Client::find($user->client_id);

        if (!$client) {
            abort(403, 'No tienes un cliente asociado');
        }

        // --- 1. Métricas (KPIs) ---
        $stats = [
            'total_pendientes' => $client->sales()->where('status', 'Pendiente')->count(),
            'total_facturados' => $client->sales()->where('status', 'Facturado')->count(),
            'total_entregados' => $client->sales()->where('status', 'Entregado')->count(),
            'gasto_total' => $client->sales()->sum('total'),
        ];
        
        // --- 2. Gráfico de últimos 6 meses ---
        $chartData = [
            'labels' => [],
            'data' => [],
        ];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $chartData['labels'][] = $month->format('M Y');
            $chartData['data'][] = $client->sales()
                ->whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->sum('total');
        }

        // --- 3. Últimos pedidos ---
        $latestOrders = $client->sales()
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('client.dashboard', [
            'user' => $user,
            'client' => $client,
            'stats' => $stats,
            'chartData' => $chartData,
            'latestOrders' => $latestOrders,
        ]);
    }*/
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

        return view('dashboard', [
            'user' => $user,
            'client' => $client,
            'stats' => $stats,
            'chartData' => $chartData,
            'latestOrders' => $latestOrders,
        ]);
    }

     /**
     * Vista del catálogo de productos para clientes B2B
     */
    public function catalogo()
    {
        $user = auth()->user();
        
        // Verificar que sea cliente B2B
        if (!$user->client_id) {
            abort(403, 'Acceso no autorizado');
        }

        $client = Client::findOrFail($user->client_id);
        $businessId = $user->business_id;

        // Obtener categorías
        $categories = Category::where('business_id', $businessId)->get(['id', 'name']);
        
        // Verificar si hay productos sin categoría
        $hasUncategorized = Product::where('business_id', $businessId)
            ->whereNull('category_id')
            ->exists();
            
        if ($hasUncategorized) {
            $categories->push((object)['id' => 'uncategorized', 'name' => 'Sin Categoría']);
        }

        // Unidades de medida
        $units = UnitOfMeasure::where('business_id', $businessId)->get();

        // Contador del carrito
        $cartCount = count(session()->get('b2b_cart', []));

        return view('client.catalogo', compact('categories', 'units', 'client', 'cartCount'));
    }

    /**
     * Vista del carrito de compras
     */
    public function viewCart()
    {
        $user = auth()->user();
        
        if (!$user->client_id) {
            abort(403, 'Acceso no autorizado');
        }

        $client = Client::findOrFail($user->client_id);
        $cart = session()->get('b2b_cart', []);

        return view('client.cart', compact('client', 'cart'));
    }
     /**
     * Vista de listado de pedidos
     */
    public function listPedidos()
    {
        $user = auth()->user();
        
        if (!$user->client_id) {
            abort(403, 'Acceso no autorizado');
        }

        $client = Client::findOrFail($user->client_id);

        return view('client.pedidos', compact('client'));
    }

     /**
     * Vista de detalle de un pedido específico
     */
    public function showPedido($id)
    {
        $user = auth()->user();
        
        if (!$user->client_id) {
            abort(403, 'Acceso no autorizado');
        }

        $sale = Sale::where('id', $id)
            ->where('client_id', $user->client_id)
            ->with(['items.product', 'items.unitOfMeasure'])
            ->firstOrFail();

        return view('client.pedido-detail', compact('sale'));
    }

     // A partir de aquí, se agregarán los nuevos métodos para el carrito y los pedidos.
    // public function addToCart(Request $request) { ... }
    // public function viewCart() { ... }
    // public function storePedido(Request $request) { ... }
    // public function listPedidos() { ... }
}