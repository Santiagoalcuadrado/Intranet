<?php
// /includes/avatar_chatbotia_flotante.php
// Avatar flotante que se transforma en buscador IA completo y acceso a Gemini Gems
// Incluir justo antes de cerrar el body: <?php include '../../includes/avatar_chatbotia_flotante.php'; 
?>

<!-- ===== ESTILOS DEL AVATAR FLOTANTE TRANSFORMABLE ===== -->
<style>
/* ===== CONTENEDOR PRINCIPAL FLOTANTE ===== */
.avatar-flotante-container {
    position: fixed;
    bottom: 30px;
    left: 30px;
    z-index: 99999;
    cursor: pointer;
    transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

/* ===== ESTADO GRANDE (AVATAR) ===== */
.avatar-flotante-container.grande {
    width: 200px;
    height: 240px;
    bottom: 30px;
    left: 30px;
}

/* ===== ESTADO PEQUEÑO (BUSCADOR) - MÁS ESTRECHO Y PEGADO A LA IZQUIERDA ===== */
.avatar-flotante-container.pequeno {
    width: 380px;        /* Ancho fijo más estrecho */
    height: 600px;       /* Alto fijo */
    top: 50%;
    left: 30px;          /* Pegado a la izquierda como el avatar */
    transform: translateY(-50%);  /* Solo centrado vertical */
    bottom: auto;
    right: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    border-radius: 20px;
    overflow: hidden;
    background: white;
    border: 1px solid rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
}

/* ===== AVATAR 3D - SECCIÓN SUPERIOR CON FONDO CRISTALINO ===== */
.avatar-flotante-container.pequeno .avatar-3d-wrapper {
    height: 140px;                      /* Un poco más alto */
    width: 100%;                        /* Ocupa todo el ancho */
    position: relative;
    top: 0;
    left: 0;
    background: linear-gradient(135deg, rgba(118, 199, 192, 0.3) 0%, rgba(0, 119, 182, 0.2) 100%);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(118, 199, 192, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
}

/* Centrar el avatar 3D dentro del wrapper */
.avatar-flotante-container.pequeno .avatar-3d-wrapper canvas {
    width: 110px !important;
    height: 130px !important;
    margin: 0 auto;
}

/* ===== AVATAR 3D EN ESTADO GRANDE ===== */
.avatar-flotante-container.grande .avatar-3d-wrapper {
    width: 100%;
    height: 100%;
    filter: drop-shadow(0 15px 30px rgba(0,0,0,0.3));
}

.avatar-3d-wrapper canvas {
    display: block;
    width: 100% !important;
    height: 100% !important;
}

/* ===== BOTÓN DE GEMINI GEMS ===== */
.gemini-gems-btn {
    position: absolute;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #4285f4, #9b72cb, #d96570);
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 5px 20px rgba(155, 114, 203, 0.4);
    transition: all 0.3s ease;
    z-index: 100000;
    animation: gemsPulse 3s infinite;
}

.gemini-gems-btn:hover {
    transform: scale(1.15) rotate(5deg);
    box-shadow: 0 8px 25px rgba(155, 114, 203, 0.7);
}

.gemini-gems-btn i {
    font-size: 28px;
}

@keyframes gemsPulse {
    0% { transform: scale(1); box-shadow: 0 5px 20px rgba(155, 114, 203, 0.4); }
    50% { transform: scale(1.1); box-shadow: 0 10px 30px rgba(155, 114, 203, 0.7); }
    100% { transform: scale(1); box-shadow: 0 5px 20px rgba(155, 114, 203, 0.4); }
}

/* Tooltip del botón */
.gemini-gems-btn:hover::after {
    content: "Abrir Gemini Gems";
    position: absolute;
    top: -40px;
    right: 0;
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
    white-space: nowrap;
    animation: fadeIn 0.3s ease;
}

/* ===== BUSCADOR IA ===== */
.buscador-ia-wrapper {
    display: none;
    height: calc(100% - 140px);  /* Ajustado para el nuevo alto del avatar */
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    border-top: 1px solid #e0e0e0;
    overflow-y: auto;
    padding: 15px 15px;  /* Padding lateral reducido */
}

.avatar-flotante-container.pequeno .buscador-ia-wrapper {
    display: block;
    animation: fadeIn 0.5s ease;
}

/* ===== HEADER DEL BUSCADOR ===== */
.buscador-header {
    display: flex;
    align-items: center;
    gap: 8px;            /* Gap reducido */
    margin-bottom: 12px;  /* Margen reducido */
    padding-bottom: 8px;  /* Padding reducido */
    border-bottom: 2px solid var(--bpez-cian);
}

.buscador-header i {
    font-size: 1.3rem !important;  /* Reducido */
    color: var(--bpez-azul-alegre) !important;
}

.buscador-header h3 {
    margin: 0;
    color: var(--bpez-dark-blue);
    font-size: 0.9rem;   /* Reducido */
    font-weight: 600;
}

/* ===== BUSCADOR PILL - MÁS COMPACTO ===== */
.buscador-pill {
    border: 2px solid var(--bpez-cian);
    border-radius: 50px;
    padding: 4px 8px;     /* Padding reducido */
    display: flex;
    align-items: center;
    background: white;
    margin-bottom: 12px;   /* Margen reducido */
    box-shadow: 0 4px 15px rgba(0, 51, 102, 0.1);
    min-height: 40px;      /* Altura reducida */
}

.buscador-pill input {
    border: none;
    outline: none;
    width: 100%;
    color: var(--bpez-dark-blue);
    font-weight: 500;
    font-size: 0.8rem;    /* Reducido */
    padding: 4px;          /* Padding reducido */
    text-align: left;
    direction: ltr;
}

/* Placeholder centrado */
.buscador-pill input::placeholder {
    text-align: center;
    opacity: 0.8;
    font-size: 0.8rem;    /* Reducido */
}

.buscador-pill input:focus::placeholder {
    text-align: left;
}

.buscador-pill button {
    background: var(--bpez-rojo-fuego);
    color: white;
    border: none;
    border-radius: 50px;
    padding: 4px 10px;    /* Padding reducido */
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
    font-size: 0.7rem;    /* Reducido */
    transition: all 0.2s;
    margin-left: 4px;      /* Margen reducido */
}

.buscador-pill button:hover {
    background: var(--bpez-dark-blue);
    transform: translateY(-2px);
}

/* ===== DROPDOWN DE VOLUMEN - MÁS COMPACTO ===== */
.dropdown-menu {
    min-width: 160px !important;  /* Reducido */
    padding: 8px !important;       /* Reducido */
}

/* ===== RESPUESTA IA - MÁS COMPACTA ===== */
.respuesta-ia {
    background: #f8f9fa;
    border-radius: 10px;           /* Reducido */
    padding: 10px;                  /* Reducido */
    border-left: 4px solid var(--bpez-azul-alegre);
    font-size: 0.8rem;              /* Reducido */
    line-height: 1.4;
    max-height: 180px;              /* Reducido */
    overflow-y: auto;
}

.respuesta-ia .robot-icon {
    display: flex;
    align-items: center;
    gap: 6px;                       /* Reducido */
    margin-bottom: 6px;              /* Reducido */
    color: var(--bpez-dark-blue);
    font-size: 0.7rem;               /* Reducido */
    font-weight: 600;
    text-transform: uppercase;
}

.respuesta-ia .robot-icon i {
    color: var(--bpez-azul-alegre);
    font-size: 0.9rem;               /* Reducido */
}

/* ===== BOTONES DE CONTROL DE VOZ ===== */
.btn-stop-ai, .btn-cerrar-ai {
    background-color: var(--bpez-rojo-fuego);
    color: white;
    border: none;
    border-radius: 50%;
    width: 22px;        /* Reducido */
    height: 22px;       /* Reducido */
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 0.65rem; /* Reducido */
    margin-left: 4px;    /* Reducido */
}

.btn-stop-ai {
    background-color: var(--bpez-dark-blue);
}

/* ===== LOADING SPINNER ===== */
.loading-spinner, .ai-loading {
    display: none;
    text-align: center;
    padding: 6px;        /* Reducido */
    color: var(--bpez-dark-blue);
    font-weight: 600;
    font-size: 0.7rem;   /* Reducido */
}

/* ===== BOTÓN DE CIERRE DEL FLOTANTE ===== */
.btn-cerrar-flotante {
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--bpez-rojo-fuego);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;         /* Reducido */
    height: 24px;        /* Reducido */
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 20;
    opacity: 0;
    transition: opacity 0.3s ease;
    font-size: 0.75rem;  /* Reducido */
}

.avatar-flotante-container.pequeno .btn-cerrar-flotante {
    opacity: 1;
}

.btn-cerrar-flotante:hover {
    transform: scale(1.1);
}

/* ===== ANIMACIONES ===== */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.avatar-flotante-container.grande {
    animation: pulse 2s infinite;
}

.avatar-flotante-container.grande:hover {
    animation: none;
    transform: scale(1.05);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .avatar-flotante-container.grande {
        width: 150px;
        height: 180px;
        bottom: 20px;
        left: 20px;
    }
    
    .avatar-flotante-container.pequeno {
        width: 320px;        /* Más pequeño en tablet */
        height: 550px;
        left: 20px;
    }
    
    .buscador-pill {
        min-height: 38px;
    }
    
    .buscador-pill input {
        font-size: 0.75rem;
    }
    
    .buscador-pill button {
        padding: 4px 8px;
        font-size: 0.65rem;
    }
    
    .gemini-gems-btn {
        width: 50px;
        height: 50px;
        bottom: 15px;
        right: 15px;
    }
    
    .gemini-gems-btn i {
        font-size: 22px;
    }
}

@media (max-width: 576px) {
    .avatar-flotante-container.pequeno {
        width: 280px;        /* Más pequeño en móvil */
        height: 500px;
        left: 10px;
        border-radius: 15px;
    }
    
    .buscador-pill {
        flex-wrap: wrap;
        gap: 4px;
    }
    
    .buscador-pill button {
        width: 100%;
    }
    
    .dropdown-menu {
        min-width: 140px !important;
    }
    
    .avatar-flotante-container.pequeno .avatar-3d-wrapper {
        height: 120px;
    }
    
    .avatar-flotante-container.pequeno .avatar-3d-wrapper canvas {
        width: 90px !important;
        height: 110px !important;
    }
    
    .gemini-gems-btn {
        width: 45px;
        height: 45px;
        bottom: 10px;
        right: 10px;
    }
}
</style>

<!-- ===== SCRIPTS DE THREE.JS ===== -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>

<!-- ===== HTML DEL AVATAR FLOTANTE ===== -->
<div class="avatar-flotante-container grande" id="avatarFlotante">
    <!-- Botón de cerrar (visible solo en modo pequeño) -->
    <button class="btn-cerrar-flotante" id="btnCerrarFlotante">
        <i class="fas fa-times"></i>
    </button>
    
    <!-- Avatar 3D -->
    <div class="avatar-3d-wrapper" id="avatar3dWrapper"></div>
    
    <!-- Botón de Gemini Gems (siempre visible) -->
    <button class="gemini-gems-btn" id="geminiGemsBtn" title="Abrir Gemini Gems">
        <i class="fas fa-gem"></i>
    </button>
    
    <!-- Buscador IA (oculto inicialmente) -->
    <div class="buscador-ia-wrapper" id="buscadorWrapper">
        <div class="buscador-header">
            <i class="fas fa-robot"></i>
            <h3>Asistente Virtual BPEZ</h3>
        </div>
        
        <!-- Buscador pill con input y botones -->
        <div class="buscador-pill">
            <input type="text" id="ai-input-flotante" class="search-input" placeholder="Soy el Asistente Virtual BPEZ">
            
            <!-- Botón de volumen con dropdown -->
            <div class="dropdown me-1">
                <button class="btn-buscar shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" title="Control de Volumen">
                    <i class="fas fa-volume-up"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end p-3 shadow border-0" style="border-radius: 20px; background: rgba(224, 242, 241, 0.95); backdrop-filter: blur(10px);">
                    <?php include 'volumen_control.php'; ?>
                </div>
            </div>

            <!-- Botón de búsqueda -->
            <button class="btn-buscar shadow-sm" onclick="preguntarIAFlotante()">
                <i class="fas fa-search"></i>
            </button>
        </div>
        
        <!-- Loading spinner -->
        <div id="loading-spinner-flotante" class="loading-spinner">
            <div class="spinner-border spinner-border-sm text-primary me-2"></div>
            Consultando Inteligencia BPEZ Local...
        </div>
        
        <!-- Respuesta IA con botones de control -->
        <div id="ai-response-wrapper-flotante" style="display: none;">
            <div class="respuesta-ia">
                <div class="d-flex justify-content-end mb-2">
                    <button class="btn-stop-ai shadow-sm" onclick="detenerVozFlotante()" title="Detener voz">
                        <i class="fas fa-volume-mute"></i>
                    </button>
                    <button class="btn-cerrar-ai shadow-sm" onclick="cerrarRespuestaFlotante()" title="Cerrar respuesta">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="robot-icon">
                    <i class="fas fa-robot"></i>
                    <span>Asistente Virtual BPEZ</span>
                </div>
                <div id="respuesta-texto-flotante" style="font-size: 0.85rem;"></div>
            </div>
        </div>
        
        <!-- Mensaje de bienvenida inicial -->
        <div id="respuesta-inicial-flotante" class="respuesta-ia">
            <div class="robot-icon">
                <i class="fas fa-robot"></i>
                <span>Asistente Virtual</span>
            </div>
            <div>¡Hola! ¿En qué puedo ayudarte?</div>
        </div>
    </div>
</div>

<!-- ===== SCRIPT UNIFICADO CON TODAS LAS FUNCIONES DE VOZ Y GEMINI GEMS ===== -->
<script>
// ===== VARIABLES DEL AVATAR 3D =====
let scene, camera, renderer, model;
let rotationDirection = 1;
let currentRotation = 0;
const maxRotation = 0.5;

// ===== VARIABLES DE VOZ (INTEGRADAS) =====
let speechSynthesis = window.speechSynthesis;
let speechUtterance = null;
let vocesCargadas = false;
let frasesActuales = [];
let indiceFraseActual = 0;
let utteranceActual = null;

// ===== URL DE GEMINI GEMS (REEMPLAZA CON TU URL) =====
const GEMINI_GEMS_URL = "https://gemini.google.com/gem/220b649523c5"; // Tu URL del Gems

// ===== FUNCIÓN PARA ABRIR GEMINI GEMS =====
function abrirGeminiGems() {
    // Dimensiones óptimas para que parezca un panel lateral/flotante
    const width = 550;
    const height = 800;
    
    // Calcular posición centrada
    const left = (window.screen.width / 2) - (width / 2);
    const top = (window.screen.height / 2) - (height / 2);

    // Ejecutar apertura
    const gemsWindow = window.open(
        GEMINI_GEMS_URL, 
        "GeminiGemsWindow", 
        `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=yes,status=no,location=no,toolbar=no,menubar=no`
    );

    if (!gemsWindow || gemsWindow.closed || typeof gemsWindow.closed == 'undefined') {
        alert("¡Ups! El bloqueador de ventanas emergentes está activo. Por favor, permite los pop-ups para usar Gemini Gems.");
    }
}

// ===== FUNCIÓN PARA INICIALIZAR EL AVATAR =====
function initAvatarFlotante() {
    const container = document.getElementById('avatar3dWrapper');
    if (!container) return;

    console.log('🎬 Inicializando avatar 3D flotante...');

    const width = container.clientWidth || 200;
    const height = container.clientHeight || 240;

    scene = new THREE.Scene();
    scene.background = null;

    camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 1000);
    camera.position.set(1.2, 1.0, 1.5);
    camera.lookAt(0, 0.8, 0);

    renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setClearColor(0x000000, 0);
    
    container.innerHTML = '';
    container.appendChild(renderer.domElement);

    // LUCES
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.7);
    scene.add(ambientLight);

    const mainLight = new THREE.DirectionalLight(0xffffff, 1.5);
    mainLight.position.set(2, 3, 3);
    scene.add(mainLight);

    const fillLight = new THREE.DirectionalLight(0xffaa88, 1.0);
    fillLight.position.set(-2, 2, 3);
    scene.add(fillLight);

    const backLight = new THREE.DirectionalLight(0x88aaff, 0.7);
    backLight.position.set(0, 2, -3);
    scene.add(backLight);

    const topLight = new THREE.PointLight(0xffffff, 0.5);
    topLight.position.set(0, 4, 0);
    scene.add(topLight);

    console.log('💡 Luces configuradas');

    // CARGAR MODELO
    const loader = new THREE.GLTFLoader();
    const modelPath = '/assets/models/robot2.glb';

    loader.load(
        modelPath,
        (gltf) => {
            model = gltf.scene;
            
            const box = new THREE.Box3().setFromObject(model);
            const size = box.getSize(new THREE.Vector3());
            const maxDim = Math.max(size.x, size.y, size.z);
            
            const scale = 1.3 / maxDim;
            model.scale.setScalar(scale);
            
            const center = box.getCenter(new THREE.Vector3());
            model.position.set(-center.x * scale, -center.y * scale + 0.7, -center.z * scale);
            
            scene.add(model);
            console.log('✅ Avatar 3D cargado correctamente');
        },
        (progress) => {},
        (error) => {
            console.error('❌ Error al cargar el avatar:', error);
        }
    );

    // ANIMACIÓN
    function animate() {
        requestAnimationFrame(animate);
        
        if (model) {
            currentRotation += 0.01 * rotationDirection;
            
            if (currentRotation >= maxRotation) {
                currentRotation = maxRotation;
                rotationDirection = -1;
            } else if (currentRotation <= -maxRotation) {
                currentRotation = -maxRotation;
                rotationDirection = 1;
            }
            
            model.rotation.y = currentRotation;
        }
        
        renderer.render(scene, camera);
    }
    animate();

    window.addEventListener('resize', () => {
        const newWidth = container.clientWidth || 200;
        const newHeight = container.clientHeight || 240;
        
        if (newWidth > 0 && newHeight > 0) {
            camera.aspect = newWidth / newHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(newWidth, newHeight);
        }
    });
}

