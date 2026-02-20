<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal - Intranet BPEZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo-fuego: #CE2029;
            --bpez-dark-blue: #003366; 
            --bpez-azul-alegre: #0077B6;
            --header-bg-integrado: #e0f2f1;
        }

        html, body { height: 100%; scroll-behavior: smooth; }
        
        body { 
            display: flex; 
            flex-direction: column; 
            padding-top: 100px; 
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            font-family: 'Montserrat', sans-serif;
            color: #333;
        }

        .main-content { flex: 1 0 auto; padding-top: 40px; }

        /* Contenedor Saludo y Avatar */
        .welcome-section { text-align: center; margin-bottom: 30px; }
        
        .avatar-placeholder {
            width: 140px;
            height: 140px;
            background: rgba(255,255,255,0.4);
            border-radius: 50%;
            margin: 0 auto 20px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            backdrop-filter: blur(8px);
            border: 2px solid white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .avatar-ring {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 2px solid var(--bpez-azul-alegre);
            border-radius: 50%;
            animation: pulse-ring 2.5s infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.9); opacity: 1; }
            100% { transform: scale(1.4); opacity: 0; }
        }

        /* Buscador e IA */
        .ai-search-container { max-width: 780px; margin: 20px auto 40px auto; }
        .search-pill { 
            border: 1px solid var(--bpez-cian);
            border-radius: 50px;
            padding: 5px 20px;
            display: flex;
            align-items: center;
            background: white;
            height: 55px;
            box-shadow: 0 8px 32px rgba(0, 51, 102, 0.1);
        }

        /* Ajuste para el botón de volumen dentro del buscador */
        .search-pill .dropdown-menu {
            min-width: 200px;
            margin-top: 10px !important;
        }

        /* Evitar que el botón de volumen herede comportamientos extraños */
        .search-pill .btn-buscar {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 40px;
        }

        .search-input { border: none; outline: none; width: 100%; text-align: center; color: var(--bpez-dark-blue); font-weight: 500; }
        .btn-buscar { background: var(--bpez-rojo-fuego); color: white; border-radius: 50px; padding: 6px 25px; border: none; font-weight: 600; cursor: pointer; }

        #ai-response-wrapper { display: none; max-width: 800px; margin: 20px auto; animation: fadeInUp 0.5s ease; }
        .ai-card { 
            position: relative;
            background: white; 
            border-radius: 20px; 
            border-left: 6px solid var(--bpez-azul-alegre); 
            padding: 25px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
        }

        .btn-cerrar-ai, .btn-stop-ai {
            position: absolute;
            background-color: var(--bpez-rojo-fuego);
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
        }
        .btn-cerrar-ai { top: 15px; right: 15px; }
        .btn-stop-ai { top: 15px; right: 55px; background-color: var(--bpez-dark-blue); }

        .ai-loading { display: none; color: var(--bpez-dark-blue); font-weight: 600; margin-top: 10px; }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<?php include '../../includes/navbar.php'; ?>

