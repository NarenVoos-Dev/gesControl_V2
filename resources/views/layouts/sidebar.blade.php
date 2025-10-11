<!--<aside class="flex flex-col w-20 bg-gradient-to-b from-blue-800 to-indigo-900 shadow-2xl border-r border-slate-700 transition-all duration-300 hover:w-64 group">
    <!-Logo Section --
    <div class="flex items-center justify-center h-20 border-b border-slate-700/50 relative overflow-hidden">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                <img src="{{ asset('img/favicon.svg') }}" alt="Logo" class="w-6 h-6">
            </div>
            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                <h1 class="text-white font-bold text-lg">Ges-Control</h1>
                <p class="text-slate-400 text-xs">Punto de Venta</p>
            </div>
        </div>
    </div>

    <!- Navigation Links --
    <nav class="flex flex-col flex-grow mt-6 space-y-2 px-3">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('pos.index') ? 'active' : '' }}" title="Punto de Venta">
            <div class="flex items-center space-x-4 p-3 rounded-xl">
                <div class="w-6 h-6 flex-shrink-0 sidebar-icon text-gray-300"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 21v-7.5A.75.75 0 0 1 14.25 12h.5a.75.75 0 0 1 .75.75V21m-4.5 0v-7.5A.75.75 0 0 1 10.5 12h.5a.75.75 0 0 1 .75.75V21m-4.5 0V16.5a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 .75.75V21m-4.5 0V18a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 .75.75v3.75m-7.5 0V12A.75.75 0 0 1 3 11.25h.5A.75.75 0 0 1 4.25 12v9.75m-7.5 0h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm-3.75 0h.008v.008h-.008V8.25Zm-3.75 0h.008v.008h-.008V8.25Z"></path></svg></div>
                <span class="opacity-0 group-hover:opacity-100 text-gray-300 transition-opacity duration-300 whitespace-nowrap font-medium">Dashboard</span>
            </div>
        </a>
        <a href="{{ route('pos.index') }}" class="sidebar-link {{ request()->routeIs('pos.index') ? 'active' : '' }}" title="Punto de Venta">
            <div class="flex items-center space-x-4 p-3 rounded-xl">
                <div class="w-6 h-6 flex-shrink-0 sidebar-icon text-gray-300"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 21v-7.5A.75.75 0 0 1 14.25 12h.5a.75.75 0 0 1 .75.75V21m-4.5 0v-7.5A.75.75 0 0 1 10.5 12h.5a.75.75 0 0 1 .75.75V21m-4.5 0V16.5a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 .75.75V21m-4.5 0V18a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 .75.75v3.75m-7.5 0V12A.75.75 0 0 1 3 11.25h.5A.75.75 0 0 1 4.25 12v9.75m-7.5 0h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm-3.75 0h.008v.008h-.008V8.25Zm-3.75 0h.008v.008h-.008V8.25Z"></path></svg></div>
                <span class="opacity-0 group-hover:opacity-100 text-gray-300 transition-opacity duration-300 whitespace-nowrap font-medium">Punto de Venta</span>
            </div>
        </a>
        <a href="{{ route('pos.sales.list') }}" class="sidebar-link {{ request()->routeIs('pos.sales.list') ? 'active' : '' }}" title="Ventas">
            <div class="flex items-center space-x-4 p-3 rounded-xl">
                <div class="w-6 h-6 flex-shrink-0 sidebar-icon text-gray-300"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"></path></svg></div>
                <span class="opacity-0 group-hover:opacity-100 text-gray-300 transition-opacity duration-300 whitespace-nowrap font-medium">Listado de Ventas</span>
            </div>
        </a>
        <a href="{{ route('pos.accounts.receivable') }}" class="sidebar-link {{ request()->routeIs('pos.accounts.receivable') ? 'active' : '' }}" title="Cuentas por Cobrar">
            <div class="flex items-center space-x-4 p-3 rounded-xl">
                <div class="w-6 h-6 flex-shrink-0 sidebar-icon text-gray-300">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9H9m6 3H9m6 3H9m-3-9h12a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z"></path></svg>
                </div>
                <span class="opacity-0 group-hover:opacity-100 text-gray-300 transition-opacity duration-300 whitespace-nowrap font-medium">Cuentas por Cobrar</span>
            </div>
        </a>
        <a href="{{ route('pos.close_cash_register.form') }}" class="sidebar-link" title="Cerrar Caja">
            <div class="flex items-center space-x-4 p-3 rounded-xl">
                <div class="w-6 h-6 flex-shrink-0 sidebar-icon text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
                </div>
                <span class="opacity-0 group-hover:opacity-100 text-gray-300 transition-opacity duration-300 whitespace-nowrap font-medium">Cerrar Caja</span>
            </div>
        </a>
    </nav>

    <!- Logout Button --
    <div class="border-t border-slate-700/50 p-3 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center space-x-4 p-3 rounded-xl text-slate-400 hover:text-red-400 hover:bg-red-500/10 transition-all duration-200" title="Cerrar Sesión">
                <div class="w-6 h-6 flex-shrink-0"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0-3-3m3 3H9"></path></svg></div>
                <span class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap font-medium">Cerrar Sesión</span>
            </button>
        </form>
    </div>
