<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Intranet BPEZ</title>

    <!-- ===== RECURSOS OFFLINE (MODULAR) ===== -->
    <!-- Incluye Bootstrap CSS, Font Awesome y Montserrat local -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/offline_assets.php'; ?>
    
    <!-- ===== FAVICONS (MODULAR) ===== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/favicon.php'; ?>    
    
<style>

:root {
    --bpez-cian:#76C7C0;
    --bpez-rojo-fuego:#CE2029;
    --bpez-dark-blue:#003366;
    --bpez-azul-alegre:#0077B6;
    --header-bg-integrado:#e0f2f1;
}

html, body {
    height: 100%; /* Cambiado de min-height a height */
    margin: 0;
    overflow: hidden; /* Evita scroll en el body */
}

body {
    display: flex;
    flex-direction: column;
    background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
    font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
    animation: fadeInPage 1.2s ease-out;
}

@keyframes fadeInPage {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ================= MAIN ================= */

.main-content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px 20px; /* Reducido padding vertical */
    overflow-y: auto; /* Scroll solo si es necesario dentro del main */
}

/* ================= HEADER ================= */

.login-header-container {
    display: flex;
    flex-direction: row;
    align-items: center;
    justify-content: center;
    gap: 15px; /* Reducido de 18px */
    margin-bottom: 0.8rem; /* Reducido de 1rem */
    max-width: 900px;
    width: 100%;
}

.logo-img {
    max-height: 110px; /* Reducido de 130px */
    object-fit: contain;
    filter: drop-shadow(0 8px 20px rgba(0,0,0,0.15));
}

.header-box {
    background-color: var(--header-bg-integrado);
    border-radius: 20px;
    color: var(--bpez-dark-blue);
    font-weight: 700;
    padding: 8px 18px; /* Reducido de 10px 22px */
    min-height: 40px; /* Reducido de 48px */
    font-size: clamp(0.85rem, 1.1vw, 1rem); /* Reducido */
    text-transform: uppercase;
    letter-spacing: .45px;
    border-bottom: 2px solid var(--bpez-rojo-fuego);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    line-height: 1.2;
    margin: 0;
    white-space: nowrap;
}

/* ================= CARD ================= */

.recovery-card {
    width: 100%;
    max-width: 600px; /* Reducido de 640px */
    border: none;
    border-radius: 25px;
    padding: 1.2rem 1.8rem; /* Reducido de 1.4rem 2rem */
    background: rgba(255,255,255,.85);
    backdrop-filter: blur(10px);
    box-shadow: 0 20px 40px rgba(0,51,102,.15);
    border-top: 6px solid var(--bpez-rojo-fuego);
    margin: 0 auto;
}

.section-icon {
    color: var(--bpez-dark-blue);
    margin-bottom: 0.2rem; /* Reducido de .3rem */
    font-size: 2rem; /* Reducido de 2.2rem */
}

h4.fw-bold {
    margin-bottom: 0.5rem !important; /* Reducido de .7rem */
    font-size: clamp(0.95rem, 1.6vw, 1.1rem); /* Reducido */
}

/* ================= FORM ================= */

.questions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px; /* Reducido de 12px */
}

.question-full-width {
    grid-column: span 2;
}

.q-label {
    font-size: 0.6rem; /* Reducido de .65rem */
    font-weight: 700;
    color: var(--bpez-dark-blue);
    text-transform: uppercase;
    margin-bottom: 1px;
}

.input-group-text {
    background: transparent;
    border: none;
    border-bottom: 2px solid #eee;
    border-radius: 0;
    color: var(--bpez-azul-alegre);
    padding: 0 5px 2px 0; /* Reducido padding inferior */
}

.form-control {
    border: none;
    border-bottom: 2px solid #eee;
    border-radius: 0;
    padding: 4px 5px; /* Reducido de 5px */
    background: transparent;
    font-size: 0.8rem; /* Reducido de .85rem */
}

.form-control:focus {
    box-shadow: none;
    border-bottom-color: var(--bpez-azul-alegre);
}

.password-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px; /* Reducido de 12px */
    margin: 0.5rem 0; /* Reducido de .8rem */
}

.buttons-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px; /* Reducido de 10px */
}

.btn-confirm {
    background: var(--bpez-azul-alegre);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 6px; /* Reducido de 8px */
    font-weight: 700;
    font-size: 0.85rem; /* Reducido */
}

