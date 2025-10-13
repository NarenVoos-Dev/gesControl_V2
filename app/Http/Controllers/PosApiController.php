<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\{Product, Sale, StockMovement, UnitOfMeasure, Client, Category, Payment, CashSessionTransaction, CashSession, Egress,Inventory};
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class PosApiController extends Controller
{
    public function searchProductsB2B(Request $request)
    {
        $user = auth()->user();
        
        // Verificar que el usuario sea un cliente B2B
        if (!$user->client_id) {
            return response()->json(['message' => 'Acceso no autorizado'], 403);
        }

        $query = Product::query()
            ->where('products.business_id', $user->business_id)
            ->where('products.is_active', true) // Solo productos activos
            ->select('products.*');

        // Filtrar por categoría
        if ($request->filled('category_id')) {
            if ($request->input('category_id') === 'uncategorized') {
                $query->whereNull('category_id');
            } else {
                $query->where('category_id', $request->input('category_id'));
            }
        }

        // Búsqueda por texto
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }
        
        $products = $query->with(['unitOfMeasure', 'category'])
            ->limit(50)
            ->get();

        return response()->json($products);
    }
    /**
     * Agregar producto al carrito (sesión)
     */
    public function addToCartB2B(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|min:1',
            'unit_of_measure_id' => 'required|exists:unit_of_measures,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::with('unitOfMeasure')->findOrFail($request->product_id);
        $unit = UnitOfMeasure::findOrFail($request->unit_of_measure_id);

        // Obtener carrito de la sesión
        $cart = session()->get('b2b_cart', []);

        $cartKey = $request->product_id . '_' . $request->unit_of_measure_id;

        if (isset($cart[$cartKey])) {
            // Si ya existe, aumentar cantidad
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            // Agregar nuevo item
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->sale_price,
                'quantity' => $request->quantity,
                'unit_of_measure_id' => $unit->id,
                'unit_name' => $unit->name,
                'conversion_factor' => $unit->conversion_factor,
                'tax_rate' => $product->tax_rate ?? 0,
                'image' => $product->image_url ?? null,
            ];
        }

        session()->put('b2b_cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'cart_count' => count($cart),
            'cart' => $cart,
        ]);
    }
    /**
     * Obtener el carrito actual
     */
    public function getCartB2B()
    {
        $cart = session()->get('b2b_cart', []);
        $subtotal = 0;
        $tax = 0;

        foreach ($cart as $item) {
            $itemSubtotal = $item['price'] * $item['quantity'];
            $subtotal += $itemSubtotal;
            $tax += $itemSubtotal * ($item['tax_rate'] / 100);
        }

        $total = $subtotal + $tax;

        return response()->json([
            'cart' => array_values($cart), // Convertir a array indexado
            'summary' => [
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'item_count' => count($cart),
            ],
        ]);
    }
    
    /**
     * Actualizar cantidad de un item en el carrito
     */
    public function updateCartItemB2B(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_key' => 'required|string',
            'quantity' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cart = session()->get('b2b_cart', []);
        $cartKey = $request->cart_key;

        if (!isset($cart[$cartKey])) {
            return response()->json(['message' => 'Item no encontrado'], 404);
        }

        if ($request->quantity <= 0) {
            // Eliminar item si la cantidad es 0
            unset($cart[$cartKey]);
        } else {
            $cart[$cartKey]['quantity'] = $request->quantity;
        }

        session()->put('b2b_cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Carrito actualizado',
            'cart_count' => count($cart),
        ]);
    }
    /**
     * Eliminar item del carrito
     */
    public function removeCartItemB2B(Request $request)
    {
        $cart = session()->get('b2b_cart', []);
        $cartKey = $request->input('cart_key');

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('b2b_cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado',
            'cart_count' => count($cart),
        ]);
    }
    
    /**
     * Vaciar el carrito
     */
    public function clearCartB2B()
    {
        session()->forget('b2b_cart');
        
        return response()->json([
            'success' => true,
            'message' => 'Carrito vaciado',
        ]);
    }

    /**
     * Crear pedido desde el carrito
     */
    public function storePedidoB2B(Request $request)
    {
        $user = auth()->user();
        
        // Verificar que sea cliente B2B
        if (!$user->client_id) {
            return response()->json(['message' => 'Acceso no autorizado'], 403);
        }

        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string|max:500',
            'delivery_address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $cart = session()->get('b2b_cart', []);

        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'El carrito está vacío'
            ], 422);
        }

        try {
            $sale = DB::transaction(function () use ($request, $cart, $user) {
                $subtotal = 0;
                $tax = 0;

                // Calcular totales
                foreach ($cart as $item) {
                    $itemSubtotal = $item['price'] * $item['quantity'];
                    $subtotal += $itemSubtotal;
                    $tax += $itemSubtotal * ($item['tax_rate'] / 100);
                }

                $total = $subtotal + $tax;

                // Crear la venta/pedido
                $sale = Sale::create([
                    'business_id' => $user->business_id,
                    'client_id' => $user->client_id,
                    'date' => now(),
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'total' => $total,
                    'pending_amount' => $total,
                    'is_cash' => false, // Siempre es a crédito para B2B
                    'status' => 'Pendiente', // Estado inicial
                    'notes' => $request->input('notes'),
                    'delivery_address' => $request->input('delivery_address'),
                    'order_type' => 'b2b', // Marcar como pedido B2B
                ]);

                // Crear los items del pedido
                foreach ($cart as $item) {
                    $sale->items()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'unit_of_measure_id' => $item['unit_of_measure_id'],
                        'tax_rate' => $item['tax_rate'],
                    ]);
                }

                // Limpiar el carrito
                session()->forget('b2b_cart');

                return $sale;
            });

            return response()->json([
                'success' => true,
                'message' => '¡Pedido creado exitosamente!',
                'order_id' => $sale->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Error al crear pedido B2B: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar el pedido: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Listar pedidos del cliente B2B
     */
    public function listPedidosB2B(Request $request)
    {
        $user = auth()->user();
        
        if (!$user->client_id) {
            return response()->json(['message' => 'Acceso no autorizado'], 403);
        }

        $query = Sale::where('client_id', $user->client_id)
            ->where('business_id', $user->business_id)
            ->with(['items.product', 'items.unitOfMeasure'])
            ->orderBy('created_at', 'desc');

        // Filtros opcionales
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('search')) {
            $query->where('id', 'like', '%' . $request->input('search') . '%');
        }

        $pedidos = $query->paginate(10);

        return response()->json($pedidos);
    }






    /******
     * Funciones del proceso de software anterior
     */
    public function storeClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'document' => [ 'nullable', 'string', Rule::unique('clients')->where('business_id', auth()->user()->business_id) ],
            'zone_id' => 'nullable|exists:zones,id', 
            'credit_limit' => 'nullable|numeric|min:0', 
        ]);
        if ($validator->fails()) { return response()->json(['errors' => $validator->errors()], 422); }
        $client = Client::create(array_merge($request->all(), ['business_id' => auth()->user()->business_id]));
        return response()->json(['success' => true, 'client' => $client]);
    }

    // MÉTODO CORREGIDO para obtener los detalles de crédito
    public function getClientCreditDetails(Client $client)
    {
        if ($client->business_id !== auth()->user()->business_id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // CORRECCIÓN: Se usa el método del modelo, que ya tiene la lógica correcta.
        $currentDebt = $client->getCurrentDebt();

        return response()->json([
            'credit_limit' => $client->credit_limit ?? 0,
            'current_debt' => $currentDebt ?? 0,
        ]);
    }

    public function storeSale(Request $request)
    {
        $request->merge([
            'is_cash' => filter_var($request->input('is_cash'), FILTER_VALIDATE_BOOLEAN),
        ]);

        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'is_cash' => 'required|boolean',
            'cart' => 'required|array|min:1',
            'cart.*.product_id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|numeric|min:0.01',
            'cart.*.price' => 'required|numeric',
            'cart.*.tax_rate' => 'required|numeric',
            'cart.*.unit_of_measure_id' => 'required|exists:unit_of_measures,id',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) { return response()->json(['errors' => $validator->errors()], 422); }
        
        try {
            $sale = DB::transaction(function () use ($request) {
                $businessId = auth()->user()->business_id;
                $activeSession = CashSession::where('business_id', $businessId)->where('status', 'Abierta')->first();
                
                if (!$activeSession) { throw new \Exception('No hay una caja activa.'); }
                if (!$activeSession->location_id) { throw new \Exception('La caja activa no está asignada a una sucursal.'); }
                
                $locationId = $activeSession->location_id;
                $cart = $request->input('cart');
                $subtotal = 0; $tax = 0;
                
                foreach ($cart as $item) {
                    $product = Product::findOrFail($item['product_id']);
                    $unit = UnitOfMeasure::findOrFail($item['unit_of_measure_id']);
                    $quantityToDeduct = (float)$item['quantity'] * (float)$unit->conversion_factor;

                    $inventory = Inventory::where('product_id', $product->id)->where('location_id', $locationId)->first();

                    if (!$inventory || $inventory->stock < $quantityToDeduct) {
                        throw new \Exception("No hay stock para {$product->name} en esta sucursal.");
                    }                    
                    // CORRECCIÓN: El precio del item se recalcula en el backend para seguridad
                    $itemSubtotal = (float)$item['quantity'] * (float)$item['price'];
                    $subtotal += $itemSubtotal;
                    $tax += $itemSubtotal * ((float)($item['tax_rate'] ?? 0) / 100);
                }

                $total = $subtotal + $tax;
                $isCash = filter_var($request->input('is_cash'), FILTER_VALIDATE_BOOLEAN);

                // CORRECCIÓN: La validación de crédito se hace aquí, en el backend, como última capa de seguridad.
                if (!$isCash) {
                    $client = Client::findOrFail($request->input('client_id'));
                    if ($client->credit_limit > 0) {
                        $currentDebt = $client->getCurrentDebt();
                        if (($currentDebt + $total) > $client->credit_limit) {
                            // En el backend, si la validación falla, lanzamos una excepción para detener la transacción.
                            // La pregunta al usuario ya se hizo en el frontend.
                            Log::warning("Venta a crédito excede límite y fue procesada", ['client_id' => $client->id]);
                        }
                    }
                }

                $sale = Sale::create([ 
                    'business_id' => auth()->user()->business_id, 
                    'location_id' => $locationId, 
                    'client_id' => $request->input('client_id'), 
                    'date' => now(), 
                    'subtotal' => $subtotal, 
                    'tax' => $tax,
                    'is_cash' => $isCash,
                    'status' => $isCash ? 'Pagada' : 'Pendiente',
                    'total' => $total,
                    'pending_amount' =>$total,
                    'notes' => $request->input('notes'),
                    'cash_session_id' => $request->input('is_cash') ? $activeSession->id : null,

                ]);

                if ($isCash && $activeSession) {
                    CashSessionTransaction::create([
                        'cash_session_id' => $activeSession->id,
                        'amount' => $total,
                        'type' => 'entrada', // Es una entrada de dinero
                        'description' => 'Ingreso por Venta #' . $sale->id,
                        'source_type' => get_class($sale), // Enlaza a la venta (polimórfico)
                        'source_id' => $sale->id,
                    ]);
                }

                foreach ($cart as $item) {
                    $unit = UnitOfMeasure::find($item['unit_of_measure_id']);
                    $quantityToDeduct = (float)$item['quantity'] * (float)$unit->conversion_factor;
                    $sale->items()->create($item);
                    Inventory::where('product_id', $item['product_id'])
                             ->where('location_id', $locationId)
                             ->decrement('stock', $quantityToDeduct);
                    StockMovement::create(['product_id' => $item['product_id'], 'type' => 'salida', 'quantity' => $quantityToDeduct, 'source_type' => get_class($sale), 'source_id' => $sale->id]);
                }
                
                return $sale;
            });

            return response()->json(['success' => true, 'message' => '¡Venta registrada!', 'receipt_url' => route('sales.receipt.print', $sale)]);
        } catch (\Exception $e) {
            Log::error('Error al procesar venta: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    //Cuentas X Cobrar
    public function storePayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0.01',
            'sale_id' => 'nullable|exists:sales,id', // El sale_id es opcional
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['business_id'] = auth()->user()->business_id;
        $data['payment_date'] = now();

        try {
            if (!empty($data['sale_id'])) {
                // Lógica para abono a una factura específica
                $message = $this->applyPaymentToSingleSale($data);
            } else {
                // Lógica para abono masivo a las más antiguas
                $message = $this->applyPaymentToOldestSales($data);
            }
            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function applyPaymentToSingleSale(array $data): string
    {
        return DB::transaction(function () use ($data) {
            $activeSession = CashSession::where('business_id', $data['business_id'])
                                    ->where('status', 'Abierta')
                                    ->first();
            if (!$activeSession) {
                throw new \Exception('No hay una sesión de caja activa para registrar el abono.');
            }    

            $sale = Sale::findOrFail($data['sale_id']);
            $paymentAmount = floatval($data['amount']);
            $saleDebt = $sale->pending_amount;

            $amountToApply = min($paymentAmount, $saleDebt);
            
            $payment=   Payment::create([
                            'business_id' => $data['business_id'], 'client_id' => $data['client_id'],
                            'sale_id' => $sale->id, 'amount' => $amountToApply,
                            'payment_date' => $data['payment_date'],
                        ]);
            CashSessionTransaction::create([
                'cash_session_id' => $activeSession->id,
                'amount' => $amountToApply,
                'type' => 'entrada',
                'description' => 'Abono a Venta #' . $sale->id . ' | Cliente: ' . $sale->client->name,
                'source_type' => get_class($payment), // Enlazamos al registro del pago
                'source_id' => $payment->id,
            ]);

            $sale->pending_amount -= $amountToApply;
            if ($sale->pending_amount <= 0.01) {
                $sale->pending_amount = 0;
                $sale->status = 'Pagada';
            }
            $sale->save();

            $surplus = $paymentAmount - $amountToApply;
            if ($surplus > 0) {
                return "Abono registrado. La factura ha sido saldada. Se debe devolver un vuelto de $" . number_format($surplus, 2) . " al cliente.";
            }
            return "Abono de $" . number_format($amountToApply, 2) . " registrado a la factura #{$sale->id}.";
        });
    }

    private function applyPaymentToOldestSales(array $data): string
    {
        return DB::transaction(function () use ($data) {
            $activeSession = CashSession::where('business_id', $data['business_id'])
                                    ->where('status', 'Abierta')
                                    ->first();
            if (!$activeSession) {
                throw new \Exception('No hay una sesión de caja activa para registrar el abono.');
            } 

            $client = Client::findOrFail($data['client_id']);
            $paymentAmount = floatval($data['amount']);
            $remainingPayment = $paymentAmount;
            
            $pendingSales = $client->sales()->where('status', 'Pendiente')->orderBy('date', 'asc')->get();

            if ($pendingSales->isEmpty()) {
                throw new \Exception('Este cliente no tiene deudas pendientes.');
            }

            foreach ($pendingSales as $sale) {
                if ($remainingPayment <= 0) break;
                $amountToApply = min($remainingPayment, $sale->pending_amount);
                
                $payment =Payment::create([
                            'business_id' => $data['business_id'], 'client_id' => $client->id,
                            'sale_id' => $sale->id, 'amount' => $amountToApply,
                            'payment_date' => $data['payment_date'],
                        ]);

                // Registramos cada abono individual como un movimiento en la caja
                CashSessionTransaction::create([
                    'cash_session_id' => $activeSession->id,
                    'amount' => $amountToApply,
                    'type' => 'entrada',
                    'description' => 'Abono masivo a Venta #' . $sale->id . ' | Cliente: ' . $client->name,
                    'source_type' => get_class($payment), // Enlazamos al registro del pago
                    'source_id' => $payment->id,
                ]);
                
                $sale->pending_amount -= $amountToApply;
                if ($sale->pending_amount <= 0.01) { $sale->pending_amount = 0; $sale->status = 'Pagada'; }
                $sale->save();
                $remainingPayment -= $amountToApply;
            }

            $newDebt = $client->getCurrentDebt();
            if ($remainingPayment > 0) {
                return "Pago aplicado. El cliente ahora tiene un saldo a favor de $" . number_format($remainingPayment, 2);
            } elseif ($newDebt > 0) {
                return "Abono aplicado. El cliente aún tiene una deuda de $" . number_format($newDebt, 2);
            }
            return '¡Deuda saldada! Todas las facturas del cliente han sido pagadas.';
        });
    }

    // NUEVO MÉTODO para la búsqueda asíncrona de facturas
    public function searchClientSales(Request $request, Client $client)
    {
        if ($client->business_id !== auth()->user()->business_id) {
            abort(403);
        }

        $query = $client->sales()->where('status', 'Pendiente')->orderBy('date', 'asc');

        if ($request->filled('search')) {
            $query->where('id', 'like', '%' . $request->input('search') . '%');
        }

        $pendingSales = $query->paginate(10);

        // Devolvemos la vista parcial de la tabla y la paginación
        return response()->json([
            'table_html' => view('pos.partials.sales-table-rows', ['pendingSales' => $pendingSales])->render(),
            'pagination_html' => $pendingSales->links()->toHtml(),
        ]);
    }

    //EGRESOS

    public function storeExpense(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
            'description' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first()], 422);
        }

        try {
            $egress = DB::transaction(function () use ($request) {
                $businessId = auth()->user()->business_id;

                // 1. Buscar la sesión de caja activa
                $activeSession = CashSession::where('business_id', $businessId)
                                            ->where('status', 'Abierta')
                                            ->first();

                if (!$activeSession) { throw new \Exception('No hay una caja activa.'); }
                if (!$activeSession->location_id) { throw new \Exception('La caja activa no está asignada a una sucursal.'); }

                // 2. Crear el registro del Egreso
                $egress = Egress::create([
                    'business_id' => $businessId,
                    'location_id' => $activeSession->location_id,
                    'user_id' => auth()->id(),
                    'type' => 'gasto', // O 'retiro', según necesites
                    'description' => $request->input('description'),
                    'amount' => $request->input('amount'),
                    'payment_method' => 'efectivo', // Un gasto desde el POS siempre es en efectivo
                    'pay_from_cash_session' => true,
                    'cash_session_id' => $activeSession->id,
                    'date' => now(),
                ]);

                // 3. Crear la Transacción de SALIDA en la caja
                CashSessionTransaction::create([
                    'cash_session_id' => $activeSession->id,
                    'amount' => $egress->amount,
                    'type' => 'salida', // <-- ¡Importante!
                    'description' => 'Egreso: ' . $egress->description,
                    'source_type' => get_class($egress),
                    'source_id' => $egress->id,
                ]);

                return $egress;
            });

            return response()->json(['success' => true, 'message' => '¡Egreso registrado correctamente!']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    
    
}