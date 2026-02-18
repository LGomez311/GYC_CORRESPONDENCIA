🧪 GUÍA DE TESTING RÁPIDO - VALIDACIONES DE SEGURIDAD
===================================================

## 📌 PROBAR EN EL NAVEGADOR

### PASO 1: Abrir la página de Gestión de Empresas
1. Navega a: `/sadmin/empresas`
2. Haz clic en "Añadir Empresa"
3. Se debe abrir un modal con el formulario


### PASO 2: PROBAR VALIDACIONES EN TIEMPO REAL

#### Test 2.1: Campo Nombre Empresa
```
❌ Ingresa solo números: "123456"
   ✓ Debería ver error rojo y mensaje: "No puede ser solo números"

❌ Ingresa solo símbolos: "!!!###"
   ✓ Debería ver error rojo y mensaje: "No puede ser solo símbolos"

✅ Ingresa nombre válido: "Empresa XYZ"
   ✓ Debería ver borde verde y botón habilitarse
```

#### Test 2.2: Campo NIT
```
❌ Ingresa letras: "ABCDEF"
   ✓ Se limpia automáticamente (sin mostrar letras)

✅ Ingresa 6 dígitos: "123456"
   ✓ Borde verde, campo válido

❌ Ingresa 5 dígitos: "12345"
   ✓ Borde rojo, error: "Mínimo 6 dígitos"
```

#### Test 2.3: Campo Dirección
```
❌ Ingresa caracteres peligrosos: "Calle < > $ %"
   ✓ Borde rojo, error: "Caracteres no permitidos"

✅ Ingresa dirección válida: "Calle Principal 123"
   ✓ Borde verde, válido
```

#### Test 2.4: Campo Teléfono
```
❌ Ingresa letras: "Tel 123"
   ✓ Se limpia automáticamente (solo quedan números)

✅ Ingresa 7 dígitos: "3001234567"
   ✓ Borde verde, válido
```

#### Test 2.5: Campo Correo
```
❌ Ingresa correo inválido: "notanemail123"
   ✓ Borde rojo, error: "Correo inválido"

✅ Ingresa correo válido: "empresa@test.com"
   ✓ Borde verde, válido
```

#### Test 2.6: Botón Guardar Deshabilitado
```
1. Abre el modal de crear empresa
2. Inicialmente el botón debe estar GRIS/DESHABILITADO
3. Rellena todos los campos correctamente
4. El botón debe tornarse AZUL/HABILITADO
5. Deja un campo vacío
6. El botón vuelve a GRIS/DESHABILITADO
```


### PASO 3: PROBAR PROTECCIÓN CONTRA PASTE MALICIOSO

#### Test 3.1: Pegar XSS
```
1. Copia en tu portapapeles: <script>alert('xss')</script>
2. Haz clic en el campo Nombre
3. Intenta pegar (Ctrl+V)
4. ✅ Debería bloquearse y mostrar alerta: 
   "El contenido que intentas pegar contiene caracteres no válidos"
```

#### Test 3.2: Pegar SQL Injection
```
1. Copia: '; DROP TABLE empresas; --
2. Intenta pegar en cualquier campo
3. ✅ Debería bloquearse con la misma alerta
```

#### Test 3.3: Pegar texto seguro
```
1. Copia: Empresa Segura S.A.
2. Pega en el campo Nombre
3. ✅ Debería permitirse sin problemas
```


### PASO 4: PROBAR RATE LIMITING

#### Test 4.1: Intentar enviar múltiples veces
```
1. Rellena todos los campos correctamente
2. Haz clic en "Guardar"
3. La primera vez debería procesar normalmente
4. Espera a que termine (2 segundos)
5. Haz clic en "Guardar" nuevamente en menos de 30 segundos (3+ veces)
6. En el tercer/cuarto intento rápido debería ver:
   "Espera un momento - Espera antes de enviar nuevamente"
```


### PASO 5: PROBAR FORMULARIO DE EDITAR

#### Test 5.1: Abrir modal de editar
```
1. Ve a la tabla de empresas
2. Haz clic en el botón EDITAR (lápiz)
3. ✅ Se debe abrir el modal de editar con los datos de la empresa
4. ✅ Los bordes deben estar limpios (sin rojo/verde)
```

#### Test 5.2: Intentar guardar sin cambios
```
1. Abre un modal de editar
2. Sin cambiar nada, haz clic en "Guardar Cambios"
3. ✅ Debería ver: "Sin cambios - No hay cambios que guardar"
4. ✅ El servidor NO recibe la solicitud
```

#### Test 5.3: Cambiar un campo y guardar
```
1. Abre un modal de editar
2. Cambia el teléfono
3. Haz clic en "Guardar Cambios"
4. ✅ Si el cambio es válido, se debe guardar
5. ✅ Si es inválido, se debe mostrar error
```

#### Test 5.4: Validaciones en editar
```
1. Abre un modal de editar
2. Borra el campo nombre y deja vacío
3. ✅ Debe aparecer error rojo: "El nombre es obligatorio"
4. Ingresa solo números: "123456"
5. ✅ Debe aparecer error: "No puede ser solo números"
6. Ingresa XSS: <script>
7. ✅ Debe aparecer error: "Caracteres no permitidos"
```


