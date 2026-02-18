/**
 * ========================================================
 * SEGURIDAD AVANZADA DE FORMULARIOS - EMPRESAS
 * ========================================================
 * Archivo con validaciones de seguridad adicionales
 * Incluye: Rate limiting, detección de patrones, CSRF token checking
 */

/**
 * ========================================================
 * 1. SANITIZACIÓN Y DETECCIÓN DE AMENAZAS
 * ========================================================
 */

/**
 * Sanitiza strings contra XSS
 */
function sanitizeString(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#x27;')
        .replace(/\//g, '&#x2F;');
}

/**
 * Sanitiza URLs para evitar javascript: protocol
 */
function sanitizeUrl(url) {
    if (!url) return '';
    // Rechazar URLs con javascript:, data:, vbscript:
    if (/^(javascript|data|vbscript):/i.test(url)) {
        return '';
    }
    return url;
}

/**
 * Detecta patrones de inyección SQL
 */
function detectSQLInjection(str) {
    if (!str) return false;
    
    const sqlPatterns = [
        // SQL keywords
        /(\b(UNION|SELECT|INSERT|UPDATE|DELETE|DROP|EXEC|EXECUTE|SCRIPT|ALERT|EVAL|LOAD_FILE|INTO_OUTFILE)\b)/gi,
        // SQL comment syntax
        /(-{2}|\/\*|\*\/)/g,
        // Statement terminators
        /(;[^;]*$)/g,
        // Dangerous functions
        /(javascript:|onerror=|onload=|onclick=|onmouseover=)/gi
    ];
    
    return sqlPatterns.some(pattern => {
        pattern.lastIndex = 0; // Reset regex
        return pattern.test(str);
    });
}

/**
 * Valida contra XSS (Cross-Site Scripting)
 */
function detectXSSAttempt(str) {
    if (!str) return false;
    
    const xssPatterns = [
        // Script tags
        /<script[^>]*>.*?<\/script>/gi,
        // Event handlers
        /on(load|error|click|mouse|focus|blur|change|submit)[^=]*=/gi,
        // JavaScript protocol
        /javascript:/gi,
        // IFrame injection
        /<iframe[^>]*>/gi,
        // Image with events
        /<img[^>]*on/gi,
        // SVG with events
        /<svg[^>]*on/gi,
        // Embed tags
        /<embed[^>]*>/gi,
        // Object tags
        /<object[^>]*>/gi,
        // Eval function
        /eval\(/gi,
        // Expression evaluation
        /expression\s*\(/gi
    ];
    
    return xssPatterns.some(pattern => {
        pattern.lastIndex = 0;
        return pattern.test(str);
    });
}

/**
 * Detecta posibles ataques LDAP Injection
 */
function detectLDAPInjection(str) {
    if (!str) return false;
    
    const ldapPatterns = [
        /[*()&|]/g, // LDAP wildcard and special chars
        /\x00/g // Null byte
    ];
    
    return ldapPatterns.some(pattern => {
        pattern.lastIndex = 0;
        return pattern.test(str);
    });
}

/**
 * Detecta Unicode/UTF-8 encoding attacks
 */
function detectUnicodeAttacks(str) {
    if (!str) return false;
    
    // Detectar secuencias UTF-8 sospechosas
    const unicodePatterns = [
        /\\u[0-9a-f]{4}/gi, // Unicode escape sequences
        /%[0-9a-f]{2}/gi // URL encoding
    ];
    
    return unicodePatterns.some(pattern => {
        pattern.lastIndex = 0;
        return pattern.test(str);
    });
}

/**
 * Valida entrada de usuario contra múltiples amenazas
 */
function validateSecurityThreats(fields = {}) {
    for (const [fieldName, value] of Object.entries(fields)) {
        if (!value) continue;

        // Detectar SQL Injection
        if (detectSQLInjection(value)) {
            return { 
                valid: false, 
                threat: 'SQL Injection', 
                field: fieldName,
                severity: 'CRITICAL'
            };
        }

        // Detectar XSS
        if (detectXSSAttempt(value)) {
            return { 
                valid: false, 
                threat: 'XSS Attack', 
                field: fieldName,
                severity: 'CRITICAL'
            };
        }

        // Detectar LDAP Injection (si el campo es para búsqueda)
        if (detectLDAPInjection(value)) {
            return { 
                valid: false, 
                threat: 'LDAP Injection', 
                field: fieldName,
                severity: 'HIGH'
            };
        }

        // Detectar Unicode attacks
        if (detectUnicodeAttacks(value)) {
            return { 
                valid: false, 
                threat: 'Unicode Attack', 
                field: fieldName,
                severity: 'MEDIUM'
            };
        }
    }
    return { valid: true };
}

/**
 * ========================================================
 * 2. RATE LIMITING Y THROTTLING
 * ========================================================
 */

class RateLimiter {
    constructor(maxAttempts = 5, timeWindow = 60000) {
        this.maxAttempts = maxAttempts;
        this.timeWindow = timeWindow; // milisegundos
        this.attempts = [];
    }

    isAllowed() {
        const now = Date.now();
        
        // Limpiar intentos antiguos
        this.attempts = this.attempts.filter(time => now - time < this.timeWindow);
        
        if (this.attempts.length >= this.maxAttempts) {
            return false;
        }
        
        this.attempts.push(now);
        return true;
    }

    getRemainingTime() {
        if (this.attempts.length === 0) return 0;
        
        const oldestAttempt = this.attempts[0];
        const elapsed = Date.now() - oldestAttempt;
        return Math.max(0, this.timeWindow - elapsed);
    }

    reset() {
        this.attempts = [];
    }
}

// Instancia para limitar envíos de formulario
const formSubmitLimiter = new RateLimiter(3, 30000); // 3 intentos cada 30 segundos

function canSubmitForm() {
    return formSubmitLimiter.isAllowed();
}

function getFormSubmitRemainingTime() {
    return formSubmitLimiter.getRemainingTime();
}

/**
 * ========================================================
 * 3. VALIDACIÓN DE CSRF TOKEN
 * ========================================================
 */

function validateCSRFToken() {
    const token = document.querySelector('input[name="_token"]');
    return token && token.value && token.value.length > 0;
}

function getCSRFToken() {
    return document.querySelector('input[name="_token"]')?.value;
}

/**
 * Verifica que todos los formularios tengan CSRF token
 */
function ensureAllFormsHaveCSRFToken() {
    document.querySelectorAll('form').forEach(form => {
        if (!form.querySelector('input[name="_token"]')) {
            console.warn('⚠️ Formulario sin CSRF token:', form);
        }
    });
}

/**
 * ========================================================
 * 4. VALIDACIÓN DE ENTRADA CON WHITELIST
 * ========================================================
 */

const WHITELIST_PATTERNS = {
    nombre_empresa: /^[a-záéíóúñA-ZÁÉÍÓÚÑ0-9\s\.\-\&]{3,100}$/,
    nit: /^[0-9]{6,15}$/,
    telefono: /^[0-9]{7,15}$/,
    correo: /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/,
    direccion: /^[a-záéíóúñA-ZÁÉÍÓÚÑ0-9\s\#\-\,\.]{5,150}$/,
    url: /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/
};

/**
 * Valida un valor contra un patrón whitelist
 */
function validateAgainstWhitelist(value, fieldType) {
    if (!WHITELIST_PATTERNS[fieldType]) {
        console.warn(`Tipo de campo desconocido: ${fieldType}`);
        return false;
    }
    
    return WHITELIST_PATTERNS[fieldType].test(value);
}

/**
 * ========================================================
 * 5. VALIDACIÓN DE ENTROPÍA Y PATRONES
 * ========================================================
 */

/**
 * Calcula la entropía de una cadena (detecta strings aleatorios/cifrados)
 */
function calculateEntropy(str) {
    const len = str.length;
    let entropy = 0;
    
    for (let i = 0; i < 256; i++) {
        const char = String.fromCharCode(i);
        const freq = (str.match(new RegExp(char, 'g')) || []).length;
        const p = freq / len;
        
        if (p > 0) {
            entropy -= p * Math.log2(p);
        }
    }
    
    return entropy;
}

/**
 * Detecta si un string tiene entropía sospechosamente alta
 * (indicador de cifrado o ofuscación)
 */
function detectHighEntropy(str, threshold = 4.5) {
    const entropy = calculateEntropy(str);
    return entropy > threshold;
}

/**
 * Detecta patrones repetitivos sospechosos
 */
function detectSuspiciousPatterns(str) {
    const patterns = [
        /(.)\1{5,}/g,           // Caracteres repetidos (e.g., "aaaaaaa")
        /^[0-9]+$/g,            // Solo números
        /^[a-zA-Z]+$/g,         // Solo letras
        /([a-zA-Z0-9])\1{3,}/g  // Caracteres repetidos
    ];
    
    return patterns.some(p => {
        p.lastIndex = 0;
        return p.test(str);
    });
}

/**
 * ========================================================
 * 6. LOGGING Y AUDITORÍA
 * ========================================================
 */

class SecurityLogger {
    constructor() {
        this.logs = [];
        this.maxLogs = 1000;
    }

    log(level, message, data = {}) {
        const logEntry = {
            timestamp: new Date().toISOString(),
            level,
            message,
            data,
            url: window.location.href,
            userAgent: navigator.userAgent
        };

        this.logs.push(logEntry);

        // Mantener el máximo de logs
        if (this.logs.length > this.maxLogs) {
            this.logs.shift();
        }

        // Log en consola si es desarrollo
        if (level === 'error' || level === 'warning') {
            console[level](`[${level.toUpperCase()}] ${message}`, data);
        }
    }

    error(message, data) {
        this.log('error', message, data);
    }

    warning(message, data) {
        this.log('warning', message, data);
    }

    info(message, data) {
        this.log('info', message, data);
    }

    getLogs() {
        return this.logs;
    }

    clearLogs() {
        this.logs = [];
    }

    exportLogs() {
        return JSON.stringify(this.logs, null, 2);
    }
}

const securityLogger = new SecurityLogger();

/**
 * ========================================================
 * 7. FUNCIONES DE AYUDA PARA VALIDACIÓN
 * ========================================================
 */

/**
 * Valida y sanitiza un objeto completo
 */
function validateAndSanitizeFormData(formData) {
    const sanitized = {};
    const errors = [];

    for (const [key, value] of Object.entries(formData)) {
        if (!value) {
            sanitized[key] = '';
            continue;
        }

        const stringValue = String(value).trim();
        
        // Sanitizar
        sanitized[key] = sanitizeString(stringValue);

        // Validar amenazas
        if (detectXSSAttempt(stringValue)) {
            errors.push(`${key}: XSS detectado`);
        }
        if (detectSQLInjection(stringValue)) {
            errors.push(`${key}: SQL Injection detectado`);
        }
    }

    return {
        data: sanitized,
        errors: errors,
        isValid: errors.length === 0
    };
}

/**
 * Obtiene información del dispositivo/navegador
 */
function getDeviceInfo() {
    return {
        userAgent: navigator.userAgent,
        language: navigator.language,
        platform: navigator.platform,
        cookiesEnabled: navigator.cookieEnabled,
        doNotTrack: navigator.doNotTrack,
        timezone: Intl.DateTimeFormat().resolvedOptions().timeZone
    };
}

/**
 * Genera un token de seguridad temporal
 */
function generateSecurityToken() {
    return Array.from(crypto.getRandomValues(new Uint8Array(32)))
        .map(b => b.toString(16).padStart(2, '0'))
        .join('');
}

/**
 * ========================================================
 * 8. MONITOREO DE CAMBIOS SOSPECHOSOS
 * ========================================================
 */

class FormChangeMonitor {
    constructor(formId) {
        this.formId = formId;
        this.form = document.getElementById(formId);
        this.originalState = {};
        this.changes = [];

        if (this.form) {
            this.captureOriginalState();
            this.attachMonitor();
        }
    }

    captureOriginalState() {
        const inputs = this.form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            this.originalState[input.name] = input.value;
        });
    }

    attachMonitor() {
        this.form.addEventListener('input', (e) => this.trackChange(e));
    }

    trackChange(event) {
        const { name, value } = event.target;
        const originalValue = this.originalState[name];

        this.changes.push({
            timestamp: new Date().toISOString(),
            field: name,
            oldValue: originalValue,
            newValue: value
        });
    }

    getChanges() {
        return this.changes;
    }

    hasSignificantChanges() {
        return this.changes.length > 0;
    }

    reset() {
        this.changes = [];
    }
}

/**
 * ========================================================
 * 9. INICIALIZACIÓN Y SETUP
 * ========================================================
 */

/**
 * Realiza checks de seguridad al cargar la página
 */
function initializeSecurityChecks() {
    // Verificar CSRF tokens
    ensureAllFormsHaveCSRFToken();

    // Obtener información del dispositivo
    const deviceInfo = getDeviceInfo();
    securityLogger.info('Dispositivo detectado', deviceInfo);

    // Verificar que SweetAlert está disponible
    if (typeof Swal === 'undefined') {
        securityLogger.warning('SweetAlert no está cargado. Las alertas de seguridad pueden no funcionar.');
    }
}

// Ejecutar checks cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initializeSecurityChecks);

/**
 * ========================================================
 * 10. EXPORTAR PARA USO EN OTROS SCRIPTS
 * ========================================================
 */

// Hacer funciones disponibles globalmente si es necesario
window.SecurityLib = {
    sanitizeString,
    sanitizeUrl,
    detectSQLInjection,
    detectXSSAttempt,
    detectLDAPInjection,
    detectUnicodeAttacks,
    validateSecurityThreats,
    canSubmitForm,
    getFormSubmitRemainingTime,
    validateCSRFToken,
    getCSRFToken,
    validateAgainstWhitelist,
    calculateEntropy,
    detectHighEntropy,
    detectSuspiciousPatterns,
    validateAndSanitizeFormData,
    getDeviceInfo,
    generateSecurityToken,
    RateLimiter,
    FormChangeMonitor,
    securityLogger
};
