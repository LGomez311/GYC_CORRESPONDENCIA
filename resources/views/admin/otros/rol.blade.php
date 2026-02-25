@extends('admin.layouts.app')

@section('title', 'Gestión de Roles')

@section('content')
	<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

		<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">

			<div>
				<div class="mb-3">
					<a href="{{ route('admin.otros') }}"
						class="inline-flex items-center gap-2 px-4 py-2 
					bg-white dark:bg-[#161d2b]
					border border-[#cfd7e7] dark:border-gray-700
					text-[#4c669a] dark:text-gray-300
					rounded-lg text-sm font-medium
					hover:bg-gray-100 dark:hover:bg-gray-800
					transition-all duration-200">
						<span class="material-symbols-outlined text-[18px]">arrow_back</span>
						Regresar
					</a>
				</div>

				<h1 class="text-[#0d121b] dark:text-white text-2xl sm:text-3xl font-black tracking-tight">
					Gestión de Roles
				</h1>

				<p class="text-[#4c669a] dark:text-gray-400 text-sm sm:text-base">
					Administre los roles del sistema.
				</p>
			</div>

			<button onclick="openCreateModal()"
				class="w-full sm:w-auto px-5 py-2.5 bg-primary text-white rounded-lg 
			font-bold text-sm flex items-center justify-center gap-2 
			shadow-lg shadow-primary/20 
			hover:bg-primary/90 transition-all duration-200">
				<span class="material-symbols-outlined text-[18px]">add</span>
				Añadir Rol
			</button>
		</div>

		<div class="bg-white dark:bg-[#161d2b] rounded-xl border border-[#cfd7e7] dark:border-gray-800 shadow-sm">

			<div class="p-6 border-b border-[#cfd7e7] dark:border-gray-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
				<h2 class="text-[#0d121b] dark:text-white text-lg font-bold leading-tight">Roles Registrados</h2>
				<div class="flex gap-2">
					<button onclick="openExportModal()"
						class="px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 rounded-lg text-sm font-bold flex items-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors dark:text-white">
						<span class="material-symbols-outlined text-sm">download</span>
						Exportar
					</button>
				</div>
			</div>

			<div class="overflow-x-auto">
				<table class="min-w-full text-sm text-left border-collapse">
					<thead class="bg-background-light dark:bg-background-dark/50">
						<tr>
							<th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">ID</th>
							<th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Rol</th>
							<th class="px-4 sm:px-6 py-3 sm:py-4 text-xs font-bold text-[#4c669a] uppercase text-center">Acciones</th>
						</tr>
					</thead>

					<tbody class="divide-y divide-[#cfd7e7] dark:divide-gray-800">

						@foreach ($roles as $r)
							<tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">

								<td class="px-4 sm:px-6 py-3 sm:py-4 text-center dark:text-gray-300">{{ $r->id_rol }}</td>

								<td class="px-4 sm:px-6 py-3 sm:py-4 text-center font-bold text-[#0d121b] dark:text-white">{{ $r->rol_nom }}</td>

								<td class="px-4 sm:px-6 py-3 sm:py-4 text-center">
									<div class="flex items-center justify-center gap-2">
										<button onclick="openEditModal('{{ $r->id_rol }}','{{ $r->rol_nom }}')" class="p-2 text-[#4c669a] hover:text-primary transition">
											<span class="material-symbols-outlined text-[20px]">edit</span>
										</button>
									</div>
								</td>

							</tr>
						@endforeach

					</tbody>
				</table>
			</div>

			<div class="p-4 border-t border-[#cfd7e7] dark:border-gray-800">
				{{ $roles->links() }}
			</div>

		</div>
	</div>
@endsection


@section('modals')

	<!-- MODAL CREAR -->
	<div id="createModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
		<div class="bg-white dark:bg-gray-900 w-[95%] sm:w-full max-w-md rounded-xl shadow-2xl p-6">

			<h2 class="text-lg font-bold mb-4 dark:text-white">Crear Rol</h2>

			<form action="{{ route('admin.rol.store') }}" method="POST" id="createForm">
				@csrf

				<div class="mb-4">
					<label class="block text-sm font-medium mb-1">Nombre</label>
					<input type="text" id="rol_nom" name="rol_nom" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary">
				</div>

				<div class="flex justify-end gap-3">
					<button type="button" onclick="closeModals()" class="px-4 py-2 bg-gray-300 rounded-lg">Cancelar</button>
					<button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">Guardar</button>
				</div>
			</form>
		</div>
	</div>

	<!-- MODAL EDITAR -->
	<div id="editModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
		<div class="bg-white dark:bg-gray-900 w-[95%] sm:w-full max-w-md rounded-xl shadow-2xl p-6">

			<h2 class="text-lg font-bold mb-4 dark:text-white">Editar Rol</h2>

			<form id="editForm" method="POST">
				@csrf
				@method('PUT')

				<div class="mb-4">
					<label class="block text-sm font-medium mb-1">Nombre</label>
					<input type="text" id="edit_rol_nom" name="rol_nom" class="w-full px-3 py-2 border rounded-lg">
				</div>

				<div class="flex justify-end gap-3">
					<button type="button" onclick="closeModals()" class="px-4 py-2 bg-gray-300 rounded-lg">Cancelar</button>
					<button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg">Actualizar</button>
				</div>
			</form>
		</div>
	</div>

	<!-- MODAL EXPORTAR -->
	<div id="exportModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
		<div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg w-72 p-5">

			<h3 class="text-sm font-bold text-gray-800 dark:text-white mb-4">Exportar Roles</h3>

			<div class="flex flex-col gap-3">
				<a href="{{ route('admin.rol.export.pdf') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
					<span class="material-symbols-outlined text-red-600">picture_as_pdf</span>
					PDF
				</a>

				<a href="{{ route('admin.rol.export.excel') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold border rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
					<span class="material-symbols-outlined text-green-600">grid_on</span>
					Excel
				</a>
			</div>

			<button onclick="closeExportModal()" class="mt-4 w-full text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancelar</button>

		</div>
	</div>

@endsection


@section('scripts')
	<script>
		document.addEventListener('DOMContentLoaded', function() {

			function toggleModal(id, show) {
				const modal = document.getElementById(id);
				modal.classList.toggle('hidden', !show);
				modal.classList.toggle('flex', show);
			}

			window.openCreateModal = function() { toggleModal('createModal', true); }

			window.openEditModal = function(id, nombre) {
				let url = "{{ route('admin.rol.update', ['id' => '__ID__']) }}";
				url = url.replace('__ID__', id);
				document.getElementById('editForm').action = url;
				document.getElementById('edit_rol_nom').value = nombre;
				toggleModal('editModal', true);
			}

			window.closeModals = function() { toggleModal('createModal', false); toggleModal('editModal', false); }

			// Validaciones
			function mostrarError(input, mensaje) {
				input.classList.remove('border-green-500');
				input.classList.add('border-red-500');

				let error = input.parentNode.querySelector('.error-msg');

				if (!error) {
					error = document.createElement('p');
					error.classList.add('error-msg','text-red-500','text-sm','mt-1');
					input.parentNode.appendChild(error);
				}

				error.textContent = mensaje;
			}

			function limpiarError(input) {
				input.classList.remove('border-red-500');
				input.classList.add('border-green-500');

				let error = input.parentNode.querySelector('.error-msg');
				if (error) error.remove();
			}

			function validarNombre(input) {
				let valor = input.value.trim();

				valor = valor.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ ]+/g, '');
				valor = valor.replace(/\s{2,}/g, ' ');
				input.value = valor;

				if (valor === "") {
					mostrarError(input, "El nombre es obligatorio.");
					return false;
				}

				if (valor.length < 2) {
					mostrarError(input, "Debe tener mínimo 2 caracteres.");
					return false;
				}

				if (valor.length > 100) {
					mostrarError(input, "No puede superar 100 caracteres.");
					return false;
				}

				limpiarError(input);
				return true;
			}

			// Activar validación en crear/editar
			const inputCreate = document.getElementById('rol_nom');
			const btnCreate = document.querySelector('#createModal button[type="submit"]');

			if (inputCreate && btnCreate) {
				inputCreate.addEventListener('input', function() {
					const ok = validarNombre(this);
					btnCreate.disabled = !ok;
					btnCreate.classList.toggle('opacity-50', btnCreate.disabled);
					btnCreate.classList.toggle('cursor-not-allowed', btnCreate.disabled);
				});
			}

			const inputEdit = document.getElementById('edit_rol_nom');
			const btnEdit = document.querySelector('#editModal button[type="submit"]');

			if (inputEdit && btnEdit) {
				inputEdit.addEventListener('input', function() {
					const ok = validarNombre(this);
					btnEdit.disabled = !ok;
					btnEdit.classList.toggle('opacity-50', btnEdit.disabled);
					btnEdit.classList.toggle('cursor-not-allowed', btnEdit.disabled);
				});
			}

		});
	</script>

	<script>
		function openExportModal() { document.getElementById('exportModal').classList.remove('hidden'); document.getElementById('exportModal').classList.add('flex'); }
		function closeExportModal() { document.getElementById('exportModal').classList.add('hidden'); document.getElementById('exportModal').classList.remove('flex'); }
	</script>
@endsection
