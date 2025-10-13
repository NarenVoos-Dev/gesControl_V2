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
        <h2 class="text-xl font-bold text-gray-900">Productos Destacados</h2>
        
        <!-- Botones de Categoría (Compactos) -->
        <div class="flex gap-2 flex-wrap">
            
            <button class="filter-tab px-3 py-1.5 rounded-lg border-none bg-gradient-to-br from-[#0f4db3] to-[#028dff] text-white cursor-pointer transition-all duration-300 font-medium text-sm shadow-md">Todos</button>
            <button class="filter-tab px-3 py-1.5 rounded-lg border-none bg-transparent text-gray-600 cursor-pointer transition-all duration-300 font-medium text-sm hover:bg-gradient-to-br hover:from-[#0f4db3]/80 hover:to-[#028dff]/80 hover:text-white">Diagnóstico</button>
            <button class="filter-tab px-3 py-1.5 rounded-lg border-none bg-transparent text-gray-600 cursor-pointer transition-all duration-300 font-medium text-sm hover:bg-gradient-to-br hover:from-[#0f4db3]/80 hover:to-[#028dff]/80 hover:text-white">Protección</button>
            <button class="filter-tab px-3 py-1.5 rounded-lg border-none bg-transparent text-gray-600 cursor-pointer transition-all duration-300 font-medium text-sm hover:bg-gradient-to-br hover:from-[#0f4db3]/80 hover:to-[#028dff]/80 hover:text-white">Instrumental</button>
            <button class="filter-tab px-3 py-1.5 rounded-lg border-none bg-transparent text-gray-600 cursor-pointer transition-all duration-300 font-medium text-sm hover:bg-gradient-to-br hover:from-[#0f4db3]/80 hover:to-[#028dff]/80 hover:text-white">Emergencia</button>
            <button class="filter-tab px-3 py-1.5 rounded-lg border-none bg-transparent text-gray-600 cursor-pointer transition-all duration-300 font-medium text-sm hover:bg-gradient-to-br hover:from-[#0f4db3]/80 hover:to-[#028dff]/80 hover:text-white">Laboratorio</button>
            <button class="filter-tab px-3 py-1.5 rounded-lg border-none bg-transparent text-gray-600 cursor-pointer transition-all duration-300 font-medium text-sm hover:bg-gradient-to-br hover:from-[#0f4db3]/80 hover:to-[#028dff]/80 hover:text-white">Rehabilitación</button>
            <button class="filter-tab px-3 py-1.5 rounded-lg border-none bg-transparent text-gray-600 cursor-pointer transition-all duration-300 font-medium text-sm hover:bg-gradient-to-br hover:from-[#0f4db3]/80 hover:to-[#028dff]/80 hover:text-white">Cirugía</button>
        </div>
    </div>

    <!-- Grid de Productos -->
    <div id="productsGrid" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
    </div>