// ===== FUNCIÓN PARA ABRIR EL BUSCADOR =====
function abrirBuscador() {
    const container = document.getElementById('avatarFlotante');
    container.classList.remove('grande');
    container.classList.add('pequeno');
    
    setTimeout(() => {
        if (renderer && camera) {
            renderer.setSize(110, 130);
            camera.aspect = 110 / 130;
            camera.updateProjectionMatrix();
        }
    }, 500);
}

// ===== FUNCIÓN PARA CERRAR EL BUSCADOR =====
function cerrarBuscador() {
    const container = document.getElementById('avatarFlotante');
    container.classList.remove('pequeno');
    container.classList.add('grande');
    
    setTimeout(() => {
        if (renderer && camera) {
            renderer.setSize(200, 240);
            camera.aspect = 200 / 240;
            camera.updateProjectionMatrix();
        }
    }, 500);
    
    cerrarRespuestaFlotante();
}

// ===== FUNCIONES DE VOZ COMPLETAS (INTEGRADAS) =====

// Esperar a que las voces estén disponibles
window.speechSynthesis.onvoiceschanged = function() {
    vocesCargadas = true;
    console.log('Voces disponibles:', window.speechSynthesis.getVoices().map(v => v.name).join(', '));
};

// Función principal para hablar (con segmentación)
function hablar(texto) {
    if (!texto) return;
    
    detenerVoz();
    
    // Segmentar el texto en frases por puntos, comas, etc.
    frasesActuales = texto.replace(/[*#_]/g, '').split(/[.,;:]/).map(f => f.trim()).filter(f => f.length > 0);
    indiceFraseActual = 0;
    
    if (frasesActuales.length > 0) {
        reproducirSiguienteFrase();
    } else {
        // Si no hay frases, intentar con el texto completo
        reproducirTextoCompleto(texto);
    }
}

function reproducirTextoCompleto(texto) {
    utteranceActual = new SpeechSynthesisUtterance(texto);
    configurarUtterance(utteranceActual);
    speechSynthesis.speak(utteranceActual);
}

function reproducirSiguienteFrase() {
    if (indiceFraseActual >= frasesActuales.length) {
        return;
    }
    
    const textoFrase = frasesActuales[indiceFraseActual];
    if (textoFrase.length === 0) {
        indiceFraseActual++;
        reproducirSiguienteFrase();
        return;
    }
    
    utteranceActual = new SpeechSynthesisUtterance(textoFrase);
    configurarUtterance(utteranceActual);
    
    utteranceActual.onend = function() {
        indiceFraseActual++;
        reproducirSiguienteFrase();
    };
    
    speechSynthesis.speak(utteranceActual);
}

//Configuraciones de Voz del Avatar o ChatBot
function configurarUtterance(utterance) {
    utterance.lang = 'es-ES';
    utterance.rate = 1.0;
    utterance.pitch = 1.0;
    
    // Aplicar volumen actual
    const volumen = window.currentVolumeIA !== undefined ? window.currentVolumeIA : 0.5;
    utterance.volume = volumen;
    
    // Obtener todas las voces
    const voces = window.speechSynthesis.getVoices();
    
    // ===== VOZ MASCULINA FIJA =====
    // Buscar específicamente "Google UK English Male" (es masculina y funciona en todos lados)
    const vozMasculina = voces.find(voz => 
        voz.name.includes('Google UK English Male') || 
        voz.name.includes('Microsoft Pablo') ||
        voz.name.includes('Microsoft Jorge') ||
        voz.name.includes('Microsoft Luis')
    );
    
    if (vozMasculina) {
        utterance.voice = vozMasculina;
        console.log('✅ Usando voz masculina:', vozMasculina.name);
    } else {
        // Si no encuentra, buscar cualquier voz en inglés (suelen ser masculinas)
        const vozInglesMasculina = voces.find(voz => 
            voz.lang.includes('en') && (
                voz.name.includes('Male') || 
                voz.name.includes('David') || 
                voz.name.includes('Mark')
            )
        );
        
        if (vozInglesMasculina) {
            utterance.voice = vozInglesMasculina;
            console.log('✅ Usando voz masculina (inglés):', vozInglesMasculina.name);
        } else {
            // Último recurso: cualquier voz en español
            const vozEspanol = voces.find(voz => voz.lang.includes('es'));
            if (vozEspanol) {
                utterance.voice = vozEspanol;
                console.log('⚠️ Usando voz en español (puede ser femenina):', vozEspanol.name);
            }
        }
    }
}

function detenerVoz() {
    if (speechSynthesis) {
        speechSynthesis.cancel();
    }
    frasesActuales = [];
    indiceFraseActual = 0;
    utteranceActual = null;
}

function detenerVozFlotante() {
    detenerVoz();
}

// ===== EVENTO DE VOLUMEN EN TIEMPO REAL (INTEGRADO) =====
window.addEventListener('volumenRealTime', (e) => {
    const nuevoVolumen = e.detail;
    window.currentVolumeIA = nuevoVolumen;
    
    // Si hay una frase en curso, reiniciar con nuevo volumen
    if (speechSynthesis.speaking && utteranceActual) {
        const textoActual = utteranceActual.text;
        const estabaHablando = true;
        
        detenerVoz();
        
        if (estabaHablando && textoActual) {
            setTimeout(() => {
                hablar(textoActual);
            }, 50);
        }
    }
});

// ===== DETENER VOZ AL CAMBIAR DE PÁGINA (INTEGRADO) =====
window.addEventListener('beforeunload', () => { 
    if (speechSynthesis) {
        speechSynthesis.cancel();
    }
});

// ===== FUNCIÓN PARA PREGUNTAR A LA IA (CORREGIDA) =====
async function preguntarIAFlotante() {
    const input = document.getElementById('ai-input-flotante').value;
    const respuestaInicial = document.getElementById('respuesta-inicial-flotante');
    const respuestaWrapper = document.getElementById('ai-response-wrapper-flotante');
    const respuestaTexto = document.getElementById('respuesta-texto-flotante');
    const spinner = document.getElementById('loading-spinner-flotante');

    if (!input) return;

    detenerVoz();

    respuestaInicial.style.display = 'none';
    spinner.style.display = 'block';
    respuestaWrapper.style.display = 'none';

    try {
        const response = await fetch('../../modules/ia_backend/ask_ia.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ prompt: input })
        });

        const data = await response.json();

        if (data.respuesta) {
            // Guardar el texto original SIN formato HTML para la voz
            const textoOriginal = data.respuesta;
            
            // Mostrar en pantalla con formato HTML
            respuestaTexto.innerHTML = textoOriginal.replace(/\n/g, '<br>');
            
            // Extraer SOLO el texto sin HTML para la voz
            const textoVoz = extraerTextoParaVoz(textoOriginal);
            
            spinner.style.display = 'none';
            respuestaWrapper.style.display = 'block';
            
            // Pasar el texto limpio a la función hablar
            hablar(textoVoz);
        }
    } catch (error) {
        spinner.style.display = 'none';
        respuestaWrapper.style.display = 'block';
        respuestaTexto.innerHTML = `<div class="alert alert-danger py-2 px-3 mb-0" style="font-size:0.8rem;">Error de conexión con IA BPEZ.</div>`;
    }
}

// ===== FUNCIÓN PARA EXTRAER TEXTO LIMPIO PARA LA VOZ (CON VERSIÓN HABLADA DE HORARIOS) =====
function extraerTextoParaVoz(texto) {
    // Si ya es texto plano, devolverlo
    if (typeof texto !== 'string') return texto;
    
    let textoLimpio = texto;
    
    // ===== CONVERSIONES ESPECÍFICAS PARA HORARIOS =====
    // Reemplazar "AM" por "de la mañana" (evita que lo lea como "a.m." que suena a noche)
    textoLimpio = textoLimpio.replace(/\bAM\b/g, 'de la mañana');
    textoLimpio = textoLimpio.replace(/\bA\.M\.\b/g, 'de la mañana');
    
    // Reemplazar "PM" por "de la tarde" (evita que lo lea como "p.m." que suena a noche)
    textoLimpio = textoLimpio.replace(/\bPM\b/g, 'de la tarde');
    textoLimpio = textoLimpio.replace(/\bP\.M\.\b/g, 'de la tarde');
    
    // Caso específico para horarios con formato "8:00 AM"
    textoLimpio = textoLimpio.replace(/(\d{1,2}):00\s*(AM|PM|de la mañana|de la tarde)/g, function(match, hora, periodo) {
        const horaNum = parseInt(hora);
        if (periodo.includes('AM') || periodo.includes('mañana')) {
            if (horaNum === 1) return 'una de la mañana';
            if (horaNum === 12) return 'doce del mediodía';
            return horaNum + ' de la mañana';
        } else {
            if (horaNum === 12) return 'doce del mediodía';
            if (horaNum === 1) return 'una de la tarde';
            if (horaNum === 2) return 'dos de la tarde';
            if (horaNum === 3) return 'tres de la tarde';
            if (horaNum === 4) return 'cuatro de la tarde';
            return horaNum + ' de la tarde';
        }
    });
    
    // Eliminar etiquetas HTML (esto ya lo tenías)
    textoLimpio = textoLimpio.replace(/<[^>]*>/g, ' ');
    
    // Eliminar entidades HTML comunes (esto ya lo tenías)
    textoLimpio = textoLimpio.replace(/&nbsp;/g, ' ');
    textoLimpio = textoLimpio.replace(/&amp;/g, '&');
    textoLimpio = textoLimpio.replace(/&lt;/g, '<');
    textoLimpio = textoLimpio.replace(/&gt;/g, '>');
    textoLimpio = textoLimpio.replace(/&quot;/g, '"');
    textoLimpio = textoLimpio.replace(/&#039;/g, "'");
    
    // Eliminar múltiples espacios y trim (esto ya lo tenías)
    textoLimpio = textoLimpio.replace(/\s+/g, ' ').trim();
    
    return textoLimpio;
}

// ===== FUNCIÓN PARA CERRAR RESPUESTA =====
function cerrarRespuestaFlotante() {
    detenerVoz();
    const respuestaWrapper = document.getElementById('ai-response-wrapper-flotante');
    const respuestaInicial = document.getElementById('respuesta-inicial-flotante');
    const input = document.getElementById('ai-input-flotante');
    
    respuestaWrapper.style.display = 'none';
    respuestaInicial.style.display = 'block';
    if (input) input.value = '';
}

// ===== INICIALIZACIÓN Y EVENTOS =====
document.addEventListener('DOMContentLoaded', function() {
    initAvatarFlotante();
    
    const avatarWrapper = document.getElementById('avatar3dWrapper');
    avatarWrapper.addEventListener('click', function(e) {
        e.stopPropagation();
        abrirBuscador();
    });
    
    const btnCerrar = document.getElementById('btnCerrarFlotante');
    btnCerrar.addEventListener('click', function(e) {
        e.stopPropagation();
        cerrarBuscador();
    });
    
    // Evento para el botón de Gemini Gems
    const gemsBtn = document.getElementById('geminiGemsBtn');
    gemsBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        abrirGeminiGems();
    });
    
    const buscadorWrapper = document.getElementById('buscadorWrapper');
    buscadorWrapper.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    const input = document.getElementById('ai-input-flotante');
    if (input) {
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                preguntarIAFlotante();
            }
        });
    }
});
</script>