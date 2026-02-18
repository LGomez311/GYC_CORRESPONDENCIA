# GUÍA DE VALIDACIONES DE SEGURIDAD - FORMULARIOS DE EMPRESAS

## 📋 Descripción General

Se han agregado múltiples capas de validación de seguridad a los formularios de crear y editar empresas sin afectar el funcionamiento existente. Las validaciones incluyen:

### 🔒 Capas de Seguridad Implementadas

1. **Sanitización de Entrada (XSS Protection)**
   - Escape de caracteres HTML peligrosos
   - Prevención de inyecciones de script directo
   
2. **Detección de SQL Injection**
   - Búsqueda de palabras clave SQL sospechosas
   - Detección de comentarios SQL
   - Validación de patrones peligrosos

3. **Rate Limiting**
   - Límite de 3 envíos por 30 segundos
   - Prevención de ataques de fuerza bruta
   - Mensaje de espera entre intentos

4. **Validación de Cambios**
   - En editar: Solo permite guardar si hay cambios reales
   - Detección de datos modificados
   - Confirmación antes de envíar

5. **Prevención de Paste Malicioso**
   - Validación al pegar contenido
   - Detección de patrones sospechosos en clipboard
   - Bloqueo de contenido malicioso

6. **CSRF Token Validation**
   - Verificación de tokens CSRF
   - Protección contra acciones falsificadas

## 🎯 Validaciones por Campo

### NOMBRE EMPRESA
- ✅ Mínimo 3 caracteres
- ✅ Máximo 100 caracteres
- ✅ No puede ser solo números
- ✅ No puede ser solo símbolos
- ✅ Sin caracteres XSS
- ✅ Sin patrones SQL injection

### NIT
- ✅ Solo números
- ✅ Mínimo 6 dígitos
- ✅ Máximo 15 dígitos
- ✅ Validación contra inyecciones

### DIRECCIÓN
- ✅ Mínimo 5 caracteres
- ✅ Máximo 150 caracteres
- ✅ Sin caracteres especiales peligrosos (<>$%{})
- ✅ Validación XSS

### TELÉFONO
- ✅ Solo números
- ✅ Mínimo 7 dígitos
- ✅ Máximo 15 dígitos

### CORREO
- ✅ Formato email válido
- ✅ Máximo 100 caracteres
- ✅ Validación contra XSS

## 📝 Características en Tiempo Real

### En el Formulario de CREAR Empresa:
```
✓ Validación en vivo (mientras escribes)
✓ Botón Guardar deshabilitado hasta que todos los campos sean válidos
✓ Indicadores visuales (borde rojo/verde)
✓ Mensajes de error personalizados
✓ Debe seleccionar un representante válido
```

### En el Formulario de EDITAR Empresa:
```
✓ Todas las validaciones del formulario de crear
✓ Detección de cambios reales
✓ Bloquea guardar si no hay cambios
✓ Sanitización de datos originales al abrir modal
✓ Limpieza de errores al abrir modal nuevamente
```

## 🔧 Cómo Usar el Script Avanzado

Si deseas usar las validaciones más avanzadas del archivo `form-security-validation.js`:

### 1. Incluir el script en el layout base (antes del cierre del body):

```html
<script src="{{ asset('js/form-security-validation.js') }}"></script>
```

### 2. Usar las funciones disponibles:

```javascript
// Validar contra SQL Injection
if (detectSQLInjection(userInput)) {
    console.error('SQL Injection detectado');
}

// Validar contra XSS
if (detectXSSAttempt(userInput)) {
    console.error('XSS detectado');
}

// Rate limiting
if (canSubmitForm()) {
    // Permitir envío
} else {
    const remainingTime = getFormSubmitRemainingTime();
    console.log(`Espera ${remainingTime}ms antes de enviar`);
}

// Sanitizar datos completos
const result = validateAndSanitizeFormData({
    nombre: userInputNombre,
    nit: userInputNIT,
    correo: userInputCorreo
});

if (!result.isValid) {
    console.log('Errores:', result.errors);
}

// Monitoreo de cambios
const monitor = new FormChangeMonitor('formularioId');
console.log('Cambios detectados:', monitor.getChanges());

// Obtener logs de seguridad
console.log(SecurityLib.securityLogger.getLogs());
```

## 🛡️ Protecciones Contra Ataques

### XSS (Cross-Site Scripting)
- ❌ `<script>alert('xss')</script>`
- ❌ `<img src=x onerror=alert('xss')>`
- ❌ `javascript:alert('xss')`

**Protección**: Sanitización de HTML, detección de event handlers