</div>
@endsection
@push('scripts')
<script>
       const products = [
            { id: 1, name: "Estetoscopio Digital Premium", description: "Estetoscopio digital con amplificación 40x", price: 299900, stock: "high", stockText: "En stock (15 disponibles)", image: "🩺", badge: { type: "new", text: "Nuevo" }, rating: 4.9, reviews: 156, category: "diagnóstico" },
            { id: 2, name: "Termómetro Infrarrojo", description: "Medición sin contacto, precisión ±0.2°C", price: 89900, stock: "low", stockText: "Stock bajo (3 disponibles)", image: "🌡️", badge: { type: "low-stock", text: "Últimas" }, rating: 4.8, reviews: 234, category: "diagnóstico" },
            { id: 3, name: "Guantes Nitrilo", description: "Caja x100, libres de látex", price: 45900, stock: "medium", stockText: "Stock medio (8 disponibles)", image: "🧤", badge: { type: "offer", text: "Oferta" }, rating: 4.7, reviews: 89, category: "protección" },
            { id: 4, name: "Mascarillas N95", description: "Caja x20, certificación FDA", price: 67500, stock: "high", stockText: "En stock (25 disponibles)", image: "😷", badge: null, rating: 4.6, reviews: 178, category: "protección" },
            { id: 5, name: "Kit Jeringas", description: "Paquete x50, aguja 21G incluida", price: 34900, stock: "high", stockText: "En stock (40 disponibles)", image: "💉", badge: null, rating: 4.5, reviews: 67, category: "instrumental" },
            { id: 6, name: "Desfibrilador", description: "DEA con instrucciones de voz", price: 2899900, stock: "low", stockText: "Stock bajo (2 disponibles)", image: "⚡", badge: { type: "new", text: "Nuevo" }, rating: 4.9, reviews: 45, category: "emergencia" }
        ];

        let cart = [
            { id: 1, name: "Estetoscopio Digital Premium", price: 299900, quantity: 1, image: "🩺" },
            { id: 2, name: "Guantes Nitrilo Premium", price: 45900, quantity: 2, image: "🧤" },
            { id: 3, name: "Termómetro Infrarrojo Pro", price: 89900, quantity: 1, image: "🌡️" }
        ];

        document.addEventListener('DOMContentLoaded', function() {
            renderProducts();
            renderCart();
            updateCartBadge();
            setupFilterTabs();
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('opacity-0');
            overlay.classList.toggle('invisible');
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0');
            overlay.classList.add('invisible');
        }

        function renderProducts(filteredProducts = products) {
            const grid = document.getElementById('productsGrid');
            
            grid.innerHTML = filteredProducts.map(product => `
                <div onclick="openProductModal(${product.id})" class="bg-white/90 backdrop-blur-md rounded-xl p-4 shadow-lg transition-all duration-400 cursor-pointer relative overflow-hidden border border-white/30 
                    hover:-translate-y-1 hover:scale-[1.01] hover:shadow-xl hover:shadow-[#0f4db3]/20 
                    before:absolute before:top-0 before:left-0 before:right-0 before:h-1 before:bg-gradient-to-r before:from-[#0f4db3] before:to-[#028dff] before:scale-x-0 before:transition-transform before:duration-300 hover:before:scale-x-100">
                    
                    <!-- Imagen y Badge -->
                    <div class="w-full h-40 bg-gray-100 rounded-lg flex items-center justify-center text-6xl mb-4 relative overflow-hidden">
                        ${product.badge ? `<div class="absolute top-2 right-2 px-2 py-1 rounded-lg text-xs font-bold uppercase ${product.badge.type === 'offer' ? 'bg-gradient-to-br from-green-500 to-green-600' : product.badge.type === 'low-stock' ? 'bg-gradient-to-br from-orange-500 to-orange-600' : 'bg-gradient-to-br from-[#0f4db3] to-[#028dff]'} text-white">${product.badge.text}</div>` : ''}
                        ${product.image}
                    </div>

                    <!-- Título y Descripción -->
                    <h3 class="text-lg font-bold text-gray-900 mb-1 leading-tight">${product.name}</h3>
                    <p class="text-gray-600 text-xs mb-3 leading-relaxed">${product.description.substring(0, 50)}...</p>
                    
                    <!-- Precio y Stock -->
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-2xl font-extrabold bg-gradient-to-r from-[#0f4db3] to-[#028dff] bg-clip-text text-transparent">${product.price.toLocaleString()}</div>
                        
                        <!-- Indicador de Stock -->
                        <div class="flex items-center gap-1 p-1 bg-[#0f4db3]/5 rounded-md">
                            <div class="w-2 h-2 rounded-full ${product.stock === 'high' ? 'bg-green-500' : product.stock === 'medium' ? 'bg-orange-500' : 'bg-red-500'}"></div>
                            <span class="text-xs text-gray-600 font-medium">${product.stockText}</span>
                        </div>
                    </div>
                    
                    <!-- Botones de Acción -->
                    <div class="flex gap-2">
                        <button onclick="event.stopPropagation(); openProductModal(${product.id})" class="px-3 py-2 rounded-lg font-semibold text-xs cursor-pointer transition-all duration-300 border-2 border-gray-200 text-gray-600 bg-transparent flex-1 inline-flex items-center justify-center gap-1 hover:border-[#0f4db3] hover:text-[#0f4db3] hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#0f4db3]/15">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            Ver
                        </button>
                        <button onclick="event.stopPropagation(); quickAddToCart(${product.id})" class="px-3 py-2 rounded-lg font-semibold text-xs cursor-pointer transition-all duration-300 bg-gradient-to-br from-[#0f4db3] to-[#028dff] text-white border-none flex-1 inline-flex items-center justify-center gap-1 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-[#0f4db3]/30">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                            Agregar
                        </button>
                    </div>
                </div>
            `).join('');
        }

        function searchProducts(query) {
            if (!query.trim()) {
                renderProducts();
                return;
            }
            const filtered = products.filter(product => 
                product.name.toLowerCase().includes(query.toLowerCase()) ||
                product.description.toLowerCase().includes(query.toLowerCase())
            );
            renderProducts(filtered);
        }

        function openProductModal(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;
            
            document.getElementById('modalTitle').textContent = product.name;
            document.getElementById('modalDescription').textContent = product.description;
            document.getElementById('modalPrice').textContent = `${product.price.toLocaleString()}`;
            document.getElementById('modalMainImage').textContent = product.image;
            document.getElementById('quantityInput').value = 1;
            
            const modal = document.getElementById('productModal');
            modal.classList.remove('opacity-0', 'invisible');
            modal.querySelector('.modal-content').classList.remove('scale-75', 'translate-y-10');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            const modal = document.getElementById('productModal');
            modal.classList.add('opacity-0', 'invisible');
            modal.querySelector('.modal-content').classList.add('scale-75', 'translate-y-10');
            document.body.style.overflow = 'auto';
        }

        function changeQuantity(delta) {
            const input = document.getElementById('quantityInput');
            const newValue = parseInt(input.value) + delta;
            if (newValue >= 1 && newValue <= 15) {
                input.value = newValue;
            }
        }

        function toggleCart() {
            const cartPanel = document.getElementById('cartPanel');
            const overlay = document.getElementById('sidebarOverlay');
            cartPanel.classList.toggle('translate-x-full');
            overlay.classList.toggle('opacity-0');
            overlay.classList.toggle('invisible');
        }

        function closeCart() {
            const cartPanel = document.getElementById('cartPanel');
            const overlay = document.getElementById('sidebarOverlay');
            cartPanel.classList.add('translate-x-full');
            overlay.classList.add('opacity-0');
            overlay.classList.add('invisible');
        }

        function addToCart() {
            const quantity = parseInt(document.getElementById('quantityInput').value);
            const title = document.getElementById('modalTitle').textContent;
            showNotification(`✅ ${quantity} x ${title} agregado al carrito`, 'success');
            closeModal();
            const currentBadge = parseInt(document.getElementById('cartBadge').textContent);
            document.getElementById('cartBadge').textContent = currentBadge + quantity;
        }

        function quickAddToCart(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;
            showNotification(`✅ ${product.name} agregado al carrito`, 'success');
            const currentBadge = parseInt(document.getElementById('cartBadge').textContent);
            document.getElementById('cartBadge').textContent = currentBadge + 1;
        }

        function renderCart() {
            const cartItems = document.getElementById('cartItems');
            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="text-center py-20 px-5 text-gray-600">
                        <div class="text-7xl mb-6 opacity-30">🛒</div>
                        <h3 class="text-xl font-bold mb-2 text-gray-900">Tu carrito está vacío</h3>
                        <p>Explora nuestro catálogo y agrega productos</p>
                    </div>
                `;
                return;
            }
            
            cartItems.innerHTML = cart.map(item => `
                <div class="flex gap-4 py-5 border-b border-indigo-500/10">
                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center text-3xl">${item.image}</div>
                    <div class="flex-1">
                        <div class="font-bold text-gray-900 mb-2 text-base">${item.name}</div>
                        <div class="text-indigo-500 text-sm font-semibold mb-3">${item.price.toLocaleString()} c/u</div>
                        <div class="flex items-center gap-3">
                            <button onclick="updateCartQuantity(${item.id}, -1)" class="bg-none border-none py-1.5 px-4 cursor-pointer text-lg font-bold text-indigo-500 transition-all duration-300 hover:bg-indigo-500/10 rounded-lg">−</button>
                            <span class="px-4 font-bold text-indigo-500">${item.quantity}</span>
                            <button onclick="updateCartQuantity(${item.id}, 1)" class="bg-none border-none py-1.5 px-4 cursor-pointer text-lg font-bold text-indigo-500 transition-all duration-300 hover:bg-indigo-500/10 rounded-lg">+</button>
                            <button onclick="removeFromCart(${item.id})" class="ml-4 px-3 py-1.5 rounded-xl text-xs font-medium border-2 border-gray-200 text-gray-600 bg-transparent transition-all hover:border-red-500 hover:text-red-500">🗑️</button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function updateCartQuantity(itemId, delta) {
            const item = cart.find(item => item.id === itemId);
            if (!item) return;
            item.quantity += delta;
            if (item.quantity <= 0) {
                removeFromCart(itemId);
                return;
            }
            renderCart();
            updateCartBadge();
        }

        function removeFromCart(itemId) {
            const item = cart.find(item => item.id === itemId);
            if (item) {
                showNotification(`🗑️ ${item.name} eliminado del carrito`, 'info');
            }
            cart = cart.filter(item => item.id !== itemId);
            renderCart();
            updateCartBadge();
        }

        function updateCartBadge() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cartBadge').textContent = totalItems;
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-24 right-5 ${
                type === 'success' ? 'bg-gradient-to-br from-green-500 to-green-600' : 
                type === 'error' ? 'bg-gradient-to-br from-red-500 to-red-600' : 
                'bg-gradient-to-br from-indigo-500 to-purple-600'
            } text-white px-6 py-4 rounded-2xl shadow-2xl backdrop-blur-md z-[10000] font-semibold translate-x-96 transition-transform duration-400 max-w-xs`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            setTimeout(() => notification.classList.remove('translate-x-96'), 100);
            setTimeout(() => {
                notification.classList.add('translate-x-96');
                setTimeout(() => document.body.removeChild(notification), 400);
            }, 3000);
        }

        function setupFilterTabs() {
            const filterTabs = document.querySelectorAll('.filter-tab');
            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    filterTabs.forEach(t => {
                        t.classList.remove('bg-gradient-to-br', 'from-indigo-500', 'to-purple-600', 'text-white');
                        t.classList.add('bg-transparent', 'text-gray-600');
                    });
                    this.classList.remove('bg-transparent', 'text-gray-600');
                    this.classList.add('bg-gradient-to-br', 'from-indigo-500', 'to-purple-600', 'text-white');
                    
                    const filter = this.textContent.toLowerCase();
                    if (filter === 'todos') {
                        renderProducts();
                    } else {
                        const filtered = products.filter(product => product.category === filter);
                        renderProducts(filtered);
                    }
                });
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
                closeSidebar();
                closeCart();
            }
        });

        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
    </script>
@endpush