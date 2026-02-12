@extends('admin.layouts.app')

@section('content')
    <div class="p-6">
        <h1 class="text-2xl font-bold">Pago del Plan</h1>

        <p><strong>Plan:</strong> {{ $plan->nomb_plan }}</p>

        <p>
            <strong>Precio:</strong>
            <span id="precio">{{ $plan->valor }} COP</span>
        </p>

        <p><strong>Duración:</strong> {{ $plan->duracion }} días</p>
        <div class="mt-6">
            <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg">
                Proceder al pago
            </button>
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
    <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">

        <div class="bg-white rounded-xl w-full max-w-md p-6">
            <h2 class="text-xl font-bold mb-4">Confirmar pago</h2>

            <p class="mb-2">
                <strong>Plan:</strong> {{ $plan->nomb_plan }}
            </p>

            <p class="mb-2">
                <strong>Precio:</strong>
                <span class="text-green-600 font-semibold">
                    ${{ ($plan->valor) }}
                </span>
            </p>

            <p class="mb-4">
                <strong>Enviar pago a:</strong><br>

                <img src="{{ asset('storage/nequi/nequi.jpeg') }}" alt="Nequi" class="w-40">
            </p>

            <!-- Formulario -->
            <form action="{{ route('pagos.store', $plan->id_plan) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="id_plan" value="{{ $plan->id_plan }}">

                <!-- Comprobante -->
                <div class="mb-4">
                    <label class="block font-semibold mb-1">
                        Comprobante de pago (opcional)
                    </label>
                    <input type="file" name="comprobante" class="w-full border rounded-lg p-2">
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border rounded-lg">
                        Cancelar
                    </button>

                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                        Notificar al admin
                    </button>
                </div>
            </form>
        </div>
    </div>
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