### SQL Injection
- ❌ `'; DROP TABLE empresas; --`
- ❌ `1' UNION SELECT * FROM users --`
- ❌ `admin' OR '1'='1`

**Protección**: Detección de palabras clave SQL, caracteres especiales

### Rate Limiting
- ❌ Múltiples envíos en corto tiempo
- ❌ Ataques de fuerza bruta
- ❌ Spam de formularios

**Protección**: Límite de 3 intentos cada 30 segundos

## ⚙️ Configuración

### Cambiar límite de rate limiting

En `empresas.blade.php`, busca:
```javascript
const FORM_SUBMIT_COOLDOWN = 2000; // 2 segundos
```

O en `form-security-validation.js`:
```javascript
const formSubmitLimiter = new RateLimiter(3, 30000); // 3 intentos cada 30 segundos
```

### Personalizar patrones de validación

En `form-security-validation.js`:
```javascript
const WHITELIST_PATTERNS = {
    nombre_empresa: /^[a-záéíóúñA-ZÁÉÍÓÚÑ0-9\s\.\-\&]{3,100}$/,
    // Personalizar según necesidad...
};
```

## 📊 Logging de Seguridad

El sistema registra eventos de seguridad. Para acceder a los logs:

```javascript
// En consola del navegador:
SecurityLib.securityLogger.getLogs() // Ver todos los logs

// Exportar logs
console.log(SecurityLib.securityLogger.exportLogs())

// Limpiar logs
SecurityLib.securityLogger.clearLogs()
```

## 🚀 Mejoras Futuras Sugeridas

1. **Backend**: Agregar validaciones en el servidor (Laravel)
   ```php
   // En EmpresaController
   $validated = $request->validate([
       'nomb_empresa' => 'required|string|max:100|regex:/^[a-záéíóúñA-ZÁÉÍÓÚÑ0-9\s\.\-\&]*$/',
       'nit_empresa' => 'required|numeric|digits_between:6,15|unique:empresas',
       'direccion' => 'required|string|max:150',
       'contacto' => 'required|numeric|digits_between:7,15',
       'empresa_correo' => 'required|email|max:100'
   ]);
   ```

2. **Base de datos**: Preparar sentencias SQL
   ```php
   // Usar Eloquent ORM (ya lo hace automáticamente)
   // Asegurarse de NO ejecutar raw queries
   ```

3. **Auditoría**: Registrar cambios
   ```php
   // Implementar auditoría con paquetes como:
   // - spatie/laravel-activity-log
   // - owen-it/laravel-auditing
   ```

4. **2FA**: Autenticación de dos factores
   - Confirmar cambios críticos con OTP

5. **IP Whitelist**: Restricción de IPs conocidas

6. **Encryption**: Cifrar datos sensibles en tránsito

## 🐛 Troubleshooting

### Problema: Los errores no aparecen
**Solución**: Asegurar que los elementos con id `error-{nombreCampo}` existan en el HTML

### Problema: El botón Guardar siempre está deshabilitado
**Solución**: Verificar que el select de representante tiene una opción válida seleccionada

### Problema: No puedo pegar contenido
**Solución**: Es una protección. Intenta escribir manualmente o disminuye la validación de paste

### Problema: El formulario tarda mucho en responder
**Solución**: Verificar que no hay JavaScript pesado. Las validaciones son ligeras (<10ms)

## 📄 Archivos Modificados

1. **`resources/views/sadmin/empresas.blade.php`**
   - Agregadas funciones de seguridad
   - Mejoradas validaciones del formulario crear
   - Agregadas validaciones al formulario editar
   - Sanitización de datos en modales

2. **`public/js/form-security-validation.js`** (Nuevo)
   - Librería completa de seguridad
   - Funciones avanzadas de validación
   - Rate limiting
   - Logging

## ✅ Testing Recomendado

```javascript
// Probar en consola:

// 1. Validar XSS detection
SecurityLib.detectXSSAttempt('<script>alert("xss")</script>') // true

// 2. Validar SQL detection
SecurityLib.detectSQLInjection("'; DROP TABLE--") // true

// 3. Validar sanitización
SecurityLib.sanitizeString("<h1>Test</h1>") // "&lt;h1&gt;Test&lt;&#x2F;h1&gt;"

// 4. Validar whitelist
SecurityLib.validateAgainstWhitelist("123456", "nit") // true

// 5. Validar rate limiting
SecurityLib.canSubmitForm() // true/false según intentos recientes
```

## 📞 Soporte

Para reportar problemas o sugerencias, documenta:
- Navegador y versión
- Pasos para reproducir
- Mensaje de error (si existe)
- Valores de entrada usados
