<style>
    /* --- ESTRUCTURA MODERNA FLOTANTE (GLASSMORPHISM) --- */
    .top-nav { 
        background: rgba(224, 242, 241, 0.85);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.4); 
        border-radius: 0 0 20px 20px;
        padding: 8px 0;
        position: fixed;
        top: 0;
        left: 10px;
        right: 10px;
        z-index: 1050; 
        box-shadow: 0 10px 30px rgba(0, 51, 102, 0.08);
        animation: slideDown 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideDown {
        from { transform: translateY(-100%); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .logo-container { 
        height: 85px; 
        display: flex; 
        align-items: center; 
        gap: 15px;
        position: relative; 
    }

    .logo-img { 
        height: 125%; 
        object-fit: contain;
        position: absolute;
        top: -10px; 
        z-index: 1100;
        filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .logo-img:hover { transform: scale(1.1) rotate(-2deg); }

    .btn-intranet { 
        margin-left: 130px; 
        background-color: var(--bpez-rojo-fuego);
        border: none;
        font-weight: 800;
        color: white; 
        padding: 8px 20px;
        border-radius: 50px;
        font-size: 0.9rem; 
        text-decoration: none;
        display: inline-block;
        box-shadow: 0 4px 15px rgba(206, 32, 41, 0.25);
        transition: all 0.3s ease;
    }
    .btn-intranet:hover { 
        background-color: var(--bpez-dark-blue);
        color: white; 
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(0, 51, 102, 0.3);
    }

    /* --- BOTONES NAV-DROP --- */
    .nav-drop { 
        background-color: var(--bpez-rojo-fuego);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 10px 18px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 4px 12px rgba(206, 32, 41, 0.15);
    }

    .nav-drop:hover { 
        background-color: var(--bpez-dark-blue); 
        color: white; 
        transform: translateY(-3px); 
        box-shadow: 0 8px 20px rgba(0, 51, 102, 0.25);
    }

    /* --- DROPDOWNS MEJORADOS --- */
    .dropdown { position: relative; }

    .dropdown-menu { 
        background: rgba(206, 32, 41, 0.98); 
        backdrop-filter: blur(15px);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 10px;
        z-index: 1100;
        display: block !important; 
        visibility: hidden;
        opacity: 0;
        
        /* Ajuste de posición inicial (más cerca del botón) */
        top: 90% !important; 
        transform: translateY(10px); 
        
        transition: opacity 0.3s ease, transform 0.3s ease, visibility 0s linear 0.2s;
        left: 0 !important;
        min-width: 230px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    }

    /* Puente invisible ajustado a 10px */
    .dropdown-menu::before {
        content: "";
        position: absolute;
        top: -10px;
        left: 0;
        right: 0;
        height: 10px;
        background: transparent;
    }

    .dropdown:hover > .dropdown-menu { 
        visibility: visible;
        opacity: 1;
        /* Posición final al hacer hover (reducido a solo 5px de separación) */
        transform: translateY(5px); 
        transition-delay: 0s;
    }

    .dropdown-item { 
        color: white !important; 
        border-radius: 10px; 
        font-size: 0.88rem; 
        padding: 12px 15px; 
        transition: all 0.3s ease; 
    }

    .dropdown-item i { width: 25px; transition: transform 0.3s; }

    .dropdown-item:hover { 
        background-color: rgba(255, 255, 255, 0.15) !important; 
        padding-left: 20px;
    }
    
    .dropdown-item:hover i { transform: scale(1.2); color: var(--bpez-cian); }

    .user-dropdown-btn { 
        border: none;
        border-radius: 50px;
        background: var(--bpez-azul-alegre);
        color: white;
        font-weight: 800;
        padding: 8px 22px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 119, 182, 0.2);
    }
    .user-dropdown-btn:hover { 
        background: var(--bpez-dark-blue); 
        transform: translateY(-2px);
    }

    /* --- RESPONSIVE LOGIC --- */
    @media (max-width: 1200px) {
        .btn-intranet { margin-left: 110px; padding: 6px 12px; font-size: 0.8rem; }
        .nav-drop { padding: 8px 10px; font-size: 0.8rem; }
    }

    @media (max-width: 992px) {
        .top-nav { left: 0; right: 0; border-radius: 0; }
        .logo-container { height: 60px; }
        .logo-img { height: 140%; top: -5px; } 
        .btn-intranet { margin-left: 90px; }
        .d-flex.justify-content-center { justify-content: space-around !important; flex-wrap: wrap; margin-top: 15px; }
    }

    @media (max-width: 576px) {
        .btn-intranet span { display: none; } 
        .btn-intranet { margin-left: 75px; padding: 8px 12px; }
        .nav-drop { font-size: 0.7rem; padding: 6px 8px; width: 48%; text-align: center; }
        .user-dropdown-btn { padding: 5px 12px; font-size: 0.75rem; }
    }
</style>

<header class="top-nav">
    <div class="container-fluid px-4">
        <div class="row align-items-center">
            <div class="col-6 col-md-3">
                <div class="logo-container">
                    <img src="../img/logo.png" alt="Logo BPEZ" class="logo-img">
                    <a href="principal_frontend.php" class="btn-intranet">
                        <i class="fas fa-home"></i> <span>INTRANET</span>
                    </a>
                </div>
            </div>

            <div class="col-12 col-md-7 order-3 order-md-2">
                <div class="d-flex justify-content-center gap-2 gap-lg-3">
                    
                    <div class="dropdown">
                        <button class="btn nav-drop dropdown-toggle">La organización</button>
                        <ul class="dropdown-menu shadow">
                            <li><a class="dropdown-item" href="/../../assets/frontend/cargos_frontend.php"><i class="fas fa-id-badge me-2"></i>Cargos</a></li>
                            <li><a class="dropdown-item" href="/../../assets/frontend/procedimientos_frontend.php"><i class="fas fa-cogs me-2"></i>Procedimientos</a></li>
                            <li><a class="dropdown-item" href="/../../assets/frontend/organizacion_frontend.php"><i class="fas fa-sitemap me-2"></i>Organización</a></li>
                        </ul>
                    </div>
                    
                    <div class="dropdown">
                        <button class="btn nav-drop dropdown-toggle">Gestión Estratégica</button>
                        <ul class="dropdown-menu shadow">
                            <li><a class="dropdown-item" href="/../../assets/frontend/planificacion_frontend.php"><i class="fas fa-calendar-alt me-2"></i>Planificación</a></li>
                            <li><a class="dropdown-item" href="/../../assets/frontend/proyectos_frontend.php"><i class="fas fa-project-diagram me-2"></i>Proyectos</a></li>
                            <li><a class="dropdown-item" href="/../../assets/frontend/reuniones_frontend.php"><i class="fas fa-users-cog me-2"></i>Reuniones Gerenciales</a></li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="btn nav-drop dropdown-toggle">Control</button>
                        <ul class="dropdown-menu shadow">
                            <li><a class="dropdown-item" href="/../../assets/frontend/reportes_actividades_frontend.php"><i class="fas fa-file-alt me-2"></i>Reporte de Actividades</a></li>
                            <li><a class="dropdown-item" href="/../../assets/frontend/informes_gestion_frontend.php"><i class="fas fa-chart-line me-2"></i>Informe de Gestión</a></li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="btn nav-drop dropdown-toggle d-flex align-items-center">Seguridad</button>
                        <ul class="dropdown-menu shadow">
                            <li><a class="dropdown-item" href="/../../assets/frontend/leyes_nacionales_frontend.php"><i class="fas fa-gavel me-2"></i>Leyes Nacionales</a></li>
                            <li><a class="dropdown-item" href="/../../assets/frontend/reglamento_interno_frontend.php"><i class="fas fa-file-contract me-2"></i>Reglamento Interno</a></li>
                            <li><a class="dropdown-item" href="/../../assets/frontend/seguridad_laboral_frontend.php"><i class="fas fa-hard-hat me-2"></i>Seguridad Laboral</a></li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-6 col-md-2 text-end order-2 order-md-3">
                <div class="dropdown">
                    <button class="btn user-dropdown-btn dropdown-toggle shadow-sm">
                        <i class="fas fa-user-circle me-1"></i> Admin
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><a class="dropdown-item" href="/../assets/frontend/perfil_frontend.php"><i class="fas fa-user-cog me-2"></i>Mi Perfil</a></li>
                        <li><hr class="dropdown-divider bg-white opacity-25"></li>
                        <li><a class="dropdown-item" href="../../../index.php"><i class="fas fa-sign-out-alt me-2"></i>Salir</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>