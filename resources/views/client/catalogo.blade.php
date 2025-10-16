@extends('layouts.pos')

@section('title', 'Catálogo de Productos')
@section('page-title', 'Catálogo de Productos')

@section('content')
<!-- Contenedor Principal del Título -->
<div class="bg-white/95 backdrop-blur-xl rounded-xl p-4 mb-4 shadow-lg border border-white/20">
    <h2 class="text-2xl font-extrabold bg-gradient-to-r from-[#0f4db3] to-[#028dff] bg-clip-text text-transparent mb-0.5">Catálogo de Insumos</h2>
    <p class="text-gray-600 text-sm font-medium">Inventario y precios exclusivos para clientes institucionales.</p>
</div>

<!-- Contenedor del Catálogo y Filtros -->
<div class="bg-white/95 backdrop-blur-xl rounded-xl p-6 shadow-2xl border border-white/20">
    
    <!-- Barra de Filtros y Búsqueda -->
    <div class="flex justify-between items-center mb-6 flex-wrap gap-3">
        <h2 class="text-xl font-bold text-gray-900">Productos</h2>
        
        <!-- Botones de Categoría (Compactos) -->
        <div class="flex gap-2 flex-wrap">
            <button class="filter-tab active px-3 py-1.5 rounded-lg border-none bg-gradient-to-br from-[#0f4db3] to-[#028dff] text-white cursor-pointer transition-all duration-300 font-medium text-sm shadow-md" data-category-id="all">
                Todos
            </button>
            
            {{-- Bucle para las demás categorías --}}
            @foreach($categories as $category)
                <button class="filter-tab px-3 py-1.5 rounded-lg border-none bg-transparent text-gray-600 cursor-pointer transition-all duration-300 font-medium text-sm hover:bg-gradient-to-br hover:from-[#0f4db3]/80 hover:to-[#028dff]/80 hover:text-white" data-category-id="{{ $category->id }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- Grid de Productos -->
    <div id="productsGrid" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
    </div>