</aside>-->

<!-- Sidebar -->
<!-- Sidebar -->
<div id="sidebarOverlay" onclick="closeSidebar()" class="fixed inset-0 bg-black/40 opacity-0 invisible transition-all duration-400 z-40"></div>

<!-- Sidebar: W-64 compactado -->
<nav id="sidebar" class="fixed left-0 top-0 w-64 h-full bg-white/95 backdrop-blur-xl shadow-2xl -translate-x-full transition-transform duration-400 z-50 pt-24">
    <div class="p-4 text-center border-b border-[#028dff]/10">
        <!-- Logo/Avatar -->
        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#0f4db3] to-[#028dff] flex items-center justify-center text-white font-bold text-lg mx-auto mb-3 shadow-xl shadow-[#0f4db3]/30">DR</div>
        <div class="font-bold text-gray-900 text-base mb-0.5">Dr. María Rodríguez</div>
        <div class="text-[#028dff] text-xs font-medium">Administrador Principal</div>
    </div>
    
    <!-- Contenedor Principal de Links (para que ocupe el espacio completo) -->
    <div class="py-4 flex flex-col h-[calc(100%-120px)] overflow-y-auto"> 
        <div class="flex-grow space-y-1">
            <!-- SECCIÓN PRINCIPAL -->
            <div class="mb-4">
                <div class="px-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Principal</div>
                
                <!-- Links de Navegación -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 text-gray-600 transition-all duration-300 text-sm font-medium hover:bg-[#0f4db3]/5 hover:text-[#0f4db3] hover:translate-x-1">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    Dashboard
                </a>
                <a href="{{ route('pos.index') }}" class="flex items-center gap-3 px-4 py-2 text-gray-600 transition-all duration-300 text-sm font-medium hover:bg-[#0f4db3]/5 hover:text-[#0f4db3] hover:translate-x-1">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27,6.96 12,12.01 20.73,6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                    Catálogo
                </a>
            </div>
            
            <!-- SECCIÓN PEDIDOS -->
            <div class="mb-4">
                <div class="px-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Pedidos</div>
                <a href="#" class="flex items-center gap-3 px-4 py-2 text-gray-600 transition-all duration-300 text-sm font-medium hover:bg-[#0f4db3]/5 hover:text-[#0f4db3] hover:translate-x-1">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                    Historial de Pedidos
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-2 text-gray-600 transition-all duration-300 text-sm font-medium hover:bg-[#0f4db3]/5 hover:text-[#0f4db3] hover:translate-x-1">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                    Cuentas por Cobrar
                </a>
            </div>
            
            <!-- SECCIÓN HERRAMIENTAS -->
            <div>
                <div class="px-4 pb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">Herramientas</div>
                <a href="#" onclick="toggleCart(); return false;" class="flex items-center gap-3 px-4 py-2 text-gray-600 transition-all duration-300 text-sm font-medium hover:bg-[#0f4db3]/5 hover:text-[#0f4db3] hover:translate-x-1">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    Ver Carrito
                </a>
            </div>
        </div>
        
        <!-- Bloque de Cerrar Sesión (Fijo en la parte inferior) -->
        <!-- Borde superior limpio y clase 'mt-auto' removida, usando el div padre flex-col -->
        <div class="border-t border-[#028dff]/10 p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 py-2 text-gray-600 transition-all duration-300 text-sm font-medium hover:bg-red-500/10 hover:text-red-500" title="Cerrar Sesión">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
</nav>