.btn-confirm:hover {
    background: var(--bpez-dark-blue);
    transform: translateY(-2px);
}

.btn-back {
    background: #6c757d;
    color: white;
    border-radius: 50px;
    padding: 6px; /* Reducido de 8px */
    text-align: center;
    text-decoration: none;
    font-size: 0.85rem; /* Reducido */
}

.btn-back:hover {
    background: #495057;
    color: white;
}

/* ================= FOOTER ================= */
/* SIN MODIFICACIONES - SE MANTIENE IGUAL */
footer {
    margin-top: 18px;
    padding-top: 6px;
    flex-shrink: 0;
}

/* ================= RESPONSIVE ================= */

@media (max-width: 768px) {
    .main-content {
        padding: 10px;
    }
    
    .login-header-container {
        flex-direction: column;
        gap: 5px;
        margin-bottom: 0.5rem;
    }
    
    .logo-img {
        max-height: 85px; /* Reducido de 100px */
    }
    
    .header-box {
        font-size: 0.6rem;
        padding: 4px 10px;
        white-space: normal;
        min-height: auto;
    }
    
    .recovery-card {
        padding: 0.8rem;
        max-width: 100%;
    }
    
    .questions-grid,
    .password-section,
    .buttons-section {
        grid-template-columns: 1fr;
        gap: 6px;
    }
    
    .question-full-width {
        grid-column: span 1;
    }
    
    .btn-confirm, .btn-back {
        padding: 5px;
        font-size: 0.8rem;
    }
    
    /* Footer sin cambios en móvil */
    footer {
        margin-top: 10px; /* Reducido solo en móvil */
        padding-top: 4px;
    }
}

@media (min-width: 768px) and (max-width: 992px) {
    .recovery-card {
        max-width: 500px;
    }
}

@media (min-width: 1400px) {
    .logo-img {
        max-height: 120px; /* Reducido de 140px */
    }
    
    .header-box {
        font-size: 0.9rem;
        padding: 6px 16px;
    }
    
    .recovery-card {
        max-width: 650px;
        padding: 1.4rem 2rem;
    }
}

/* ================= ESTILOS PARA MENSAJES ================= */
.alert {
    border-radius: 8px; /* Reducido de 10px */
    padding: 8px 12px; /* Reducido */
    margin-bottom: 10px; /* Reducido de 15px */
    font-size: 0.8rem; /* Reducido de 0.9rem */
    font-weight: 600;
    text-align: center;
    animation: slideDown 0.2s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.alert-warning {
    background-color: #fff3cd;
    color: #856404;
    border: 1px solid #ffeeba;
}

/* Spinner de carga */
.spinner-border-sm {
    width: 0.9rem; /* Reducido de 1rem */
    height: 0.9rem;
    border-width: 0.2em;
}

.btn-confirm:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}
</style>
</head>
<body>

<div class="main-content">
<div class="container d-flex flex-column align-items-center">

<!-- HEADER -->
<div class="login-header-container">
    <!-- Ruta del logo actualizada (desde la raíz) -->
    <img src="/assets/img/logo.png" alt="Logo BPEZ" class="logo-img">
    <div class="header-box">
        Sistema de Recuperación de Credenciales - Intranet BPEZ
    </div>
</div>

<!-- CARD -->
<div class="recovery-card">

<div class="text-center">
<i class="fas fa-user-shield section-icon"></i>
<h4 class="fw-bold" style="color: var(--bpez-dark-blue);">
Recuperar Acceso
</h4>
</div>

<!-- CONTENEDOR DE MENSAJES (se crea dinámicamente) -->
<div id="mensajeContainer"></div>

<form id="recoveryForm" autocomplete="off">

<div class="mb-2">
<label class="q-label">Identificación</label>
<div class="input-group">
<span class="input-group-text"><i class="fas fa-id-card"></i></span>
<input type="text" id="cedulaInput" class="form-control" placeholder="Cédula del Usuario" required autocomplete="off">
</div>
</div>

