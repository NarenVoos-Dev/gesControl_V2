<header class="bg-white/95 backdrop-blur-xl px-4 py-3 flex items-center  shadow-md sticky top-0 z-50 border-b border-[#0f4db3]/10 justify-between">
    <!-- Botón de Menú (Hamburguesa) -->
    <button onclick="toggleSidebar()" 
        class="p-2 rounded-lg transition-all duration-300 text-gray-600 hover:bg-gradient-to-br from-[#0f4db3] to-[#028dff] hover:text-white hover:scale-105">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    </button>
    
    <!-- Logo y Título de la Aplicación -->
    <div class="flex items-center gap-6">
        <!-- Título principal -->
        <span class="text-xl font-extrabold bg-gradient-to-r from-[#0f4db3] to-[#028dff] bg-clip-text text-transparent">JF Products B2B</span>
    </div>
    
    <!-- Barra de Búsqueda -->
    <div class="flex-1 max-w-lg relative hidden md:block">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-[#0f4db3] w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.35-4.35"></path>
        </svg>
        <input type="text" onkeyup="searchProducts(this.value)" placeholder="Buscar productos y pedidos..." 
               class="w-full py-2.5 pl-10 pr-4 border-2 border-transparent rounded-xl text-sm transition-all duration-300 bg-white/80 backdrop-blur-md 
                      focus:outline-none focus:border-[#0f4db3] focus:bg-white focus:shadow-md focus:shadow-[#0f4db3]/10 focus:-translate-y-0.5">
    </div>
    
    <!-- Botones de Utilidad -->
    <div class="flex items-center gap-4">
        
        <!-- Botón de Notificaciones -->
        <button class="p-2 rounded-lg transition-all duration-300 text-gray-600 hover:bg-[#0f4db3]/10 hover:text-[#0f4db3] hidden sm:block">
            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
        </button>
        
        <!-- Botón de Carrito -->
        <div onclick="toggleCart()" 
             class="px-4 py-2 rounded-lg transition-all duration-300 bg-gradient-to-br from-[#0f4db3] to-[#028dff] text-white flex items-center gap-1 font-semibold text-sm cursor-pointer hover:-translate-y-0.5 hover:shadow-xl hover:shadow-[#0f4db3]/30">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
            </svg>
            <span id="cartBadge" class="bg-red-500 text-white rounded-full w-4 h-4 flex items-center justify-center text-xs font-bold ml-1">3</span>
        </div>
    </div>
</header>