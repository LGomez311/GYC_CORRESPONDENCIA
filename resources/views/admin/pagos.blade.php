@extends('admin.layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="w-full max-w-lg bg-white rounded-xl shadow-lg p-6">

            <!-- Título -->
            <h1 class="text-2xl font-bold text-gray-800 mb-4">
                Confirmar compra del plan
            </h1>

            <!-- Card del plan -->
            <div class="border rounded-lg p-4 bg-gray-50">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold text-gray-700">
                        {{ $plan->nomb_plan }}
                    </h2>
                    <span class="text-sm px-3 py-1 bg-blue-100 text-blue-700 rounded-full">
                        Activo
                    </span>
                </div>

                <div class="space-y-2 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Duración</span>
                        <span class="font-medium">{{ $plan->duracion }} días</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Precio del plan</span>
                        <span class="font-medium">
                            ${{ number_format($plan->valor, 0, ',', '.') }} COP
                        </span>
                    </div>

                    <div class="border-t pt-2 mt-2 flex justify-between text-base font-semibold text-gray-800">
                        <span>Total a pagar</span>
                        <span>
                            ${{ number_format($plan->valor, 0, ',', '.') }} COP
                        </span>
                    </div>
                </div>
            </div>

            <!-- Botón -->
            <div class="mt-6 flex gap-3">
                <button onclick="openModal()"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
                    Proceder al pago
                </button>

                <a href="{{ url()->previous() }}"
                    class="flex-1 text-center border border-gray-300 hover:bg-gray-100 text-gray-700 font-semibold py-3 rounded-lg transition">
                    Cancelar
                </a>
            </div>

            <!-- Nota -->
            <p class="text-xs text-gray-500 mt-4 text-center">
                Al continuar, confirmas la compra del plan seleccionado.
            </p>

        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }
    </script>
@endsection


@section('modals')
    <!-- Modal -->

    <div id="paymentModal" class="fixed inset-0 bg-black/60 flex items-center justify-center hidden z-50 px-4">

        <!-- Caja del modal -->
        <div class="bg-white rounded-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto p-6 shadow-2xl">

            <!-- Header -->
            <div class="mb-5 border-b pb-3">
                <h2 class="text-xl font-bold text-gray-800">
                    Confirmar pago del plan
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Completa el pago siguiendo los pasos indicados
                </p>
            </div>

            <!-- Info principal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                <!-- Detalles -->
                <div class="space-y-3 text-sm">
                    <p>
                        <strong>Plan:</strong><br>
                        {{ $plan->nomb_plan }}
                    </p>

                    <p>
                        <strong>Valor a pagar:</strong><br>
                        <span class="text-xl text-green-600 font-bold">
                            ${{ number_format($plan->valor, 0, ',', '.') }}
                        </span>
                    </p>

                    <!-- Pasos -->
                    <div class="bg-gray-50 rounded-lg p-3">
                        <h3 class="font-semibold text-gray-700 mb-2">
                            Pasos para pagar:
                        </h3>
                        <ol class="list-decimal list-inside text-gray-600 space-y-1">
                            <li>Escanea el código QR.</li>
                            <li>Envía el valor exacto desde cualquier banco.</li>
                            <li>Guarda el comprobante.</li>
                            <li>Adjúntalo y confirma el pago.</li>
                        </ol>
                    </div>
                </div>

                <!-- QR -->
                <div class="flex flex-col items-center justify-center">
                    <p class="font-semibold text-gray-700 mb-2 text-sm">
                        Escanea para pagar
                    </p>
                    <img src="{{ asset('storage/qr/qr.jpeg') }}" alt="Código QR de pago"
                        class="w-48 h-48 object-contain border rounded-xl shadow-sm">
                    <p class="text-xs text-gray-500 mt-2 text-center">
                        Disponible para pagos desde cualquier banco
                    </p>
                </div>
            </div>

            <!-- Formulario -->
            <form action="{{ route('pagos.store', $plan->id_plan) }}" method="POST" enctype="multipart/form-data"
                onsubmit="confirmarPago(event)">

                @csrf
                <input type="hidden" name="id_plan" value="{{ $plan->id_plan }}">

                <!-- Comprobante -->
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700 mb-1 text-sm">
                        Comprobante de pago
                    </label>
                    <input type="file" name="comprobante" class="w-full border rounded-lg p-2 text-sm">
                    <p class="text-xs text-gray-500 mt-1">
                        Puedes adjuntar una imagen o PDF del comprobante.
                    </p>
                </div>

                <!-- Aviso -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                    <p class="text-xs text-blue-700">
                        El pago será verificado por un administrador antes de activar la licencia.
                    </p>
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 border rounded-lg text-gray-600 hover:bg-gray-100 text-sm">
                        Cancelar
                    </button>

                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg font-semibold text-sm">
                        Confirmar pago
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function confirmarPago(event) {
            event.preventDefault(); // Evita el envío inmediato del formulario

            Swal.fire({
                title: '¿Confirmar pago?',
                text: '¿Confirmas que ya realizaste el pago del plan y deseas notificar a los administradores?\n\nTu pago será verificado antes de activar la licencia.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, ya pagué',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    event.target.submit(); // Envía el formulario si confirma
                }
            });
        }
    </script>
@endsection
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