### PASO 6: PROBAR EN CONSOLA DEL NAVEGADOR

#### Test 6.1: Validar funciones de seguridad
```javascript
// Abre consola (F12) en la página y ejecuta:

// Probar detección de XSS
SecurityLib.detectXSSAttempt('<script>alert("xss")</script>')
// ✅ Debe retornar: true

// Probar detección de SQL Injection
SecurityLib.detectSQLInjection("'; DROP TABLE--")
// ✅ Debe retornar: true

// Probar sanitización
SecurityLib.sanitizeString('<h1>Test</h1>')
// ✅ Debe retornar: "&lt;h1&gt;Test&lt;&#x2F;h1&gt;"

// Probar validación de regex
SecurityLib.validateAgainstWhitelist("123456", "nit")
// ✅ Debe retornar: true

// Probar rate limiting
SecurityLib.canSubmitForm()
// ✅ Primera vez: true
// Hacer clic 3+ veces rápido
SecurityLib.canSubmitForm()
// ✅ Debe retornar: false

// Ver logs de seguridad
SecurityLib.securityLogger.getLogs()
// ✅ Debe mostrar array con eventos registrados
```


### PASO 7: VALIDAR CSRF PROTECTION

#### Test 7.1: Verificar CSRF Token
```javascript
// En consola, ejecuta:
SecurityLib.validateCSRFToken()
// ✅ Debe retornar: true

// Obtener el token
SecurityLib.getCSRFToken()
// ✅ Debe retornar un string largo (token)
```


### PASO 8: PRUEBAS DE CASOS LÍMITE

#### Test 8.1: Campos con espacios
```
1. Nombre: "   Empresa   " (con espacios extras)
2. Al desenfocarse (blur), debe trimmed automáticamente
3. ✅ Resultado: "Empresa"
```

#### Test 8.2: Caracteres especiales permitidos
```
Nombre: "L&D Solutions Inc."
✅ Debe ser válido (& es permitido)

Correo: "john.doe+tag@company.co.uk"
✅ Debe ser válido (formato email correcto)
```

#### Test 8.3: Máximo de caracteres
```
Nombre: (string de 101 caracteres)
✅ Debe rechazar: "Máximo 100 caracteres"

NIT: (string de 16 dígitos)
✅ Debe rechazar: "Máximo 15 dígitos"
```


### PASO 9: TESTEAR EN DIFERENTES NAVEGADORES

```
✅ Chrome/Edge (Recomendado)
✅ Firefox
✅ Safari
✅ Mobile (iOS Safari o Chrome Mobile)
```


### PASO 10: TESTEAR CON DEVTOOLS

#### Test 10.1: Ver peticiones de red
```
1. Abre DevTools (F12)
2. Ve a pestaña "Network"
3. Intenta enviar formulario
4. ✅ Debes ver petición POST a /sadmin/empresas
5. ✅ Status debe ser 200, 201 o 422 (si hay errores)
```

#### Test 10.2: Ver Storage
```
1. DevTools > Application > Local Storage
2. ✅ No debes ver datos sensibles guardados
3. ✅ Solo debes ver datos de sesión necesarios
```

#### Test 10.3: Ver Console para advertencias
```
1. DevTools > Console
2. ✅ No debe haber errores JavaScript
3. ✅ Puede haber advertencias de development
```


🎯 PROPÓSITO DE CADA TEST:

Test 1-3: Validación de entrada limpia
Test 4-5: Protección contra inyecciones
Test 6: Rate limiting funciona
Test 7-10: Formulario editar independiente
Test 11-12: Casos límite y edge cases
Test 13-15: Cross-browser compatibility


📊 CHECKLIST DE VALIDACIÓN:

✅ Formulario crear funciona normalmente
✅ Validaciones en tiempo real funcionan
✅ Protección paste malicioso funciona
✅ Rate limiting funciona
✅ Formulario editar funciona
✅ Formulario editar no permite cambios sin cambios
✅ No hay errores en consola
✅ Sin breaking changes en formulario
✅ Funciona sin JavaScript deshabilitado (debería fallar gracefully)


⚠️ NOTAS IMPORTANTES:

1. Si algo no funciona:
   - Asegúrate de limpiar cache del navegador (Ctrl+Shift+R)
   - Comprueba que la página cargue correctamente
   - Verifica en consola si hay errores JavaScript
   - Comprueba la inspectión de elementos (F12)

2. Para las pruebas de XSS/SQL:
   - NO ejecutes código malicioso real
   - Solo prueba con strings de ejemplo
   - El objetivo es probar que se BLOQUEA correctamente

3. Las validaciones son client-side:
   - TAMBIÉN debes validar en el servidor (Laravel)
   - El usuario puede desactivar JavaScript
   - Siempre confía en validaciones del servidor


🎉 SI TODO FUNCIONA CORRECTAMENTE:

✅ Las validaciones están activas
✅ La seguridad está mejorada
✅ El formulario sigue funcionando como antes
✅ El usuario tiene mejor feedback
✅ Los ataques comunes están bloqueados

---

¿Preguntas o problemas? Revisa DOCUMENTACION_VALIDACIONES_SEGURIDAD.md