<div class="main-content">
    
    <div class="container welcome-section">
        <div class="avatar-placeholder">
            <div class="avatar-ring"></div>
            <i class="fas fa-robot fa-3x" style="color: var(--bpez-dark-blue); opacity: 0.6;"></i>
        </div>
        
        <h2 class="fw-800" style="color: var(--bpez-dark-blue); margin-bottom: 5px;">
            ¡<span id="txt-saludo">Hola</span>! Bienvenido a la Intranet
        </h2>
        <p class="text-muted fw-500">
            <i class="far fa-calendar-check me-2 text-primary"></i>
            Hoy es <span id="txt-fecha" class="text-capitalize"></span>
        </p>
    </div>

    <div class="container ai-search-container text-center">
        <h6 class="fw-bold mb-4" style="color: var(--bpez-dark-blue); letter-spacing: 1px; font-size: 0.75rem;">
            PLATAFORMA DE GESTIÓN INTEGRAL: INDUCCIÓN, CAPACITACIÓN Y TRABAJO COLABORATIVO
        </h6>

        <div class="search-pill">
            <i class="fab fa-android fa-2xl mx-2" style="color: var(--bpez-dark-blue);"></i>
            <input type="text" id="ai-input" class="search-input" placeholder="Buscador Artificial Inteligente Local (BPEZ)">
            
            <div class="dropdown me-2">
                <button class="btn-buscar shadow-sm" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" title="Control de Volumen">
                    <i class="fas fa-volume-up"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end p-3 shadow border-0" style="border-radius: 20px; background: rgba(224, 242, 241, 0.95); backdrop-filter: blur(10px);">
                    <?php include '../../includes/volumen_control.php'; ?>
                </div>
            </div>

            <button class="btn-buscar shadow-sm" onclick="preguntarIA()">
                <i class="fas fa-search"></i>
            </button>
            <i class="fab fa-android fa-2xl mx-2" style="color: var(--bpez-dark-blue);"></i>
        </div>

        <div id="loading-spinner" class="ai-loading mt-3">
            <div class="spinner-border spinner-border-sm text-primary me-2"></div>
            Consultando Inteligencia BPEZ Local...
        </div>

        <div id="ai-response-wrapper">
            <div class="ai-card text-start">
                <button class="btn-stop-ai shadow-sm" onclick="detenerVoz()" title="Detener voz">
                    <i class="fas fa-volume-mute"></i>
                </button>
                <button class="btn-cerrar-ai shadow-sm" onclick="cerrarRespuesta()" title="Cerrar respuesta">
                    <i class="fas fa-times"></i>
                </button>

                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-robot text-primary me-2"></i>
                    <span class="fw-bold text-uppercase" style="font-size: 0.75rem; color: #666;">Asistente Virtual BPEZ</span>
                </div>
                <div id="ai-response-text"></div>
            </div>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/background-animation.js"></script>
<script src="../js/ia_voice_global.js"></script>

<script>
// --- LÓGICA DE TIEMPO ---
function configurarBienvenida() {
    const ahora = new Date();
    const hora = ahora.getHours();
    
    let saludo = "Buen día";
    if (hora >= 12 && hora < 18) saludo = "Buenas tardes"; // Corregido: "tardes"
    if (hora >= 18 || hora < 5) saludo = "Buenas noches";  // Corregido: "noches"
    
    const opciones = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    document.getElementById('txt-saludo').innerText = saludo;
    document.getElementById('txt-fecha').innerText = ahora.toLocaleDateString('es-ES', opciones);
}

// --- CONEXIÓN AL MOTOR IA LOCAL ---
async function preguntarIA() {
    const input = document.getElementById('ai-input').value;
    const wrapper = document.getElementById('ai-response-wrapper');
    const textField = document.getElementById('ai-response-text');
    const loader = document.getElementById('loading-spinner');

    if (!input) return;

    // Usamos detenerVoz() que viene de ia_voice_global.js
    if (typeof detenerVoz === "function") detenerVoz();

    loader.style.display = 'block';
    wrapper.style.display = 'none';

    try {
        const response = await fetch('../../modules/ia_backend/ask_ia.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ prompt: input }) 
        });

        const data = await response.json();

        if (data.respuesta) {
            textField.innerHTML = data.respuesta.replace(/\n/g, '<br>');
            loader.style.display = 'none';
            wrapper.style.display = 'block';
            
            // Usamos hablar() que viene de ia_voice_global.js
            hablar(data.respuesta);
        }
    } catch (error) {
        loader.style.display = 'none';
        wrapper.style.display = 'block';
        textField.innerHTML = `<div class="alert alert-danger">Error de conexión con IA BPEZ.</div>`;
    }
}

// Esta función es necesaria aquí para manipular el DOM de esta página
function cerrarRespuesta() { 
    if (typeof detenerVoz === "function") detenerVoz(); 
    document.getElementById('ai-response-wrapper').style.display = 'none'; 
}

// Inicializar
document.addEventListener('DOMContentLoaded', configurarBienvenida);
document.getElementById('ai-input').addEventListener('keypress', (e) => { 
    if (e.key === 'Enter') preguntarIA(); 
});
</script>
</body>
</html>