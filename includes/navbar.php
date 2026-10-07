<style>
    :root {
        --bpez-cian: #76C7C0;
        --bpez-rojo-fuego: #CE2029;
        --bpez-dark-blue: #003366; 
        --bpez-azul-alegre: #0077B6;
        --header-bg-integrado: #e0f2f1;
        --navbar-height: 130px;
    }

    /* --- ESTRUCTURA MODERNA FLOTANTE (GLASSMORPHISM) --- */
    .top-nav { 
        background: rgba(224, 242, 241, 0.95);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.4); 
        border-radius: 0 0 20px 20px;
        padding: 18px 0;
        position: fixed;
        top: 0;
        left: 20px;
        right: 20px;
        z-index: 1050; 
        box-shadow: 0 10px 30px rgba(0, 51, 102, 0.08);
        animation: slideDown 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        width: calc(100% - 40px);
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    @keyframes slideDown {
        from { transform: translateY(-100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* --- BOTÓN HAMBURGUESA (solo visible en móvil) --- */
    .hamburger-btn {
        display: none;
        background: transparent;
        border: 2px solid var(--bpez-dark-blue);
        color: var(--bpez-dark-blue);
        font-size: 1.8rem;
        padding: 5px 15px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .hamburger-btn:hover {
        background: var(--bpez-dark-blue);
        color: white;
        border-color: var(--bpez-dark-blue);
    }

    /* --- LOGO MÁS GRANDE, MÁS ANCHO Y MÁS ABAJO --- */
    .logo-container { 
        height: 85px;
        display: flex; 
        align-items: center; 
        gap: 30px;
        position: relative; 
    }

    .logo-img { 
        height: 135%;
        object-fit: contain;
        position: absolute;
        top: -12px;
        z-index: 1100;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .logo-img:hover { transform: scale(1.1) rotate(-2deg); }

    /* BOTÓN INTRANET */
    .btn-intranet { 
        margin-left: 150px;
        background-color: var(--bpez-dark-blue);
        border: none;
        font-weight: 800;
        color: white; 
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 4px 15px rgba(0, 51, 102, 0.25);
        transition: all 0.3s ease;
        line-height: 1;
    }
    .btn-intranet:hover { 
        background-color: var(--bpez-rojo-fuego);
        color: white; 
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(206, 32, 41, 0.3);
    }

    /* --- BOTONES DE MÓDULOS --- */
    .btn-modulo { 
        background-color: var(--bpez-dark-blue);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 6px 16px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 4px 12px rgba(0, 51, 102, 0.15);
        white-space: nowrap;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .btn-modulo:hover { 
        background-color: var(--bpez-rojo-fuego);
        color: white; 
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(206, 32, 41, 0.25);
    }

    /* --- CONTENEDOR DE MÓDULOS --- */
    .modules-container {
        display: flex;
        flex-direction: column;
        gap: 8px;
        width: 100%;
        transition: all 0.3s ease;
    }

    .modules-row {
        display: flex;
        justify-content: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    /* BOTÓN CIRCULAR LIBRO ABIERTO (BIBLIOTECA) - CELESTE */
    .btn-biblioteca {
        width: 45px;
        height: 45px;
        background-color: #5BC0DE; /* Celeste como en la imagen */
        color: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(91, 192, 222, 0.3);
        border: 2px solid rgba(255, 255, 255, 0.8);
        margin-right: 12px;
        flex-shrink: 0;
        font-size: 1.2rem;
    }

    .btn-biblioteca i {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
    }

    .btn-biblioteca:hover {
        background-color: var(--bpez-rojo-fuego);
        transform: scale(1.1) rotate(5deg);
        color: white;
        box-shadow: 0 6px 20px rgba(206, 32, 41, 0.3);
    }

    /* BOTÓN ADMIN */
    .user-dropdown-btn { 
        border: none;
        border-radius: 50px;
        background-color: var(--bpez-azul-alegre);
        color: white;
        font-weight: 700;
        padding: 6px 18px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 119, 182, 0.2);
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .user-dropdown-btn:hover { 
        background-color: var(--bpez-rojo-fuego);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(206, 32, 41, 0.3);
    }

    /* Dropdown del usuario */
    .dropdown-menu { 
        background: rgba(0, 51, 102, 0.98);
        backdrop-filter: blur(15px);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 8px;
        z-index: 1100;
        display: block !important; 
        visibility: hidden;
        opacity: 0;
        top: 95% !important;
        transform: translateY(8px);
        transition: opacity 0.3s ease, transform 0.3s ease, visibility 0s linear 0.2s;
        left: auto !important;
        right: 0 !important;
        min-width: 180px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    }

    .dropdown:hover > .dropdown-menu { 
        visibility: visible;
        opacity: 1;
        transform: translateY(3px);
        transition-delay: 0s;
    }

    .dropdown-item { 
        color: white !important; 
        border-radius: 8px;
        font-size: 0.8rem;
        padding: 8px 12px;
        transition: all 0.3s ease; 
    }

    .dropdown-item:hover { 
        background-color: var(--bpez-rojo-fuego) !important;
        color: white !important;
        padding-left: 16px;
    }

    /* --- RESPONSIVE COMPLETO CON HAMBURGUESA --- */

    /* Pantallas grandes */
    @media (min-width: 1400px) {
        .top-nav { padding: 8px 0; }
        .logo-container { height: 95px; gap: 35px; }
        .logo-img { height: 140%; top: -14px; }
        .btn-intranet { margin-left: 170px; font-size: 0.9rem; padding: 8px 20px; }
        .btn-modulo { font-size: 0.9rem; padding: 8px 20px; }
        .modules-row { gap: 16px; }
        .btn-biblioteca { width: 50px; height: 50px; margin-right: 15px; font-size: 1.4rem; }
        .user-dropdown-btn { font-size: 0.9rem; padding: 8px 22px; }
    }

    /* Escritorio */
    @media (max-width: 1200px) {
        .btn-intranet { margin-left: 130px; padding: 5px 14px; font-size: 0.75rem; }
        .btn-modulo { padding: 5px 12px; font-size: 0.7rem; }
        .modules-row { gap: 8px; }
        .logo-container { height: 80px; gap: 25px; }
        .logo-img { height: 130%; top: -10px; }
        .btn-biblioteca { width: 42px; height: 42px; margin-right: 10px; font-size: 1.1rem; }
        .user-dropdown-btn { padding: 5px 15px; font-size: 0.75rem; }
    }

    /* Tablets landscape */
    @media (max-width: 992px) {
        .top-nav { left: 15px; right: 15px; width: calc(100% - 30px); padding: 15px 0; }
        .logo-container { height: 70px; gap: 20px; }
        .logo-img { height: 125%; top: -8px; } 
        .btn-intranet { margin-left: 110px; padding: 5px 12px; font-size: 0.7rem; }
        .btn-modulo { padding: 5px 10px; font-size: 0.65rem; }
        .modules-row { gap: 6px; }
        .btn-biblioteca { width: 40px; height: 40px; margin-right: 8px; font-size: 1rem; }
        .user-dropdown-btn { padding: 5px 14px; font-size: 0.7rem; }
    }

    /* Tablets portrait - ACTIVAR HAMBURGUESA */
    @media (max-width: 850px) {
        .top-nav { left: 10px; right: 10px; width: calc(100% - 20px); padding: 12px 0; }
        
        .hamburger-btn {
            display: block;
        }
        
        .modules-container {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(224, 242, 241, 0.98);
            backdrop-filter: blur(15px);
            padding: 20px;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        
        .modules-container.show {
            display: flex;
        }
        
        .modules-row {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }
        
        .btn-modulo {
            width: 100%;
            justify-content: flex-start;
            padding: 12px 15px;
            font-size: 0.9rem;
        }
        
        .btn-modulo i {
            width: 25px;
        }
        
        .logo-container { height: 60px; gap: 15px; }
        .logo-img { height: 120%; top: -6px; }
        .btn-intranet { margin-left: 95px; padding: 5px 12px; }
        .btn-intranet span { display: inline; }
        .btn-biblioteca { width: 38px; height: 38px; margin-right: 8px; font-size: 1rem; }
        .user-dropdown-btn { padding: 5px 12px; font-size: 0.75rem; }
    }

    /* Móviles grandes */
    @media (max-width: 576px) {
        .top-nav { padding: 10px 0; }
        .logo-container { height: 50px; gap: 12px; }
        .logo-img { height: 115%; top: -4px; }
        .btn-intranet { margin-left: 80px; padding: 4px 10px; }
        .btn-intranet span { display: inline; }
        .btn-modulo { font-size: 0.85rem; padding: 10px 12px; }
        .btn-biblioteca { width: 35px; height: 35px; margin-right: 6px; font-size: 0.9rem; }
        .user-dropdown-btn { padding: 4px 10px; font-size: 0.65rem; }
        .user-dropdown-btn span { display: none; }
    }

    /* Móviles pequeños */
    @media (max-width: 400px) {
        .top-nav { padding: 8px 0; }
        .logo-container { height: 45px; gap: 10px; }
        .logo-img { height: 110%; top: -3px; }
        .btn-intranet { margin-left: 70px; padding: 3px 8px; }
        .btn-intranet i { font-size: 0.9rem; }
        .btn-intranet span { display: none; }
        .btn-modulo { font-size: 0.8rem; padding: 8px 10px; }
        .btn-biblioteca { width: 32px; height: 32px; margin-right: 5px; font-size: 0.8rem; }
        .user-dropdown-btn { padding: 3px 8px; font-size: 0.6rem; }
        .user-dropdown-btn i { font-size: 0.8rem; }
    }
</style>

<header class="top-nav">
    <div class="container-fluid px-3">
        <div class="row align-items-center">
            
            <!-- Logo e Intranet -->
            <div class="col-6 col-md-2">
                <div class="logo-container">
                    <img src="/assets/img/logo.png" alt="Logo BPEZ" class="logo-img">
                    <a href="/modules/principal_backend/principal_backend.php" class="btn-intranet">
                        <i class="fas fa-home"></i> <span>INTRANET</span>
                    </a>
                </div>
            </div>

            <!-- Botón hamburguesa (solo visible en móvil) -->
            <div class="col-2 d-md-none text-center">
                <button class="hamburger-btn" onclick="toggleMenu()">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- MÓDULOS EN DOS FILAS - Se ocultan en móvil hasta hacer click -->
            <div class="col-12 col-md-8 order-3 order-md-2" id="modulesWrapper">
                <div class="modules-container" id="modulesContainer">
                    <!-- PRIMERA FILA: Módulos 1-5 -->
                    <div class="modules-row">
                        <a href="/modules/contexto/contexto.php" class="btn-modulo"><i class="fas fa-globe me-2"></i> Contexto</a>
                        <a href="/modules/institucion/institucion.php" class="btn-modulo"><i class="fas fa-university me-2"></i> Institución</a>
                        <a href="/modules/cargos/cargos.php" class="btn-modulo"><i class="fas fa-user-tie me-2"></i> Cargos</a>
                        <a href="/modules/procedimientos/procedimientos.php" class="btn-modulo"><i class="fas fa-cogs me-2"></i> Procedimientos</a>
                        <a href="/modules/gestion/gestion.php" class="btn-modulo"><i class="fas fa-chart-line me-2"></i> Gestión</a>
                    </div>
                    <!-- SEGUNDA FILA: Módulos 6-10 -->
                    <div class="modules-row">
                        <a href="/modules/desempeno/desempeno.php" class="btn-modulo"><i class="fas fa-tachometer-alt me-2"></i> Desempeño</a>
                        <a href="/modules/sgc/sgc.php" class="btn-modulo"><i class="fas fa-certificate me-2"></i> S.G.C</a>
                        <a href="/modules/personal/personal.php" class="btn-modulo"><i class="fas fa-users me-2"></i> Personal</a>
                        <a href="/modules/aula_virtual/aula_virtual.php" class="btn-modulo"><i class="fas fa-chalkboard-teacher me-2"></i> Aula Virtual</a>
                        <a href="/modules/archivo_digital/archivo_digital.php" class="btn-modulo"><i class="fas fa-folder-open me-2"></i> Archivo Digital</a>
                    </div>
                </div>
            </div>

            <!-- Acciones de usuario (libro abierto + admin) -->
            <div class="col-4 col-md-2 text-end order-2 order-md-3">
                <div class="d-flex align-items-center justify-content-end">
                    
                    <!-- BOTÓN DE LIBRO ABIERTO (BIBLIOTECA) - PARA TODOS -->
                    <a href="/modules/actualizacion_biblioteca_digital/actualizacion_biblioteca_digital.php" class="btn-biblioteca" title="Biblioteca Digital">
                        <i class="fas fa-book-open"></i> <!-- Icono de libro abierto -->
                    </a>

                    <!-- Botón de usuario con dropdown -->
                    <div class="dropdown">
                        <?php
                        $nombre_usuario = trim(($_SESSION['primer_nombre'] ?? '') . ' ' . ($_SESSION['primer_apellido'] ?? ''));
                        if (empty($nombre_usuario)) {
                            $nombre_usuario = 'Usuario';
                        }
                        ?>
                        <button class="btn user-dropdown-btn dropdown-toggle shadow-sm">
                            <i class="fas fa-user-circle me-1"></i> <span><?php echo $nombre_usuario; ?></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <!-- MI PERFIL - Siempre visible para todos -->
                            <li><a class="dropdown-item" href="/modules/perfil/perfil.php"><i class="fas fa-user-cog me-2"></i>Mi Perfil</a></li>
                            
                            <!-- PANEL ADMINISTRATIVO - Solo visible para Administradores -->
                            <?php if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] == 1): ?>
                                <li><a class="dropdown-item" href="/modules/admin/panel_admin.php"><i class="fas fa-cog me-2"></i>Panel Administrativo</a></li>
                            <?php endif; ?>
                            
                            <li><hr class="dropdown-divider bg-white opacity-25"></li>
                            <li><a class="dropdown-item" href="/auth/logout.php"><i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
function toggleMenu() {
    const container = document.getElementById('modulesContainer');
    container.classList.toggle('show');
}

// Cerrar menú al hacer click fuera
document.addEventListener('click', function(event) {
    const container = document.getElementById('modulesContainer');
    const hamburger = document.querySelector('.hamburger-btn');
    
    if (!container || !hamburger) return;
    
    if (!container.contains(event.target) && !hamburger.contains(event.target) && container.classList.contains('show')) {
        container.classList.remove('show');
    }
});
</script>