@extends('layouts.pos')

@section('title', 'Cerrar Caja')
@section('page-title', 'Cierre de Caja')

@section('content')
<div class="flex items-center justify-center h-full">
    <div class="w-full max-w-2xl p-8 space-y-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-gray-700">Resumen y Cierre de Caja</h2>
        
        <!-- Resumen del Sistema -->
        <div class="p-4 border rounded-lg bg-gray-50">
            <h3 class="font-semibold text-lg mb-2">Resumen del Sistema</h3>
            <div class="space-y-1 text-gray-600">
                <div class="flex justify-between"><span>(+) Base Inicial:</span> <span class="font-mono">${{ number_format($activeSession->opening_balance, 2) }}</span></div>
                <div class="flex justify-between"><span>(+) Entradas (Ventas, Abonos):</span> <span class="font-mono">${{ number_format($activeSession->transactions()->where('type', 'entrada')->where('description', '!=', 'Base inicial de caja')->sum('amount'), 2) }}</span></div>
                <div class="flex justify-between"><span>(-) Salidas (Gastos):</span> <span class="font-mono">-${{ number_format($activeSession->transactions()->where('type', 'salida')->sum('amount'), 2) }}</span></div>
                <div class="flex justify-between font-bold text-black border-t pt-2 mt-2"><span>(=) Total Esperado en Caja:</span> <span class="font-mono" id="calculated-balance" data-amount="{{ $calculatedBalance }}">${{ number_format($calculatedBalance, 2) }}</span></div>
            </div>
        </div>

        <form method="POST" action="{{ route('pos.close_cash_register.store') }}">
            @csrf
            <div>
                <label for="closing_balance" class="text-sm font-medium text-gray-700">Monto Físico Contado</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"><span class="text-gray-500">$</span></div>
                    <input type="number" name="closing_balance" id="closing_balance" step="0.01" required class="w-full py-3 pl-7 pr-12 text-lg text-right border-gray-300 rounded-md">
                </div>
            </div>
            
            <div class="p-4 border rounded-lg bg-yellow-50">
                <div class="flex justify-between font-bold text-yellow-800"><span>Diferencia:</span> <span class="font-mono" id="difference">$0.00</span></div>
            </div>

            <div>
                <label for="notes" class="text-sm font-medium text-gray-700">Notas (Opcional)</label>
                <textarea name="notes" id="notes" rows="3" class="w-full mt-1 border-gray-300 rounded-md" placeholder="Explique cualquier diferencia si es necesario..."></textarea>
            </div>

            <button type="submit" class="w-full px-4 py-3 font-semibold text-white bg-red-600 rounded-md hover:bg-red-700">
                Confirmar y Cerrar Caja
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#closing_balance').on('keyup', function() {
            const counted = parseFloat($(this).val()) || 0;
            const calculated = parseFloat($('#calculated-balance').data('amount')) || 0;
            const difference = counted - calculated;
            
            const diffElement = $('#difference');
            diffElement.text(`$${difference.toFixed(2)}`);
            
            diffElement.parent().removeClass('bg-yellow-50 text-yellow-800 bg-green-50 text-green-800 bg-red-50 text-red-800').addClass('text-yellow-800');
            if (difference > 0) {
                diffElement.parent().addClass('bg-green-50 text-green-800'); // Sobrante
            } else if (difference < 0) {
                diffElement.parent().addClass('bg-red-50 text-red-800'); // Faltante
            } else {
                diffElement.parent().addClass('bg-gray-50 text-gray-800'); // Exacto
            }
        });
    });
</script>
@endpush