<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargos y Funciones - BPEZ</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo-fuego: #CE2029;
            --bpez-dark-blue: #003366; 
            --bpez-azul-alegre: #0077B6;
            --header-bg-integrado: #e0f2f1;
        }

        .main-content { padding-top: 100px; padding-bottom: 60px; }
        .section-header { margin-bottom: 50px; text-align: center; }
        .title-underline { height: 4px; width: 80px; background: var(--bpez-rojo-fuego); margin: 15px auto; border-radius: 2px; }

        .cargo-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            height: 100%;
            border: none;
            border-left: 5px solid var(--bpez-azul-alegre);
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .cargo-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }

        .level-badge {
            font-size: 0.7rem;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 800;
            margin-bottom: 15px;
            display: inline-block;
        }

        .badge-estrategico { background: #ffe5e5; color: var(--bpez-rojo-fuego); }
        .badge-tactico { background: #e5f1ff; color: var(--bpez-azul-alegre); }
        .badge-operativo { background: var(--bpez-dark-blue); color: white; }

        .cargo-title { color: var(--bpez-dark-blue); font-weight: 800; font-size: 1.1rem; margin-bottom: 10px; }
        .cargo-desc { font-size: 0.88rem; color: #444; line-height: 1.6; text-align: justify; }
        .cargo-icon { font-size: 1.8rem; color: var(--bpez-dark-blue); margin-bottom: 15px; opacity: 0.8; }

        .btn-organigrama {
            background: var(--bpez-dark-blue);
            color: white;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
        }

        /* Estilos del Chatbot Flotante */
        #chat-container {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 350px;
            height: 450px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            display: none;
            flex-direction: column;
            z-index: 1001;
            overflow: hidden;
            border: 1px solid #ddd;
        }

        .chat-header { background: var(--bpez-dark-blue); color: white; padding: 15px; font-weight: bold; display: flex; justify-content: space-between; align-items: center; }
        #chat-box { flex: 1; padding: 15px; overflow-y: auto; background: #f9f9f9; font-size: 0.9rem; }
        .chat-input-area { padding: 10px; border-top: 1px solid #eee; display: flex; }
        .chat-input-area input { flex: 1; border: 1px solid #ddd; border-radius: 20px; padding: 8px 15px; outline: none; }
        .chat-input-area button { background: var(--bpez-azul-alegre); color: white; border: none; border-radius: 50%; width: 40px; margin-left: 5px; }

        .msg { margin-bottom: 10px; padding: 8px 12px; border-radius: 10px; max-width: 85%; }
        .msg-bot { background: #eee; align-self: flex-start; }
        .msg-user { background: var(--bpez-azul-alegre); color: white; align-self: flex-end; margin-left: auto; }

        #ia-launcher { position: fixed; bottom: 30px; right: 30px; z-index: 1000; }

        /* MODIFICACIÓN ZOOM (LUPA) */
        .img-zoomable { cursor: zoom-in; transition: transform 0.3s ease; }
        .img-zoomable.zoomed { transform: scale(1.8); cursor: zoom-out; }
        .modal-body { overflow: auto; }
    </style>
</head>
<body>

<?php include '../../includes/navbar.php'; ?>

<div class="main-content">
    <div class="container">
        
        <div class="section-header">
            <h2 class="fw-800" style="color: var(--bpez-dark-blue);">CARGOS Y FUNCIONES</h2>
            <div class="title-underline"></div>
            <p class="text-muted">Estructura Posicional basada en la descripción institucional de la BPEZ</p>
            
            <button class="btn btn-organigrama mt-3" data-bs-toggle="modal" data-bs-target="#modalOrganigrama">
                <i class="fas fa-sitemap me-2"></i> Ver Organigrama Posicional
            </button>
        </div>

        <div class="row mb-5">
            <div class="col-12"><h4 class="fw-bold mb-4" style="color: var(--bpez-rojo-fuego); border-bottom: 2px solid #eee; padding-bottom: 10px;">Nivel Estratégico</h4></div>
            <div class="col-md-6 mb-4">
                <div class="cargo-card" style="border-left-color: var(--bpez-rojo-fuego);">
                    <span class="level-badge badge-estrategico">Alta Dirección</span>
                    <div class="cargo-icon"><i class="fas fa-user-tie"></i></div>
                    <h5 class="cargo-title">Dirección General</h5>
                    <p class="cargo-desc">Encargada de la planificación y cumplimiento de la misión institucional: ser la puerta de entrada al conocimiento universal y albergue de la memoria zuliana.</p>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="cargo-card" style="border-left-color: var(--bpez-rojo-fuego);">
                    <span class="level-badge badge-estrategico">Marco Legal</span>
                    <div class="cargo-icon"><i class="fas fa-balance-scale"></i></div>
                    <h5 class="cargo-title">Consultoría Jurídica</h5>
                    <p class="cargo-desc">Asegura que el funcionamiento de la fundación se ajuste a leyes como la Ley Orgánica de la Administración Pública y los decretos regionales vigentes.</p>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12"><h4 class="fw-bold mb-4" style="color: var(--bpez-azul-alegre); border-bottom: 2px solid #eee; padding-bottom: 10px;">Nivel Táctico</h4></div>
            <div class="col-md-4 mb-4">
                <div class="cargo-card">
                    <span class="level-badge badge-tactico">Gerencia</span>
                    <div class="cargo-icon"><i class="fas fa-users"></i></div>
                    <h5 class="cargo-title">Gerencia Social</h5>
                    <p class="cargo-desc">Garantiza la extensión, visibilidad e imagen de los servicios bibliotecológicos. Aplica programas de alfabetización y accesibilidad telemática para la comunidad.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="cargo-card">
                    <span class="level-badge badge-tactico">Coordinación</span>
                    <div class="cargo-icon"><i class="fas fa-book"></i></div>
                    <h5 class="cargo-title">Servicios Bibliotecarios</h5>
                    <p class="cargo-desc">Define políticas para facilitar el acceso a recursos bibliográficos y no bibliográficos, tanto nacionales como internacionales.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="cargo-card">
                    <span class="level-badge badge-tactico">Administración</span>
                    <div class="cargo-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                    <h5 class="cargo-title">Administración y Finanzas</h5>
                    <p class="cargo-desc">Gestiona los recursos económicos y humanos viables para el desarrollo y mantenimiento de la red de bibliotecas en el Estado.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12"><h4 class="fw-bold mb-4" style="color: var(--bpez-azul-alegre); border-bottom: 2px solid #eee; padding-bottom: 10px;">Nivel Operativo</h4></div>
            <div class="col-md-4 mb-4">
                <div class="cargo-card" style="border-left-color: var(--bpez-dark-blue);">
                    <span class="level-badge badge-operativo">Tecnología</span>
                    <div class="cargo-icon"><i class="fas fa-laptop-code"></i></div>
                    <h5 class="cargo-title">Especialistas Sala Digital</h5>
                    <p class="cargo-desc">Encargados de dar soporte e información tecnológica. Facilitan cursos de Alfabetización tecnológica en zonas interactivas y del tecnoverso.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="cargo-card" style="border-left-color: var(--bpez-dark-blue);">
                    <span class="level-badge badge-operativo">Investigación</span>
                    <div class="cargo-icon"><i class="fas fa-archive"></i></div>
                    <h5 class="cargo-title">Analistas de Hemeroteca</h5>
                    <p class="cargo-desc">Promueven el acceso al conocimiento a través de la investigación y consulta de la colección hemero-bibliográfica Eduardo López Rivas.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="cargo-card" style="border-left-color: var(--bpez-dark-blue);">
                    <span class="level-badge badge-operativo">Atención</span>
                    <div class="cargo-icon"><i class="fas fa-info-circle"></i></div>
                    <h5 class="cargo-title">Atención al Ciudadano</h5>
                    <p class="cargo-desc">Guían al visitante mediante instrucciones sobre la ubicación de cada zona y los servicios de libre acceso disponibles en la institución.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalOrganigrama" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" style="color: var(--bpez-dark-blue);">Organigrama Posicional Oficial BPEZ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center bg-light">
                <img src="../img/organigrama_posicional_definitivo.png" class="img-fluid rounded shadow img-zoomable" alt="Organigrama Posicional" onclick="toggleZoom(this)">
                <div class="d-flex justify-content-between align-items-center px-3 mt-3">
                    <span class="text-muted small">Fecha de subida: 18/02/2026</span>
                    <a href="../img/organigrama_posicional_definitivo.png" download class="btn btn-primary"><i class="fas fa-download me-2"></i>Descargar Esquema</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="chat-container">
    <div class="chat-header">
        <span><i class="fas fa-robot me-2"></i> Asistente BPEZ</span>
        <button class="btn btn-sm text-white" onclick="toggleChat()"><i class="fas fa-times"></i></button>
    </div>
    <div id="chat-box" class="d-flex flex-column">
        <div class="msg msg-bot">¡Hola! Soy el asistente de la BPEZ. ¿En qué puedo ayudarte hoy respecto a los cargos y funciones?</div>
    </div>
    <div class="chat-input-area">
        <input type="text" id="user-input" placeholder="Escribe tu pregunta..." onkeypress="handleKey(event)">
        <button onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<div id="ia-launcher">
    <button class="btn btn-primary shadow-lg rounded-circle p-3" onclick="toggleChat()" title="Consultar Asistente de IA">
        <i class="fas fa-robot fa-2x"></i>
    </button>
</div>

<?php include '../../includes/footer.php'; ?>

<script>
    // NUEVA FUNCIÓN DE ZOOM (LUPA)
    function toggleZoom(elemento) {
        elemento.classList.toggle('zoomed');
    }

    function toggleChat() {
        const chat = document.getElementById('chat-container');
        chat.style.display = (chat.style.display === 'none' || chat.style.display === '') ? 'flex' : 'none';
    }

    function handleKey(e) { if (e.key === 'Enter') sendMessage(); }

    async function sendMessage() {
        const input = document.getElementById('user-input');
        const message = input.value.trim();
        if (!message) return;

        appendMessage(message, 'user');
        input.value = '';

        try {
            const response = await fetch('../../modules/ia_backend/ask_ia.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'question=' + encodeURIComponent(message)
            });
            const data = await response.text();
            appendMessage(data, 'bot');
        } catch (error) {
            appendMessage("Lo siento, hubo un error al conectar con el servidor.", 'bot');
        }
    }

    function appendMessage(text, side) {
        const box = document.getElementById('chat-box');
        const div = document.createElement('div');
        div.className = `msg msg-${side}`;
        div.innerText = text;
        box.appendChild(div);
        box.scrollTop = box.scrollHeight;
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/background-animation.js"></script>
</body>
</html>