🧪 TESTING RÁPIDO - VALIDACIONES ADMINS
=====================================

## PROBAR VALIDACIONES DEL FORMULARIO DE ADMIN

### PASO 1: Abrir formulario de crear admin
1. Navega a: `/sadmin/admins`
2. Haz clic en "Crear Nuevo Admin"
3. Debe abrirse modal con campos vacíos


### PASO 2: VALIDACIONES EN TIEMPO REAL

#### Test 2.1: Campo Documento
```
❌ Ingresa letras: "ABC123"
   ✓ Se limpia (solo quedan números: "123")

✅ Ingresa 8 números: "12345678"
   ✓ Aceptado, borde normal

❌ Intenta XSS: "12345'; DROP TABLE--"
   ✓ Detecta SQL injection, error mostrado
```

#### Test 2.2: Campo Nombres
```
❌ Ingresa solo números: "123456"
   ✓ Borde rojo, error: "No puede ser solo números"

❌ Ingresa con XSS: "Name<script>"
   ✓ Se limpia y detecta XSS
   ✓ Borde rojo, error: "Caracteres no permitidos"

✅ Ingresa nombre válido: "Juan Carlos"
   ✓ Borde verde, automáticamente con mayúsculas: "Juan Carlos"
```

#### Test 2.3: Campo Apellidos
```
✅ Ingresa: "rodriguez gutierrez"
   ✓ Automático → "Rodriguez Gutierrez"
   ✓ Borde verde

❌ Intenta XSS: "smith<img src=x onerror=alert()>"
   ✓ Se limpia, elimina tags
   ✓ Borde rojo
```

#### Test 2.4: Campo Teléfono
```
❌ Ingresa 9 dígitos: "123456789"
   ✓ Borde rojo, error: "Máximo 10 dígitos"

✅ Ingresa 10 dígitos: "3001234567"
   ✓ Borde verde, válido

❌ Intenta letras: "300ABC1234"
   ✓ Se limpia (solo números: "3001234")
```

#### Test 2.5: Campo Correo
```
❌ Ingresa sin @: "juantest.com"
   ✓ Borde rojo, error: "Correo inválido"

❌ Intenta XSS: "juan@test.com<script>"
   ✓ Detecta XSS
   ✓ Borde rojo

✅ Ingresa válido: "juan@empresa.com"
   ✓ Borde verde
```

#### Test 2.6: Campo Contraseña
```
❌ Ingresa muy corta: "Pass1"
   ✓ Borde rojo, error: "Mín 8 caracteres"

❌ Ingresa sin números: "Password"
   ✓ Error: "3 números requeridos"

✅ Ingresa válida: "Password123"
   ✓ Borde verde
```

#### Test 2.7: Botón Guardar
```
1. Abre modal de crear
2. Inicialmente botón está GRIS/DESHABILITADO
3. Rellena TODOS los campos correctamente
4. Botón se torna AZUL/HABILITADO
5. Deja un campo mal (ej: solo 5 dígitos en teléfono)
6. Botón vuelve a GRIS/DESHABILITADO
```


### PASO 3: PROTECCIÓN CONTRA PASTE MALICIOSO

#### Test 3.1: Pegar XSS en nombres
```
1. Copia: <script>alert('xss')</script>
2. Haz clic en campo "Nombres"
3. Intenta pegar (Ctrl+V)
4. ✅ Se bloquea, alerta: "El contenido que intentas pegar contiene caracteres no válidos"
```

#### Test 3.2: Pegar SQL Injection en correo
```
1. Copia: admin@test.com'; DROP TABLE--
2. Intenta pegar en "Correo"
3. ✅ Se bloquea con alerta de seguridad
```

#### Test 3.3: Pegar texto seguro
```
1. Copia: juan.perez@empresa.com
2. Pega en campo "Correo"
3. ✅ Se permite sin problema
```


### PASO 4: RATE LIMITING

#### Test 4.1: Múltiples envíos rápidos
```
1. Rellena todos los campos del crear
2. Haz clic en "Registrar Usuario"
3. Espera a que procese (~2 segundos)
4. Intenta clickear nuevamente, rápido (3+ veces en <30 segundos)
5. ✅ En el 3er-4to intento: "Espera un momento - Espera antes de enviar"
```


### PASO 5: FORMULARIO DE EDITAR ADMIN

#### Test 5.1: Abrir modal editar
```
1. Ve a la tabla de admins
2. Haz clic en botón EDITAR (lápiz)
3. ✅ Se abre modal con datos del admin
4. ✅ Campos sin bordes rojo/verde (limpios)
```

#### Test 5.2: Intentar guardar sin cambios
```
1. Abre modal de editar
2. No cambies nada
3. Haz clic en "Actualizar Usuario"
4. ✅ Alerta: "Sin cambios - No hay cambios que guardar"
5. ✅ No se envía la solicitud al servidor
```

#### Test 5.3: Cambiar un campo y guardar
```
1. Abre modal de editar
2. Cambia el teléfono
3. Haz clic en "Actualizar Usuario"
4. ✅ Si es válido, se guarda
5. ✅ Si es inválido (< 10 dígitos), muestra error
```

#### Test 5.4: Validaciones de seguridad en editar
```
1. Abre modal de editar
2. Borra nombres y deja vacío
3. ✅ Error: "El nombre es obligatorio"

4. Ingresa solo números: "123456"
5. ✅ Error: "No puede ser solo números"

6. Intenta XSS en nombres: "Juan<script>alert()</script>"
7. ✅ Se limpia, detecta XSS
8. ✅ Error: "Caracteres no permitidos"
```

