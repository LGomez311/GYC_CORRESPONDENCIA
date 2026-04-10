@php
    $profileUser = null;
    $profileGuard = null;
    
    // Prioritize remitente if we are in that module
    if (request()->is('remitente*') || request()->is('ventanilla*') || auth('remitente')->check() && !auth('web')->check()) {
        if (auth('remitente')->check()) {
            $profileUser = auth('remitente')->user();
            $profileGuard = 'remitente';
        } elseif (auth('web')->check()) {
            $profileUser = auth('web')->user();
            $profileGuard = 'web';
        }
    } else {
        if (auth('web')->check()) {
            $profileUser = auth('web')->user();
            $profileGuard = 'web';
        } elseif (auth('remitente')->check()) {
            $profileUser = auth('remitente')->user();
            $profileGuard = 'remitente';
        }
    }
@endphp
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
                    <input type="hidden" name="current_guard" value="{{ $profileGuard }}">
                    <!-- Foto -->
                    <div class="flex flex-col items-center mb-6">
                        <div class="w-24 h-24 rounded-full bg-slate-100 dark:bg-gray-800 border-2 border-[#cfd7e7] dark:border-gray-700 overflow-hidden mb-3 relative group flex items-center justify-center" id="profileImagePreviewContainer">
                            @php
                                $userImg = ($profileGuard === 'web') ? ($profileUser->emple_img ?? null) : ($profileUser->rem_img ?? null);
                            @endphp
                            @if($profileUser && $userImg)
                                <img src="{{ asset('storage/' . $userImg) }}" class="w-full h-full object-cover" id="profileImagePreview">
                                <span class="material-symbols-outlined text-4xl text-gray-400 hidden" id="profileImagePlaceholder">person</span>
                            @else
                                <img src="" class="w-full h-full object-cover hidden" id="profileImagePreview">
                                <span class="material-symbols-outlined text-4xl text-gray-400" id="profileImagePlaceholder">person</span>
                            @endif
                            <label for="profile_img_input" class="absolute inset-0 bg-black/50 hidden group-hover:flex items-center justify-center cursor-pointer transition-all">
                                <span class="material-symbols-outlined text-white">photo_camera</span>
                            </label>
                        </div>
                        <input type="file" id="profile_img_input" name="profile_img" accept=".jpg,.jpeg,.png,.webp" class="hidden" onchange="previewProfileImage(event)">
                        <label for="profile_img_input" class="text-sm font-medium text-primary cursor-pointer hover:underline mb-1">Cambiar foto de perfil</label>
                        <p class="text-xs text-[#4c669a] dark:text-gray-400">Archivos: JPG, PNG, WEBP (Max 2MB)</p>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-2">Correo Electrónico</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">mail</span>
                            <input type="email" id="prof_email" name="{{ $profileGuard === 'web' ? 'emple_correo' : 'rem_correo' }}" 
                                value="{{ $profileUser ? ($profileGuard === 'web' ? $profileUser->emple_correo : $profileUser->rem_correo) : '' }}" required
                                class="w-full pl-10 pr-3 py-2 border border-[#cfd7e7] dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all dark:text-white">
                        </div>
                        <p id="error_prof_email" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>

                    <!-- Teléfono -->
                    <div class="mb-5">
                        <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-2">Número de Teléfono</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">call</span>
                            <input type="text" id="prof_tel" name="{{ $profileGuard === 'web' ? 'emple_tel' : 'rem_tel' }}" 
                                value="{{ $profileUser ? ($profileGuard === 'web' ? $profileUser->emple_tel : $profileUser->rem_tel) : '' }}" required
                                maxlength="15" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                placeholder="Ej: 3152782654"
                                class="w-full pl-10 pr-3 py-2 border border-[#cfd7e7] dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all dark:text-white">
                        </div>
                        <p id="error_prof_tel" class="text-xs text-red-500 mt-1 hidden"></p>
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
                <form id="formProfilePassword" onsubmit="submitProfilePassword(event)">
                    @csrf
                    <input type="hidden" name="current_guard" value="{{ $profileGuard }}">
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-[#0d121b] dark:text-white mb-2">Contraseña Anterior</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">lock_open</span>
                            <input type="password" id="old_prof_pass" name="password_old" required 
                                class="w-full pl-10 pr-10 py-2 border border-[#cfd7e7] dark:border-gray-700 bg-white dark:bg-gray-800 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary text-sm transition-all dark:text-white">
                            <button type="button" onclick="toggleProfPasswordVisibility('old_prof_pass', 'eye_old_prof_pass')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                <span id="eye_old_prof_pass" class="material-symbols-outlined text-[18px]">visibility</span>
                            </button>
                        </div>
                        <p id="error_old_prof_pass" class="text-xs text-red-500 mt-1 hidden"></p>
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
                        <p id="error_new_prof_pass" class="text-xs text-red-500 mt-1 hidden"></p>
                        <p class="text-xs text-[#4c669a] dark:text-gray-400 mt-1">Mínimo 10 caracteres, una mayúscula, una minúscula, un número y un símbolo.</p>
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
                        <p id="error_new_prof_pass_conf" class="text-xs text-red-500 mt-1 hidden"></p>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-[#cfd7e7] dark:border-gray-800">
                        @if ($profileGuard === 'web')
                            <a href="{{ route('empleado.password.forgot') }}" class="text-sm font-medium text-primary hover:underline">Olvidé mi contraseña</a>
                        @else
                            <span></span>
                        @endif
                        <button type="submit" id="btnSavePassword" class="px-5 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:bg-primary/90 flex items-center gap-2 transition-all">
                            Actualizar Contraseña
                        </button>
                    </div>
                </form>
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

    // Helper for Visual Validation
    function applyValidationStyle(input, isValid, errorElement, message = '') {
        if (!input) return isValid;
        
        if (isValid) {
            input.classList.remove('border-red-500', 'border-[#cfd7e7]', 'dark:border-gray-700');
            input.classList.add('border-blue-500');
            if (errorElement) {
                errorElement.classList.add('hidden');
                errorElement.textContent = '';
            }
        } else {
            input.classList.remove('border-blue-500', 'border-[#cfd7e7]', 'dark:border-gray-700');
            input.classList.add('border-red-500');
            if (errorElement) {
                errorElement.classList.remove('hidden');
                errorElement.textContent = message;
            }
        }
        return isValid;
    }

    // Real-time Listeners
    document.addEventListener('DOMContentLoaded', () => {
        const emailInput = document.getElementById('prof_email');
        const telInput = document.getElementById('prof_tel');
        const oldPass = document.getElementById('old_prof_pass');
        const newPass = document.getElementById('new_prof_pass');
        const confPass = document.getElementById('new_prof_pass_conf');

        if (emailInput) {
            emailInput.addEventListener('input', () => {
                const isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
                applyValidationStyle(emailInput, isValid, document.getElementById('error_prof_email'), 'Correo inválido');
            });
        }

        if (telInput) {
            telInput.addEventListener('input', () => {
                const val = telInput.value.trim();
                const isValid = val.length >= 7 && val.length <= 15 && /^[0-9]+$/.test(val);
                applyValidationStyle(telInput, isValid, document.getElementById('error_prof_tel'), '7-15 dígitos numéricos');
            });
        }

        if (oldPass) {
            oldPass.addEventListener('input', () => {
                applyValidationStyle(oldPass, oldPass.value.length > 0, document.getElementById('error_old_prof_pass'), 'Campo obligatorio');
            });
        }

        if (newPass) {
            newPass.addEventListener('input', () => {
                const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!"#$%&\/()=@.,;:?~^_*+\-])[^\s]{10,64}$/;
                applyValidationStyle(newPass, regex.test(newPass.value), document.getElementById('error_new_prof_pass'), 'Formato de seguridad insuficiente');
                if (confPass && confPass.value) confPass.dispatchEvent(new Event('input'));
            });
        }

        if (confPass) {
            confPass.addEventListener('input', () => {
                const isMatching = confPass.value === newPass.value && confPass.value.length > 0;
                applyValidationStyle(confPass, isMatching, document.getElementById('error_new_prof_pass_conf'), 'Las contraseñas no coinciden');
            });
        }
    });

    function submitProfileGeneral(e) {
        e.preventDefault();
        const form = e.target;
        
        const emailInput = document.getElementById('prof_email');
        const telInput = document.getElementById('prof_tel');
        
        const isEmailOk = emailInput ? /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value) : true;
        const isTelOk = telInput ? (telInput.value.trim().length >= 7 && telInput.value.trim().length <= 15 && /^[0-9]+$/.test(telInput.value.trim())) : true;

        applyValidationStyle(emailInput, isEmailOk, document.getElementById('error_prof_email'), 'Correo inválido');
        applyValidationStyle(telInput, isTelOk, document.getElementById('error_prof_tel'), '7-15 dígitos numéricos');

        if (!isEmailOk || !isTelOk) {
            Swal.fire('Atención', 'Por favor corrija los campos marcados en rojo.', 'warning');
            return;
        }

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


    function resetPasswordProcess() {
        document.getElementById('formProfilePassword').reset();
        ['old_prof_pass', 'new_prof_pass', 'new_prof_pass_conf'].forEach(id => {
            const el = document.getElementById(id);
            if(el) {
                el.classList.remove('border-red-500', 'border-blue-500');
                el.classList.add('border-[#cfd7e7]', 'dark:border-gray-700');
            }
            const err = document.getElementById('error_'+id);
            if(err) err.classList.add('hidden');
        });
    }

    function submitProfilePassword(e) {
        e.preventDefault();
        const form = e.target;
        const btn = document.getElementById('btnSavePassword');
        
        const oldPass = document.getElementById('old_prof_pass');
        const newPass = document.getElementById('new_prof_pass');
        const confPass = document.getElementById('new_prof_pass_conf');

        const isOldOk = oldPass.value.length > 0;
        const regexEstructura = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!"#$%&\/()=@.,;:?~^_*+\-])[^\s]{10,64}$/;
        const isNewOk = regexEstructura.test(newPass.value);
        const isConfOk = confPass.value === newPass.value && confPass.value.length > 0;

        applyValidationStyle(oldPass, isOldOk, document.getElementById('error_old_prof_pass'), 'Campo obligatorio');
        applyValidationStyle(newPass, isNewOk, document.getElementById('error_new_prof_pass'), 'Formato de seguridad insuficiente');
        applyValidationStyle(confPass, isConfOk, document.getElementById('error_new_prof_pass_conf'), 'Las contraseñas no coinciden');

        if (!isOldOk || !isNewOk || !isConfOk) {
            Swal.fire('Atención', 'Por favor corrija los campos marcados en rojo.', 'warning');
            return;
        }

        const formData = new FormData(form);
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
            
            if (msg.toLowerCase().includes('anterior') || msg.toLowerCase().includes('incorrecta')) {
                applyValidationStyle(oldPass, false, document.getElementById('error_old_prof_pass'), 'La contraseña es incorrecta');
            }
            
            Swal.fire('Error', msg, 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = 'Actualizar Contraseña';
        });
    }
</script>