<div class="questions-grid" id="preguntasContainer" style="display: none;">
<div>
<label class="q-label" id="pregunta1Label">Pregunta 1</label>
<input type="text" id="respuesta1" class="form-control" placeholder="Respuesta 1">
</div>
<div>
<label class="q-label" id="pregunta2Label">Pregunta 2</label>
<input type="text" id="respuesta2" class="form-control" placeholder="Respuesta 2">
</div>
<div class="question-full-width">
<label class="q-label" id="pregunta3Label">Pregunta 3</label>
<input type="text" id="respuesta3" class="form-control" placeholder="Respuesta 3">
</div>
</div>

<hr id="separador" style="display: none;">

<div class="password-section" id="passwordContainer" style="display: none;">
<div>
<label class="q-label">Nueva Contraseña</label>
<div class="input-group">
<span class="input-group-text"><i class="fas fa-key"></i></span>
<input type="password" id="newPass" class="form-control" autocomplete="new-password">
<span class="input-group-text" onclick="togglePass('newPass','eye1')" style="cursor:pointer;">
<i class="fas fa-eye" id="eye1"></i>
</span>
</div>
</div>
<div>
<label class="q-label">Confirmar</label>
<div class="input-group">
<span class="input-group-text"><i class="fas fa-check-double"></i></span>
<input type="password" id="confirmPass" class="form-control" autocomplete="new-password">
<span class="input-group-text" onclick="togglePass('confirmPass','eye2')" style="cursor:pointer;">
<i class="fas fa-eye" id="eye2"></i>
</span>
</div>
</div>
</div>

<div class="buttons-section">
<button type="button" id="btnConfirmar" class="btn-confirm shadow">
<i class="fas fa-search me-1"></i>Verificar Cédula
</button>
<a href="/assets/frontend/login_frontend.php" class="btn-back">
<i class="fas fa-arrow-left me-1"></i>Regresar
</a>
</div>

</form>
</div>
</div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>

<!-- ===== SCRIPTS LOCALES ===== -->
<!-- Bootstrap JS (ya incluido en offline_assets.php, pero lo dejamos por compatibilidad) -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<script>
// =====================================================
// SISTEMA DE RECUPERACIÓN DE CONTRASEÑA CON AJAX
// =====================================================

// Elementos del DOM
const cedulaInput = document.getElementById('cedulaInput');
const btnConfirmar = document.getElementById('btnConfirmar');
const preguntasContainer = document.getElementById('preguntasContainer');
const passwordContainer = document.getElementById('passwordContainer');
const separador = document.getElementById('separador');
const mensajeContainer = document.getElementById('mensajeContainer');

// Labels de preguntas
const pregunta1Label = document.getElementById('pregunta1Label');
const pregunta2Label = document.getElementById('pregunta2Label');
const pregunta3Label = document.getElementById('pregunta3Label');

// Inputs de respuestas
const respuesta1 = document.getElementById('respuesta1');
const respuesta2 = document.getElementById('respuesta2');
const respuesta3 = document.getElementById('respuesta3');

// Inputs de contraseña
const newPass = document.getElementById('newPass');
const confirmPass = document.getElementById('confirmPass');

// Variables de estado
let pasoActual = 1; // 1: cédula, 2: preguntas, 3: nueva contraseña
let usuarioActual = null;
let tokenActual = null;
let preguntasData = [];