#### Test 5.5: Cambios múltiples
```
1. Abre modal de editar
2. Cambia: Nombres + Apellidos + Teléfono
3. Guarda
4. ✅ Si todos son válidos, se guardan los cambios
5. ✅ Si uno es inválido, se bloquea y muestra errores
```


### PASO 6: MODAL VER PERFIL

#### Test 6.1: Abrir perfil
```
1. En la tabla de admins, haz clic en ojo (ver detalles)
2. ✅ Se abre modal mostrando datos del usuario
3. ✅ Foto se carga correctamente
```

#### Test 6.2: Sanitización de datos (xss protection)
```
1. (En backend) Crear admin con nombre: "Test<script>"
2. Abre su perfil
3. ✅ Se muestra como "Test&lt;script&gt;" (escapado)
4. ✅ NO ejecuta el script
```


### PASO 7: EN CONSOLA DEL NAVEGADOR

#### Test 7.1: Probar funciones de seguridad
```javascript
// Abre consola (F12) y ejecuta:

// Detectar XSS
detectXSSAttempt('<script>alert("xss")</script>')
// ✅ Debe retornar: true

// Detectar SQL Injection
detectSQLInjection("'; DROP TABLE--")
// ✅ Debe retornar: true

// Sanitizar
sanitizeString('<h1>Admin</h1>')
// ✅ Debe retornar: "&lt;h1&gt;Admin&lt;&#x2F;h1&gt;"

// Rate limiting
canSubmitForm()
// ✅ Primera vez: true
// Hacer clic 3+ veces rápido
canSubmitForm()
// ✅ Debe retornar: false en el tercero/cuarto
```


### PASO 8: CASOS LÍMITE

#### Test 8.1: Espacios extras
```
Nombres: "   Juan   " (con espacios)
Al desenfocarse → Se trimea a: "Juan"
✅ Se auto-sanitiza
```

#### Test 8.2: Caracteres especiales permitidos
```
Nombres: "José María O'Connor"
✅ Válido (letras con acentos y caracteres permitidos)

Correo: "juan.perez+admin@company.co.uk"
✅ Válido (email correcto con caracteres permitidos)
```

#### Test 8.3: Máximo de caracteres
```
Documento: (string de 15+ dígitos)
✅ Solo acepta los primeros 12 dígitos

NIT Empresa: Debe ser seleccionado (obligatorio)
✅ Sin selección, no permite guardar
```


### PASO 9: TESTEAR EN DIFERENTES NAVEGADORES

```
✅ Chrome/Edge
✅ Firefox
✅ Safari
✅ Mobile (iOS Safari o Chrome Mobile)
```


### PASO 10: DEVTOOLS

#### Test 10.1: Ver peticiones de red
```
1. DevTools (F12) > Network
2. Ingresa admin nuevo y envía
3. ✅ Petición POST a /sadmin/admins
4. ✅ Status 200/201 exitoso o 422 validación
```

#### Test 10.2: Ver Console
```
1. DevTools > Console
2. ✅ No debe haber errores JavaScript
3. ✅ Puede haber advertencias dev
4. ✅ Logs de seguridad pueden aparecer
```


✅ CHECKLIST FINAL:

✅ Crear admin funciona normalmente
✅ Validaciones en tiempo real funcionan
✅ Protección paste malicioso funciona
✅ Rate limiting funciona (bloquea en 3/4 intento)
✅ Editar admin funciona
✅ Editar bloquea si no hay cambios
✅ Ver perfil sanitiza datos (sin XSS)
✅ Sin errores en consola
✅ Sin breaking changes en el formulario
✅ Funciona en múltiples navegadores


🎯 ATAQUES ESPECÍFICOS A PROBAR:

Admin injection attempts:
❌ "admin'; DROP TABLE--"
❌ "12345'; UPDATE users SET role=1--"

XSS en diferentes campos:
❌ <img src=x onerror=alert('xss')>
❌ <svg onload=alert('xss')>
❌ javascript:alert('xss')

Paste attacks:
❌ Pegar scripts completos
❌ Pegar SQL statements
❌ Pegar event handlers


⚠️ NOTAS IMPORTANTES:

1. Las validaciones client-side son la primera línea
2. El servidor DEBE validar también (no confiar solo en cliente)
3. Un usuario puede desactivar JavaScript
4. Estas validaciones mejoran UX y performance
5. Backend debe tener validaciones similares


📞 EN CASO DE PROBLEMAS:

1. Limpia cache del navegador (Ctrl+Shift+R)
2. Verifica que SweetAlert está cargado
3. Abre consola (F12) para ver errores
4. Comprueba que los modales existen en HTML
5. Verifica que la empresa está seleccionada en crear


🎉 SI TODO FUNCIONA CORRECTAMENTE:

✅ Formulario de admin está seguro
✅ Usuarios están protegidos contra XSS/SQL
✅ Experiencia es intuitiva y rápida
✅ Ataques comunes están bloqueados
✅ Sin afectar funcionamiento normal

---

Para más detalles de testing, ver: TESTING_GUIA_RAPIDA.md
Para documentación completa, ver: DOCUMENTACION_VALIDACIONES_SEGURIDAD.md
