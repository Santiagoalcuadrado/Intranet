<?php
// /includes/buscador_ia.php
// Componente de Buscador IA para la Intranet BPEZ
// Incluir con: <?php include '../../includes/buscador_ia.php'; ?>

<!-- ===== ESTILOS DEL BUSCADOR IA ===== -->
<style>
/* ===== BUSCADOR IA ===== */
.ai-search-container { 
    max-width: 900px; 
    margin: 5px auto 0 auto;
    width: 90%;
    flex-shrink: 0;
}

.search-wrapper {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 10px;
}

/* ===== BUSCADOR PILL ===== */
.search-pill { 
    flex: 1;
    border: 1px solid var(--bpez-cian);
    border-radius: 50px;
    padding: 5px 15px;
    display: flex;
    align-items: center;
    background: white;
    min-height: 55px;
    box-shadow: 0 8px 32px rgba(0, 51, 102, 0.1);
}

.search-input { 
    border: none; 
    outline: none; 
    width: 100%; 
    text-align: center; 
    color: var(--bpez-dark-blue); 
    font-weight: 500;
    font-size: 0.9rem;
    padding: 8px 5px;
}

.btn-buscar { 
    background: var(--bpez-rojo-fuego); 
    color: white; 
    border-radius: 50px; 
    padding: 6px 20px; 
    border: none; 
    font-weight: 600; 
    cursor: pointer;
    white-space: nowrap;
    font-size: 0.85rem;
    transition: all 0.2s;
}

.btn-buscar:hover {
    background: var(--bpez-dark-blue);
    transform: translateY(-2px);
}

.search-pill .dropdown-menu {
    min-width: 200px;
    margin-top: 10px !important;
}

/* ===== RESPUESTA DE IA ===== */
#ai-response-wrapper { 
    display: none;
    max-width: 900px; 
    margin: 10px auto 0 auto;
    animation: fadeInUp 0.5s ease;
    max-height: 180px;
    overflow-y: auto;
    width: 90%;
}

.ai-card { 
    position: relative;
    background: white; 
    border-radius: 20px; 
    border-left: 6px solid var(--bpez-azul-alegre); 
    padding: 18px; 
    box-shadow: 0 10px 30px rgba(0,0,0,0.08); 
}

.btn-cerrar-ai, .btn-stop-ai {
    position: absolute;
    background-color: var(--bpez-rojo-fuego);
    color: white;
    border: none;
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    font-size: 0.8rem;
}
.btn-cerrar-ai { top: 10px; right: 10px; }
.btn-stop-ai { top: 10px; right: 45px; background-color: var(--bpez-dark-blue); }

.ai-loading { 
    display: none; 
    color: var(--bpez-dark-blue); 
    font-weight: 600; 
    margin-top: 5px; 
    font-size: 0.8rem;
    text-align: center;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== MEDIA QUERIES - RESPONSIVE ===== */
@media (max-width: 992px) {
    .ai-search-container {
        width: 95%;
    }
}

@media (max-width: 768px) {
    .search-wrapper {
        gap: 10px;
    }
    .ai-search-container {
        margin-bottom: 25px;
    }
    .search-pill {
        min-height: 50px;
        padding: 5px 10px;
    }
    .btn-buscar {
        padding: 5px 12px;
        font-size: 0.75rem;
    }
}

@media (max-width: 576px) {
    .search-wrapper {
        flex-direction: column;
        align-items: stretch;
    }
    .search-pill {
        width: 100%;
    }
    .search-input {
        font-size: 0.8rem;
    }
    .ai-search-container {
        margin-bottom: 30px;
    }
    #ai-response-wrapper {
        max-height: 150px;
    }
}
</style>

<!-- ===== HTML DEL BUSCADOR IA ===== -->
<div class="ai-search-container">
    <div class="search-wrapper">
        <!-- ===== AVATAR 3D (SE INCLUIRÁ APARTE) ===== -->
        <!-- Nota: El avatar 3D se incluye directamente en el HTML principal -->
        
        <!-- Buscador pill con input y botones -->
        <div class="search-pill">
            <input type="text" id="ai-input" class="search-input" placeholder="Buscador Artificial Inteligente Local (BPEZ)">
            
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
            <button class="btn-buscar shadow-sm" onclick="preguntarIA()">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    <!-- Loading spinner (oculto inicialmente) -->
    <div id="loading-spinner" class="ai-loading">
        <div class="spinner-border spinner-border-sm text-primary me-2"></div>
        Consultando Inteligencia BPEZ Local...
    </div>

    <!-- ===== RESPUESTA DE IA ===== -->
    <div id="ai-response-wrapper">
        <div class="ai-card text-start">
            <!-- Botones de control -->
            <button class="btn-stop-ai shadow-sm" onclick="detenerVoz()" title="Detener voz">
                <i class="fas fa-volume-mute"></i>
            </button>
            <button class="btn-cerrar-ai shadow-sm" onclick="cerrarRespuesta()" title="Cerrar respuesta">
                <i class="fas fa-times"></i>
            </button>

            <!-- Encabezado de la respuesta -->
            <div class="d-flex align-items-center mb-2">
                <i class="fas fa-robot text-primary me-2"></i>
                <span class="fw-bold text-uppercase" style="font-size: 0.7rem; color: #666;">Asistente Virtual BPEZ</span>
            </div>
            <!-- Texto de respuesta -->
            <div id="ai-response-text" style="font-size: 0.85rem;"></div>
        </div>
    </div>
</div>