// =====================================================
// FUNCIÓN PARA MOSTRAR MENSAJES
// =====================================================
function mostrarMensaje(texto, tipo = 'danger') {
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo}`;
    alerta.innerHTML = texto;
    alerta.style.animation = 'slideDown 0.2s ease-out';
    
    // Limpiar mensajes anteriores
    mensajeContainer.innerHTML = '';
    mensajeContainer.appendChild(alerta);
    
    // Auto-ocultar después de 4 segundos
    if (tipo !== 'danger' || !texto.includes('bloqueado')) {
        setTimeout(() => {
            alerta.style.opacity = '0';
            alerta.style.transition = 'opacity 0.3s';
            setTimeout(() => {
                if (alerta.parentNode) {
                    alerta.remove();
                }
            }, 300);
        }, 4000);
    }
}

// =====================================================
// FUNCIÓN PARA MOSTRAR CARGANDO
// =====================================================
function setCargando(activar) {
    if (activar) {
        btnConfirmar.disabled = true;
        btnConfirmar.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Procesando...';
    } else {
        btnConfirmar.disabled = false;
        if (pasoActual === 1) {
            btnConfirmar.innerHTML = '<i class="fas fa-search me-1"></i>Verificar Cédula';
        } else if (pasoActual === 2) {
            btnConfirmar.innerHTML = '<i class="fas fa-check-circle me-1"></i>Verificar Respuestas';
        } else if (pasoActual === 3) {
            btnConfirmar.innerHTML = '<i class="fas fa-key me-1"></i>Cambiar Contraseña';
        }
    }
}

// =====================================================
// FUNCIÓN PARA ACTUALIZAR EL PASO ACTUAL
// =====================================================
function actualizarPaso(paso) {
    pasoActual = paso;
    
    // Ocultar todo
    preguntasContainer.style.display = 'none';
    passwordContainer.style.display = 'none';
    separador.style.display = 'none';
    
    if (paso === 1) {
        // Paso 1: Solo cédula
        cedulaInput.disabled = false;
        btnConfirmar.innerHTML = '<i class="fas fa-search me-1"></i>Verificar Cédula';
    } 
    else if (paso === 2) {
        // Paso 2: Preguntas visibles
        preguntasContainer.style.display = 'grid';
        separador.style.display = 'block';
        cedulaInput.disabled = true;
        btnConfirmar.innerHTML = '<i class="fas fa-check-circle me-1"></i>Verificar Respuestas';
        
        // Limpiar respuestas anteriores
        respuesta1.value = '';
        respuesta2.value = '';
        respuesta3.value = '';
    }
    else if (paso === 3) {
        // Paso 3: Nueva contraseña visible
        passwordContainer.style.display = 'grid';
        separador.style.display = 'block';
        btnConfirmar.innerHTML = '<i class="fas fa-key me-1"></i>Cambiar Contraseña';
        
        // Limpiar contraseñas anteriores
        newPass.value = '';
        confirmPass.value = '';
    }
}

// =====================================================
// LLAMADA 1: VERIFICAR CÉDULA
// =====================================================
async function verificarCedula() {
    const cedula = cedulaInput.value.trim();
    
    if (!cedula) {
        mostrarMensaje('⚠️ Por favor, ingrese su cédula', 'warning');
        return;
    }
    
    if (!/^\d+$/.test(cedula)) {
        mostrarMensaje('❌ La cédula debe contener solo números', 'danger');
        return;
    }
    
    setCargando(true);
    
    const formData = new FormData();
    formData.append('accion', 'verificar_cedula');
    formData.append('cedula', cedula);
    
    try {
        const response = await fetch('/auth/olvido_contrasena_ajax.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Guardar datos del usuario
            usuarioActual = data;
            preguntasData = data.preguntas;
            
            // Mostrar las preguntas en los labels
            pregunta1Label.textContent = preguntasData[0]?.pregunta || 'Pregunta 1';
            pregunta2Label.textContent = preguntasData[1]?.pregunta || 'Pregunta 2';
            pregunta3Label.textContent = preguntasData[2]?.pregunta || 'Pregunta 3';
            
            // Avanzar al paso 2
            actualizarPaso(2);
            mostrarMensaje(`✅ Bienvenido ${data.nombre}. Responda sus preguntas de seguridad`, 'success');
        } else {
            mostrarMensaje(`❌ ${data.error || 'Error al verificar cédula'}`);
            if (data.bloqueado) {
                cedulaInput.disabled = true;
            }
        }
    } catch (error) {
        mostrarMensaje('❌ Error de conexión con el servidor');
        console.error('Error:', error);
    } finally {
        setCargando(false);
    }
}

// =====================================================
// LLAMADA 2: VERIFICAR RESPUESTAS
// =====================================================
async function verificarRespuestas() {
    // Validar que todas las respuestas tengan contenido
    if (!respuesta1.value.trim() || !respuesta2.value.trim() || !respuesta3.value.trim()) {
        mostrarMensaje('⚠️ Debe responder todas las preguntas', 'warning');
        return;
    }
    
    setCargando(true);
    
    // Crear FormData y agregar CADA RESPUESTA INDIVIDUALMENTE
    const formData = new FormData();
    formData.append('accion', 'verificar_respuestas');
    formData.append('usuario_id', usuarioActual.usuario_id);
    
    // Agregar cada respuesta como campo independiente
    formData.append('respuesta1', respuesta1.value.trim());
    formData.append('respuesta2', respuesta2.value.trim());
    formData.append('respuesta3', respuesta3.value.trim());
    
    // También enviar los IDs de las preguntas
    formData.append('pregunta_id1', preguntasData[0]?.pregunta_id);
    formData.append('pregunta_id2', preguntasData[1]?.pregunta_id);
    formData.append('pregunta_id3', preguntasData[2]?.pregunta_id);
    
    try {
        const response = await fetch('/auth/olvido_contrasena_ajax.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        console.log('Respuesta del servidor:', data); // Para depurar
        
        if (data.success) {
            tokenActual = data.token;
            actualizarPaso(3);
            mostrarMensaje('✅ Respuestas correctas. Ingrese su nueva contraseña', 'success');
        } else {
            mostrarMensaje(`❌ ${data.error || 'Respuestas incorrectas'}`);
        }
    } catch (error) {
        console.error('Error completo:', error);
        mostrarMensaje('❌ Error de conexión con el servidor');
    } finally {
        setCargando(false);
    }
}

// =====================================================
// LLAMADA 3: CAMBIAR CONTRASEÑA
// =====================================================
async function cambiarContrasena() {
    const nueva = newPass.value.trim();
    const confirmar = confirmPass.value.trim();
    
    if (!nueva || !confirmar) {
        mostrarMensaje('⚠️ Complete ambos campos de contraseña', 'warning');
        return;
    }
    
    if (nueva.length < 6) {
        mostrarMensaje('❌ La contraseña debe tener al menos 6 caracteres', 'danger');
        return;
    }
    
    if (nueva !== confirmar) {
        mostrarMensaje('❌ Las contraseñas no coinciden', 'danger');
        return;
    }
    
    setCargando(true);
    
    const formData = new FormData();
    formData.append('accion', 'cambiar_contrasena');
    formData.append('usuario_id', usuarioActual.usuario_id);
    formData.append('token', tokenActual);
    formData.append('nueva_contrasena', nueva);
    formData.append('confirmar_contrasena', confirmar);
    
    try {
        const response = await fetch('/auth/olvido_contrasena_ajax.php', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            mostrarMensaje('✅ ¡Contraseña actualizada! Redirigiendo al login...', 'success');
            
            // Deshabilitar botón
            btnConfirmar.disabled = true;
            
            // Redirigir después de 2 segundos
            setTimeout(() => {
                window.location.href = '/assets/frontend/login_frontend.php';
            }, 2000);
        } else {
            mostrarMensaje(`❌ ${data.error || 'Error al cambiar contraseña'}`);
            setCargando(false);
        }
    } catch (error) {
        mostrarMensaje('❌ Error de conexión con el servidor');
        console.error('Error:', error);
        setCargando(false);
    }
}

// =====================================================
// MANEJADOR PRINCIPAL DEL BOTÓN CONFIRMAR
// =====================================================
btnConfirmar.addEventListener('click', function(e) {
    e.preventDefault();
    
    if (pasoActual === 1) {
        verificarCedula();
    } else if (pasoActual === 2) {
        verificarRespuestas();
    } else if (pasoActual === 3) {
        cambiarContrasena();
    }
});

// =====================================================
// PERMITIR ENTER EN LOS CAMPOS
// =====================================================
cedulaInput.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        btnConfirmar.click();
    }
});

respuesta1.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && pasoActual === 2) {
        e.preventDefault();
        respuesta2.focus();
    }
});

respuesta2.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && pasoActual === 2) {
        e.preventDefault();
        respuesta3.focus();
    }
});

respuesta3.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && pasoActual === 2) {
        e.preventDefault();
        btnConfirmar.click();
    }
});

newPass.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && pasoActual === 3) {
        e.preventDefault();
        confirmPass.focus();
    }
});

confirmPass.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && pasoActual === 3) {
        e.preventDefault();
        btnConfirmar.click();
    }
});

// =====================================================
// FUNCIÓN PARA MOSTRAR/OCULTAR CONTRASEÑA
// =====================================================
function togglePass(inputId, eyeId) {
    const input = document.getElementById(inputId);
    const eye = document.getElementById(eyeId);
    
    if (input.type === "password") {
        input.type = "text";
        eye.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = "password";
        eye.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// =====================================================
// INICIALIZAR (Paso 1)
// =====================================================
actualizarPaso(1);
</script>

</body>
</html>