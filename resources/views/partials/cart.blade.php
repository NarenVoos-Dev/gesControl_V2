<!-- Cart Panel -->
<div id="cartPanel" class="fixed right-0 top-0 w-full md:w-[450px] h-full bg-white/95 backdrop-blur-xl shadow-2xl translate-x-full transition-transform duration-400 z-[300]">
    
    <!-- HEADER DEL CARRITO (p-6 para buen espacio) -->
    <div class="p-6 border-b border-[#0f4db3]/10 flex justify-between items-center">
        <h3 class="text-2xl font-extrabold bg-gradient-to-r from-[#0f4db3] to-[#028dff] bg-clip-text text-transparent">Mi Carrito (3)</h3>
        <!-- Botón de Cerrar -->
        <button onclick="closeCart()" 
                class="w-10 h-10 rounded-full cursor-pointer text-gray-600 text-xl transition-all duration-300 flex items-center justify-center 
                       hover:bg-red-500 hover:text-white hover:scale-110 border border-gray-200 bg-white shadow-sm">&times;</button>
    </div>
    
    <!-- ITEMS DEL CARRITO (p-6) -->
    <div id="cartItems" class="p-6 max-h-[calc(100vh-350px)] overflow-y-auto space-y-4">
        <!-- Ejemplo de Item -->
        <div class="flex justify-between items-center border-b pb-3 border-gray-100">
            <div class="flex-1">
                <p class="font-medium text-gray-800">Paracetamol 500mg x 100 Und.</p>
                <p class="text-xs text-gray-500 mt-0.5">3 UND x $150.000</p>
            </div>
            <span class="font-semibold text-gray-900">$450.000</span>
        </div>
        <div class="flex justify-between items-center border-b pb-3 border-gray-100">
            <div class="flex-1">
                <p class="font-medium text-gray-800">Jeringa 5ml, caja x 50</p>
                <p class="text-xs text-gray-500 mt-0.5">2 CAJAS x $50.000</p>
            </div>
            <span class="font-semibold text-gray-900">$100.000</span>
        </div>
    </div>
    
    <!-- TOTALES Y BOTÓN DE PROCESAR -->
    <!-- Contenedor de totales ahora usa p-6 -->
    <div id="cartTotal" class="p-6 border-t-2 border-[#0f4db3]/10 bg-gray-50">
        
        <div class="p-4 bg-white rounded-lg shadow-inner space-y-2 mb-4">
            <div class="flex justify-between text-sm text-gray-700"><span>Subtotal:</span><span class="font-medium">$847.700</span></div>
            <div class="flex justify-between text-sm text-gray-700"><span>Descuento:</span><span class="font-medium text-red-500">-$42.385</span></div>
            <div class="flex justify-between text-sm text-gray-700"><span>IVA (19%):</span><span class="font-medium">$153.010</span></div>
        </div>
        
        <div class="flex justify-between text-2xl font-extrabold text-gray-900 pt-3 mb-5 border-t-2 border-[#0f4db3]/20">
            <span>Total Final:</span>
            <span class="text-[#0f4db3]">$958.325</span>
        </div>
        
        <button class="w-full py-4 btn-primary-custom text-white rounded-xl font-bold cursor-pointer transition-all duration-300 flex items-center justify-center gap-2 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-[#0f4db3]/40">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3l8-8"></path><path d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9s4.03-9 9-9c1.51 0 2.93.37 4.18 1.03"></path></svg>
            Procesar Pedido
        </button>
    </div>
</div>