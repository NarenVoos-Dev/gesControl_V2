@extends('layouts.pos')

@section('title', 'Catálogo de Productos')
@section('page-title', 'Catálogo de Productos')

@section('content')
<!-- Contenedor Principal del Título -->
<div class="bg-white/95 backdrop-blur-xl rounded-xl p-4 mb-4 shadow-lg border border-white/20">
    <h1 class="text-3xl font-extrabold bg-gradient-to-r from-[#0f4db3] to-[#028dff] bg-clip-text text-transparent mb-0.5">Catálogo de Insumos</h1>
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