</div>
@endsection
@push('scripts')
<script>

    let allProducts = [];
    document.addEventListener('DOMContentLoaded', function() {
        // Guardamos los productos iniciales que pasamos desde el controlador
        allProducts = @json($products);
        //console.log(allProducts)
        const productsGrid = document.getElementById('productsGrid');
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

        // Función para hacer peticiones al servidor
        function ajaxRequest(url, method, data = {}) {
            return $.ajax({ url, method, headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }, data });
        }

        // Función para renderizar los productos en el HTML
        function renderProducts(productsToRender) {
            const grid = document.getElementById('productsGrid');
            
            if (!productsToRender || productsToRender.length === 0) {
                //grid.innerHTML = '<p class="text-center text-gray-500 col-span-full">No se encontraron productos para esta categoría.</p>';
                productsGrid.innerHTML = `
                                        <div class="col-span-full flex flex-col items-center justify-center py-20 px-4">
                                            <div class="w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6 relative">
                                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                                </svg>
                                                <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg">
                                                    <span class="text-2xl">📦</span>
                                                </div>
                                            </div>
                                            
                                            <h3 class="text-2xl font-bold text-gray-900 mb-2">No encontramos productos</h3>
                                            <p class="text-gray-600 mb-6 text-center max-w-md">
                                                No hay productos disponibles para esta categoría en este momento.
                                            </p>
                                            
                                        </div>
                                    `;
                return;
            }

            grid.innerHTML = productsToRender.map(product => {
                // Lógica para determinar el texto y color del stock
                const stock = parseFloat(product.stock_in_location ?? 0);
                const stock_minimo = parseFloat(product.stock_minimo ?? 0);
                
                let stockText = '';
                let stockColorClass = '';

                if (stock > stock_minimo ) {
                    stockText = `En stock (${stock})`;
                    stockColorClass = 'bg-green-500';
                   
                } else if (stock <= stock_minimo && stock_minimo > 0) {
                    stockText = `Stock bajo (${stock})`;
                    stockColorClass = 'bg-orange-500';
                } else {
                     stockText = 'Agotado';
                    stockColorClass = 'bg-red-500';
                   
                }

                // Lógica para el badge (si existe en tus datos de producto)
                const badgeHtml = product.badge ? 
                    `<div class="absolute top-2 right-2 px-2 py-1 rounded-lg text-xs font-bold uppercase ${
                        product.badge.type === 'offer' ? 'bg-gradient-to-br from-green-500 to-green-600' : 
                        product.badge.type === 'low-stock' ? 'bg-gradient-to-br from-orange-500 to-orange-600' : 
                        'bg-gradient-to-br from-[#0f4db3] to-[#028dff]'
                    } text-white">${product.badge.text}</div>` : '';

                // Construcción del HTML de la tarjeta con el nuevo diseño
                return `
                    <div onclick="openProductModal(${product.id})" 
                        class="bg-white/90 backdrop-blur-md rounded-xl p-4 shadow-lg transition-all duration-400 cursor-pointer relative overflow-hidden border border-white/30
                                hover:-translate-y-1 hover:scale-[1.01] hover:shadow-xl hover:shadow-[#0f4db3]/20
                                before:absolute before:top-0 before:left-0 before:right-0 before:h-1 before:bg-gradient-to-r before:from-[#0f4db3] before:to-[#028dff] before:scale-x-0 before:transition-transform before:duration-300 hover:before:scale-x-100
                                flex flex-col min-h-[320px]">
                        
                        <!-- Imagen del producto -->
                        <div class="w-full h-40 bg-gray-100 rounded-lg flex items-center justify-center text-6xl mb-4 relative overflow-hidden flex-shrink-0">
                            ${badgeHtml}
                            ${product.image ?? '📦'}
                        </div>
                        
                        <!-- Contenido que puede crecer -->
                        <div class="flex-grow flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 mb-1 leading-tight line-clamp-2 min-h-[56px]">
                                ${product.name}
                            </h3>
                            
                            <p class="text-gray-600 text-xs mb-2 leading-relaxed line-clamp-2 min-h-[32px]">
                                ${product.description?.substring(0, 80) ?? 'Sin descripción'}${product.description?.length > 80 ? '...' : ''}
                            </p>
                        </div>
                        
                        <!-- Sección fija al final: Precio + Stock + Botones -->
                        <div class="mt-auto flex-shrink-0">
                            <!-- Precio y Stock -->
                            <div class="items-center mb-6">
                                <div class="text-2xl font-extrabold bg-gradient-to-r from-[#0f4db3] to-[#028dff] bg-clip-text text-transparent">
                                    $${parseFloat(product.price).toLocaleString('es-CO')}
                                </div>
                                
                                <div class="flex items-center gap-1 p-1 bg-[#0f4db3]/5 rounded-md">
                                    <div class="w-2 h-2 rounded-full ${stockColorClass}"></div>
                                    <span class="text-xs text-gray-600 font-medium">${stockText}</span>
                                </div>
                            </div>
                            
                            <!-- Botones -->
                            <div class="flex gap-2">
                                <button onclick="event.stopPropagation(); openProductModal(${product.id})" 
                                        class="px-3 py-2 rounded-lg font-semibold text-xs cursor-pointer transition-all duration-300 
                                            border-2 border-gray-200 text-gray-600 bg-transparent flex-1 
                                            inline-flex items-center justify-center gap-1 
                                            hover:border-[#0f4db3] hover:text-[#0f4db3] hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#0f4db3]/15">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                    Ver
                                </button>
                                
                                <button onclick="event.stopPropagation(); quickAddToCart(${product.id})" 
                                        class="px-3 py-2 rounded-lg font-semibold text-xs cursor-pointer transition-all duration-300 
                                            bg-gradient-to-br from-[#0f4db3] to-[#028dff] text-white border-none flex-1 
                                            inline-flex items-center justify-center gap-1 
                                            hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#0f4db3]/30">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="9" cy="21" r="1"></circle>
                                        <circle cx="20" cy="21" r="1"></circle>
                                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                    </svg>
                                    Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function loadProducts(categoryId = null, searchTerm = '') {
            //cargando productos
            productsGrid.innerHTML = `
                    <div class="col-span-full flex flex-col items-center justify-center py-16">
                        <div class="relative w-20 h-20 mb-6">
                            <!-- Spinner animado -->
                            <div class="absolute inset-0 border-4 border-[#0f4db3]/20 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-transparent border-t-[#0f4db3] rounded-full animate-spin"></div>
                            <div class="absolute inset-2 border-4 border-transparent border-t-[#028dff] rounded-full animate-spin" style="animation-duration: 0.8s; animation-direction: reverse;"></div>
                        </div>
                        
                        <!-- Texto con animación de puntos -->
                        <p class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                            <span>Cargando productos</span>
                            <span class="flex gap-1">
                                <span class="w-2 h-2 bg-[#0f4db3] rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                                <span class="w-2 h-2 bg-[#0f4db3] rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                                <span class="w-2 h-2 bg-[#0f4db3] rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                            </span>
                        </p>
                        
                        <p class="text-sm text-gray-500 mt-2">Esto solo tomará un momento</p>
                    </div>
                `;
            
            const data = {};
            if (categoryId && categoryId !== 'all') {
                data.category_id = categoryId;
            }
            if (searchTerm) {
                data.search = searchTerm;
            }

            // Hacemos la llamada a la API que ya tienes en PosApiController
            ajaxRequest('{{ route("api.b2b.products.search") }}', 'GET', data)
                .done(function(products) {
                    // Una vez que el servidor responde, renderizamos los productos
                    renderProducts(products);
                })
                .fail(function() {
                    productsGrid.innerHTML = `
                            <div class="col-span-full flex flex-col items-center justify-center py-16 px-4">
                                <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mb-6">
                                    <svg class="w-12 h-12 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Error al cargar productos</h3>
                                <p class="text-gray-600 mb-6 text-center max-w-md">
                                    No pudimos cargar el catálogo. Por favor, verifica tu conexión e intenta nuevamente.
                                </p>
                                
                                <button onclick="searchProducts()" class="px-6 py-3 bg-gradient-to-br from-[#0f4db3] to-[#028dff] text-white font-semibold rounded-lg transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Reintentar
                                </button>
                            </div>
                    `;
                });
        }

        // Función para manejar el clic en los filtros de categoría
        function setupFilterTabs() {
            const filterTabs = document.querySelectorAll('.filter-tab');
            
            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // --- Tu lógica de diseño (no se cambia) ---
                    filterTabs.forEach(t => {
                        t.classList.remove('bg-gradient-to-br', 'from-[#0f4db3]', 'to-[#028dff]', 'text-white', 'shadow-md');
                        t.classList.add('bg-transparent', 'text-gray-600');
                    });
                    this.classList.remove('bg-transparent', 'text-gray-600');
                    this.classList.add('bg-gradient-to-br', 'from-[#0f4db3]', 'to-[#028dff]', 'text-white', 'shadow-md');
                    
                    // --- Lógica de datos (aquí está el cambio) ---
                    const categoryId = this.dataset.categoryId;
                    
                    // En lugar de filtrar el array, llamamos a la función 
                    // que hace la petición al servidor.
                    loadProducts(categoryId);
                });
            });
        }



        // Renderizado inicial
       
        setupFilterTabs();
        loadProducts('all');
    });



    function openProductModal(productId) {
        // Buscamos el producto en nuestra lista 'allProducts'
        const product = allProducts.find(p => p.id === productId);
        if (!product) return; // Si no se encuentra, no hacer nada

        // 1. Llenar los campos del modal con los datos del producto
        $('#modalTitle').text(product.name);
        $('#modalDescription').text(product.description ?? 'Sin descripción.');
        $('#modalPrice').text(`$${parseFloat(product.price).toLocaleString('es-CO')}`);
        $('#modalMainImage').text(product.image ?? '📦');

        // Lógica para el stock (usando el código que ya corregimos)
        const stock = parseFloat(product.stock_in_location ?? 0);
        const stock_minimo = parseFloat(product.stock_minimo ?? 0);
        let stockText = '';
        let stockColorClass = '';
        if (stock <= 0) {
            stockText = 'Agotado'; stockColorClass = 'bg-red-500';
        } else if (stock <= stock_minimo && stock_minimo > 0) {
            stockText = `Stock bajo (${stock})`; stockColorClass = 'bg-orange-500';
        } else {
            stockText = `En stock (${stock})`; stockColorClass = 'bg-green-500';
        }
        
        // Actualizamos el indicador de stock dentro del modal
        const stockIndicator = $('#productModal').find('.flex.items-center.gap-3');
        stockIndicator.find('.w-2.h-2').attr('class', `w-2 h-2 rounded-full ${stockColorClass}`);
        stockIndicator.find('span').text(stockText);

        // Reseteamos la cantidad a 1
        $('#quantityInput').val(1).attr('max', stock); // Ponemos el stock máximo en el input

        // 2. Mostrar el modal con una animación
        const modal = $('#productModal');
        modal.removeClass('opacity-0 invisible');
        modal.find('.modal-content').removeClass('scale-75 translate-y-10');
        $('body').css('overflow', 'hidden'); // Evita el scroll del fondo
    }

    // Función para CERRAR el modal
    function closeModal() {
        const modal = $('#productModal');
        modal.addClass('opacity-0');
        modal.find('.modal-content').addClass('scale-75 translate-y-10');
        // Esperamos a que la animación termine para ocultarlo completamente
        setTimeout(() => {
            modal.addClass('invisible');
            $('body').css('overflow', 'auto');
        }, 400);
    }

    // Función para cambiar la cantidad en el modal
    function changeQuantity(delta) {
        const input = $('#quantityInput');
        const currentValue = parseInt(input.val());
        const maxValue = parseInt(input.attr('max'));
        let newValue = currentValue + delta;

        if (newValue < 1) newValue = 1;
        if (newValue > maxValue) newValue = maxValue;

        input.val(newValue);
    }

    // (Opcional) Cierra el modal al presionar la tecla Escape
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && !$('#productModal').hasClass('invisible')) {
            closeModal();
        }
    });
</script>
@endpush