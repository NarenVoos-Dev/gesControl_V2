<div id="productModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-[1000] opacity-0 invisible transition-all duration-400 p-0">
    <div class="modal-content bg-white/95 backdrop-blur-xl rounded-2xl max-w-5xl w-full max-h-[98vh] overflow-y-auto scale-75 translate-y-10 transition-all duration-400 border border-white/30 shadow-2xl">
        
        <!-- Botón de Cerrar (Ajustado) -->
        <div class="p-4 flex justify-end">
            <button onclick="closeModal()" class="bg-white/80 backdrop-blur-md border-none w-10 h-10 rounded-full cursor-pointer text-gray-600 text-lg transition-all duration-300 flex items-center justify-center hover:bg-red-500/10 hover:text-red-600 hover:scale-110 shadow-md">&times;</button>
        </div>
        
        <!-- Contenido principal: Grid más compacto (gap-6 en lugar de gap-10) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 pt-0">
            
            <!-- COLUMNA IZQUIERDA: IMAGEN Y GALERÍA -->
            <div class="md:sticky md:top-0 h-full">
                <!-- Imagen principal (h-64) -->
                <div id="modalMainImage" class="w-full h-64 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl flex items-center justify-center text-6xl mb-4 shadow-xl">🩺</div>
                
                <!-- Galería (Tamaño reducido) -->
                <div class="flex gap-3 justify-center mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center cursor-pointer border-2 border-[#0f4db3] transition-all duration-300 text-xl scale-105">🩺</div>
                    <div class="w-14 h-14 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center cursor-pointer border-2 border-transparent transition-all duration-300 text-xl hover:scale-105">📋</div>
                    <div class="w-14 h-14 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center cursor-pointer border-2 border-transparent transition-all duration-300 text-xl hover:scale-105">💊</div>
                </div>

                 <!-- Aviso Legal -->
                <div class="bg-[#0f4db3]/5 backdrop-blur-md p-3 rounded-xl text-xs text-gray-600 leading-relaxed border border-[#0f4db3]/10">
                    <strong>Registro INVIMA:</strong> 2024MD001234 • <strong>Importador:</strong> MedSupply Colombia S.A.S
                </div>

            </div>
            
            <!-- COLUMNA DERECHA: INFO Y ACCIONES -->
            <div>
                <!-- Título (text-2xl) -->
                <h2 id="modalTitle" class="text-2xl font-extrabold text-gray-900 mb-3 leading-tight">Estetoscopio Digital Premium</h2>
                
                <!-- Descripción (más compacta) -->
                <p id="modalDescription" class="text-gray-600 mb-4 leading-relaxed text-sm">Estetoscopio digital de última generación con tecnología avanzada de amplificación de sonido y cancelación de ruido.</p>
                
                <!-- Especificaciones Técnicas (Padding y margen reducidos) -->
                <div class="bg-[#0f4db3]/5 backdrop-blur-md p-3 rounded-xl mb-4 border border-[#0f4db3]/10">
                    <div class="font-bold text-gray-900 mb-2 text-sm">Especificaciones Técnicas</div>
                    <div class="grid grid-cols-2 gap-1 text-xs">
                        <div class="flex justify-between py-1 border-b border-[#0f4db3]/10">
                            <span class="font-semibold text-gray-600">Marca:</span>
                            <span class="text-gray-900 font-medium">MedTech Pro</span>
                        </div>
                        <div class="flex justify-between py-1 border-b border-[#0f4db3]/10">
                            <span class="font-semibold text-gray-600">Modelo:</span>
                            <span class="text-gray-900 font-medium">DIG-2024</span>
                        </div>
                    </div>
                </div>
                
                <!-- Bloque de Precio -->
                <div class="mb-4 text-center p-2 bg-white/80 backdrop-blur-md rounded-xl border border-white/30">
                    <div id="modalPrice" class="text-4xl font-black bg-gradient-to-r from-[#0f4db3] to-[#028dff] bg-clip-text text-transparent mb-1">$299.900</div>
                    <div class="text-gray-600 text-sm font-medium">Por unidad • IVA incluido</div>
                </div>
                 <!-- Stock y Cantidad -->
                <div class="flex items-center gap-3 mb-8 p-2 bg-[#0f4db3]/5  rounded-lg">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <span class="text-sm text-gray-600 font-medium">En stock • 15 unidades disponibles</span>
                </div>
                
                
                <div class="flex items-center justify-center gap-4 mb-6">
                    <span class="font-bold text-gray-900 text-base">Cantidad:</span>
                    <div class="flex items-center bg-white/80 backdrop-blur-md rounded-lg overflow-hidden border-2 border-[#0f4db3]/10">
                        <button onclick="changeQuantity(-1)" class="bg-none border-none py-2 px-3 cursor-pointer text-lg font-bold text-[#0f4db3] transition-all duration-300 hover:bg-[#0f4db3]/10 rounded-l-lg">−</button>
                        <input type="number" id="quantityInput" value="1" min="1" max="15" class="border-none py-2 px-3 text-center font-bold w-14 bg-transparent text-base focus:outline-none">
                        <button onclick="changeQuantity(1)" class="bg-none border-none py-2 px-3 cursor-pointer text-lg font-bold text-[#0f4db3] transition-all duration-300 hover:bg-[#0f4db3]/10 rounded-r-lg">+</button>
                    </div>
                </div>
                
                <!-- Botón de Acción -->
                <button onclick="addToCart()" class="w-full py-1 text-base font-bold mb-4 rounded-xl bg-gradient-to-br from-[#0f4db3] to-[#028dff] text-white border-none cursor-pointer transition-all duration-300 flex items-center justify-center gap-2 hover:-translate-y-0.5 hover:shadow-2xl hover:shadow-[#0f4db3]/30">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    Agregar al pedido
                </button>
                
               
            </div>
        </div>
    </div>
</div>