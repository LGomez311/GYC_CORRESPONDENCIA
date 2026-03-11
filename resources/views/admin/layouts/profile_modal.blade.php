<!-- Global User Settings Modal -->
<div id="userProfileModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-[100]">
    <div class="bg-white dark:bg-[#161d2b] w-[95%] sm:w-full max-w-lg rounded-xl shadow-2xl overflow-hidden flex flex-col">
        <!-- Header -->
        <div class="flex items-center justify-between p-4 border-b border-[#cfd7e7] dark:border-gray-800">
            <h2 class="text-lg font-bold text-[#0d121b] dark:text-white">Ajustes de Perfil</h2>
            <button onclick="closeUserProfileModal()" class="text-gray-500 hover:text-red-500 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto max-h-[75vh]">
            <!-- Tabs Menu -->
            <div class="flex items-center gap-4 border-b border-[#cfd7e7] dark:border-gray-800 mb-6">
                <button type="button" onclick="switchProfileTab('general')" id="tabBtnGeneral" class="pb-2 text-sm font-bold border-b-2 border-primary text-primary transition-colors">
                    General
                </button>
                <button type="button" onclick="switchProfileTab('password')" id="tabBtnPassword" class="pb-2 text-sm font-bold border-b-2 border-transparent text-[#4c669a] dark:text-gray-400 hover:text-primary transition-colors">
                    Contraseña
                </button>
            </div>

            <!-- Tab: General -->
            <div id="tabContentGeneral" class="block">
                <form id="formProfileGeneral" onsubmit="submitProfileGeneral(event)">
                    @csrf
                    <!-- Foto -->
                    <div class="flex flex-col items-center mb-6">
                        <div class="w-24 h-24 rounded-full bg-slate-100 dark:bg-gray-800 border-2 border-[#cfd7e7] dark:border-gray-700 overflow-hidden mb-3 relative group flex items-center justify-center" id="profileImagePreviewContainer">
                            @if(auth('web')->user()->emple_img)
                                <img src="{{ asset('storage/' . auth('web')->user()->emple_img) }}" class="w-full h-full object-cover" id="profileImagePreview">
                                <span class="material-symbols-outlined text-4xl text-gray-400 hidden" id="profileImagePlaceholder">person</span>
                            @else
                                <img src="" class="w-full h-full object-cover hidden" id="profileImagePreview">
                                <span class="material-symbols-outlined text-4xl text-gray-400" id="profileImagePlaceholder">person</span>
                            @endif
                            <label for="profile_img_input" class="absolute inset-0 bg-black/50 hidden group-hover:flex items-center justify-center cursor-pointer transition-all">
                                <span class="material-symbols-outlined text-white">photo_camera</span>
                            </label>
                        </div>
                        <input type="file" id="profile_img_input" name="emple_img" accept=".jpg,.jpeg,.png,.webp" class="hidden" onchange="previewProfileImage(event)">
                        <label for="profile_img_input" class="text-sm font-medium text-primary cursor-pointer hover:underline mb-1">Cambiar foto de perfil</label>
                        <p class="text-xs text-[#4c669a] dark:text-gray-400">Archivos: JPG, PNG, WEBP (Max 2MB)</p>
                    </div>

                    <!-- Email -->
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-2">Correo Electrónico</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">mail</span>
                            <input type="email" name="emple_correo" value="{{ auth('web')->user()->emple_correo }}" required
                                class="w-full pl-10 pr-3 py-2 border border-[#cfd7e7] dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all dark:text-white">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-[#cfd7e7] dark:border-gray-800">
                        <button type="submit" id="btnSaveGeneral" class="mt-2 px-5 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-primary/90 flex items-center gap-2 transition-all">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tab: Password -->
            <div id="tabContentPassword" class="hidden">
                <div id="passwordStep1" class="text-center py-4">
                    <span class="material-symbols-outlined text-4xl text-primary mb-3">lock_reset</span>
                    <h3 class="text-lg font-bold text-[#0d121b] dark:text-white mb-2">Cambiar Contraseña</h3>
                    <p class="text-sm text-[#4c669a] dark:text-gray-400 mb-6 px-4">
                        Por seguridad, necesitamos enviar un código de verificación a tu correo electrónico para que puedas cambiar tu contraseña.
                    </p>
                    <button type="button" onclick="sendVerificationCode()" id="btnSendCode" class="px-6 py-2.5 bg-primary text-white rounded-lg text-sm font-bold hover:bg-primary/90 flex items-center justify-center gap-2 mx-auto transition-all w-full sm:w-auto">
                        <span class="material-symbols-outlined text-sm">send</span>
                        Enviar código de verificación
                    </button>
                </div>

                <div id="passwordStep2" class="hidden">
                    <form id="formProfilePassword" onsubmit="submitProfilePassword(event)">
                        <p class="text-sm text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/20 p-3 rounded-lg border border-green-200 dark:border-green-800 mb-5 flex items-start gap-2">
                            <span class="material-symbols-outlined text-base mt-0.5">check_circle</span>
                            Código enviado a tu correo. Por favor, introdúcelo a continuación.
                        </p>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-2">Código de 6 dígitos</label>
                            <input type="text" name="code" required minlength="6" maxlength="6" pattern="[0-9]{6}" autocomplete="off"
                                class="w-full px-3 py-2 border border-[#cfd7e7] dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm text-center tracking-[0.5em] font-bold transition-all dark:text-white">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-2">Nueva Contraseña</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">lock</span>
                                <input type="password" id="new_prof_pass" name="password" required 
                                    class="w-full pl-10 pr-10 py-2 border border-[#cfd7e7] dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all dark:text-white">
                                <button type="button" onclick="toggleProfPasswordVisibility('new_prof_pass', 'eye_new_prof_pass')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <span id="eye_new_prof_pass" class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>
                            </div>
                            <p class="text-xs text-[#4c669a] dark:text-gray-400 mt-1">Mínimo 10 caracteres, mayúscula, minúscula, número y símbolo.</p>
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-2">Confirmar Contraseña</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">lock</span>
                                <input type="password" id="new_prof_pass_conf" name="password_confirmation" required 
                                    class="w-full pl-10 pr-10 py-2 border border-[#cfd7e7] dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all dark:text-white">
                                <button type="button" onclick="toggleProfPasswordVisibility('new_prof_pass_conf', 'eye_new_prof_pass_conf')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <span id="eye_new_prof_pass_conf" class="material-symbols-outlined text-[18px]">visibility</span>
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-4 border-t border-[#cfd7e7] dark:border-gray-800">
                            <button type="button" onclick="resetPasswordProcess()" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Volver</button>
                            <button type="submit" id="btnSavePassword" class="px-5 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-primary/90 flex items-center gap-2 transition-all">
                                Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function openUserProfileModal() {
        document.getElementById('userProfileModal').classList.remove('hidden');
        document.getElementById('userProfileModal').classList.add('flex');
        switchProfileTab('general');
    }

    function closeUserProfileModal() {
        document.getElementById('userProfileModal').classList.add('hidden');
        document.getElementById('userProfileModal').classList.remove('flex');
        setTimeout(() => resetPasswordProcess(), 300);
    }

    function switchProfileTab(tab) {
        const genTab = document.getElementById('tabContentGeneral');
        const passTab = document.getElementById('tabContentPassword');
        const btnGen = document.getElementById('tabBtnGeneral');
        const btnPass = document.getElementById('tabBtnPassword');

        if(tab === 'general') {
            genTab.style.display = 'block';
            passTab.style.display = 'none';
            btnGen.classList.replace('border-transparent', 'border-primary');
            btnGen.classList.replace('text-[#4c669a]', 'text-primary');
            btnGen.classList.replace('dark:text-gray-400', 'text-primary');
            
            btnPass.classList.replace('border-primary', 'border-transparent');
            btnPass.classList.replace('text-primary', 'text-[#4c669a]');
            if (document.documentElement.classList.contains('dark')) {
                btnPass.classList.add('dark:text-gray-400');
            }
        } else {
            genTab.style.display = 'none';
            passTab.style.display = 'block';
            
            btnPass.classList.replace('border-transparent', 'border-primary');
            btnPass.classList.replace('text-[#4c669a]', 'text-primary');
            btnPass.classList.replace('dark:text-gray-400', 'text-primary');
            
            btnGen.classList.replace('border-primary', 'border-transparent');
            btnGen.classList.replace('text-primary', 'text-[#4c669a]');
            if (document.documentElement.classList.contains('dark')) {
                btnGen.classList.add('dark:text-gray-400');
            }
        }
    }

    function previewProfileImage(event) {
        const file = event.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire('Error', 'La imagen es muy pesada. Máximo 2MB.', 'error');
                event.target.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('profileImagePreview');
                const placeholder = document.getElementById('profileImagePlaceholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    function toggleProfPasswordVisibility(inputId, iconId) {
        let input = document.getElementById(inputId);
        let icon = document.getElementById(iconId);
        if (input.type === "password") {
            input.type = "text";
            icon.innerText = "visibility_off";
        } else {
            input.type = "password";
            icon.innerText = "visibility";
        }
    }

    function submitProfileGeneral(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const btn = document.getElementById('btnSaveGeneral');
        
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-sm">hourglass_empty</span> Guardando...';

        fetch("{{ route('admin.profile.update') }}", {
            method: "POST",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: formData
        })
        .then(async res => {
            const data = await res.json();
            if(!res.ok) throw data;
            return data;
        })
        .then(data => {
            if(data.success) {
                Swal.fire({icon: 'success', title: 'Éxito', text: data.message, timer: 2000, showConfirmButton: false});
                setTimeout(() => window.location.reload(), 1500);
            }
        })
        .catch(err => {
            let msg = err.message || 'Error al actualizar el perfil.';
            if(err.errors) {
                msg = Object.values(err.errors).flat().join('\n');
            }
            Swal.fire('Error', msg, 'error');
            btn.disabled = false;
            btn.innerHTML = 'Guardar Cambios';
        });
    }

    function sendVerificationCode() {
        const btn = document.getElementById('btnSendCode');
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-sm">hourglass_empty</span> Enviando...';

        fetch("{{ route('admin.profile.send_code') }}", {
            method: "POST",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        })
        .then(async res => {
            const data = await res.json();
            if(!res.ok) throw data;
            return data;
        })
        .then(data => {
            if(data.success) {
                document.getElementById('passwordStep1').classList.add('hidden');
                document.getElementById('passwordStep2').classList.remove('hidden');
            }
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-sm">send</span> Enviar código de verificación';
        })
        .catch(err => {
            Swal.fire('Error', err.message || 'Ocurrió un error inesperado al enviar el código.', 'error');
            btn.disabled = false;
            btn.innerHTML = '<span class="material-symbols-outlined text-sm">send</span> Enviar código de verificación';
        });
    }

    function resetPasswordProcess() {
        document.getElementById('passwordStep1').classList.remove('hidden');
        document.getElementById('passwordStep2').classList.add('hidden');
        document.getElementById('formProfilePassword').reset();
    }

    function submitProfilePassword(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const btn = document.getElementById('btnSavePassword');
        
        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-sm">hourglass_empty</span> Actualizando...';

        fetch("{{ route('admin.profile.update_password') }}", {
            method: "POST",
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body: formData
        })
        .then(async res => {
            const data = await res.json();
            if(!res.ok) throw data;
            return data;
        })
        .then(data => {
            if(data.success) {
                Swal.fire({icon: 'success', title: 'Contraseña actualizada', text: data.message, timer: 3000, showConfirmButton: false});
                closeUserProfileModal();
            }
        })
        .catch(err => {
            let msg = err.message || 'Error al actualizar la contraseña.';
            if(err.errors) {
                msg = Object.values(err.errors).flat().join('\n');
            }
            Swal.fire('Error', msg, 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = 'Actualizar Contraseña';
        });
    }
</script>
