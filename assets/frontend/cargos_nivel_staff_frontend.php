<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?> - Intranet BPEZ</title>
    
    <!-- ===== RECURSOS OFFLINE (MODULAR) ===== -->
    <!-- Incluye Bootstrap CSS, Font Awesome y Montserrat local -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/offline_assets.php'; ?>
    
    <!-- ===== FAVICONS (MODULAR) ===== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/favicon.php'; ?>
    
    <style>
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo-fuego: #CE2029;
            --bpez-dark-blue: #003366; 
            --bpez-azul-alegre: #0077B6;
            --header-bg-integrado: #e0f2f1;
            --navbar-height: 130px;
        }

        html, body { 
            height: 100%; 
            margin: 0; 
            overflow: auto; 
        }
        
        body { 
            display: flex; 
            flex-direction: column; 
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            color: #333;
        }

        .main-content { 
            flex: 1;
            padding: calc(var(--navbar-height) + 20px) 20px 40px 20px;
        }

        /* CONTENEDOR PRINCIPAL */
        .cargos-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Tarjeta principal estilo vidrio blanco */
        .cargos-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 6px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
        }

        .cargos-card:hover {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            color: var(--bpez-dark-blue);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            border-bottom: 2px solid var(--bpez-cian);
            display: inline-block;
            padding-bottom: 3px;
            font-size: clamp(1rem, 3vw, 1.4rem);
        }

        /* Texto principal de introducción */
        .intro-text {
            color: var(--bpez-dark-blue);
            font-size: clamp(0.90rem, 2vw, 1rem);
            line-height: 1.4;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .intro-text i {
            color: var(--bpez-rojo-fuego);
            margin: 0 5px;
            font-size: clamp(0.8rem, 1.6vw, 1rem);
        }

        /* Contenedor de dos columnas */
        .staff-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 10px;
        }

        /* Tarjeta de lista de cargos */
        .lista-cargos {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 6px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
            height: 100%;
        }

        .lista-cargos:hover {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .lista-titulo {
            color: var(--bpez-dark-blue);
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 20px;
            border-left: 4px solid var(--bpez-rojo-fuego);
            padding-left: 12px;
        }

        /* Elementos de la lista */
        .cargo-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border-left: 3px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
        }

        .cargo-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
            border-left-color: var(--bpez-rojo-fuego);
        }

        .cargo-item i {
            color: var(--bpez-azul-alegre);
            font-size: 1.5rem;
            margin-right: 15px;
            width: 30px;
            text-align: center;
            transition: color 0.3s ease;
        }

        .cargo-item:hover i {
            color: var(--bpez-rojo-fuego);
        }

        .cargo-info {
            flex: 1;
        }

        .cargo-nombre {
            font-weight: 600;
            color: var(--bpez-dark-blue);
            font-size: 1rem;
            margin-bottom: 3px;
        }

        .cargo-descripcion {
            font-size: 0.8rem;
            color: var(--bpez-dark-blue);
            opacity: 0.7;
        }

        .cargo-badge {
            background: rgba(0, 119, 182, 0.1);
            color: var(--bpez-azul-alegre);
            padding: 4px 10px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 10px;
        }

        footer {
            flex-shrink: 0;
        }

        /* ===== MEDIA QUERIES COMPLETAS ===== */

        @media (min-width: 1400px) {
            .cargos-container {
                max-width: 1300px;
                gap: 25px;
            }
            .cargos-card {
                padding: 20px;
            }
            .lista-cargos {
                padding: 30px;
            }
            .cargo-item {
                padding: 15px 18px;
            }
        }

        @media (min-width: 992px) and (max-width: 1399px) {
            .cargos-container {
                max-width: 1100px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 30px 15px; 
            }
            .cargos-card { 
                padding: 15px; 
            }
            .lista-cargos {
                padding: 20px;
            }
            .cargo-item {
                padding: 10px 12px;
            }
        }

        @media (max-width: 767px) {
            .staff-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 25px 15px; 
            }
            .cargos-card { 
                padding: 15px; 
            }
            .section-title {
                font-size: 1.2rem;
            }
            .intro-text {
                font-size: 0.8rem;
                padding: 10px;
            }
            .lista-cargos {
                padding: 20px;
            }
        }

        @media (max-width: 575px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 12px 25px 12px; 
            }
            .cargos-card { 
                padding: 12px; 
            }
            .section-title {
                font-size: 1.1rem;
            }
            .intro-text {
                font-size: 0.75rem;
                padding: 8px;
                margin: 0 5px;
            }
            .lista-cargos {
                padding: 15px;
            }
            .cargo-item {
                padding: 10px;
                flex-wrap: wrap;
            }
            .cargo-item i {
                font-size: 1.2rem;
                margin-right: 10px;
            }
            .cargo-nombre {
                font-size: 0.9rem;
            }
            .cargo-descripcion {
                font-size: 0.7rem;
            }
            .cargo-badge {
                margin-left: 0;
                margin-top: 5px;
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 400px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 10px) 10px 20px 10px; 
            }
            .cargos-card { 
                padding: 10px; 
            }
            .intro-text {
                font-size: 0.7rem;
                padding: 6px;
            }
            .lista-cargos {
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR INCLUIDO ===== -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

<!-- ===== CONTENIDO PRINCIPAL ===== -->
<div class="main-content">
    <div class="cargos-container">
        
        <!-- PRIMERA CARD: Título y texto introductorio -->
        <div class="cargos-card">
            <div class="text-center mb-2">
                <i class="fas fa-chart-line" style="color: var(--bpez-azul-alegre); font-size: 2rem;"></i>
                <h2 class="section-title mt-1">Cargos - Nivel Staff</h2>
            </div>

            <!-- Texto de introducción -->
            <div class="intro-text">
                <i class="fas fa-quote-left"></i>
                La actuación y funcionamiento de nuestra organización está dimensionado y fundamentado en las descripciones de cargos
                <i class="fas fa-quote-right"></i>
            </div>
        </div>

        <!-- SEGUNDA PARTE: Grid de dos columnas -->
        <div class="staff-grid">
            
            <!-- Columna izquierda -->
            <div class="lista-cargos">
                <h3 class="lista-titulo">Oficinas Staff</h3>
                
                <!-- Oficina de Atención al Ciudadano -->
                <div class="cargo-item">
                    <i class="fas fa-headset"></i>
                    <div class="cargo-info">
                        <div class="cargo-nombre">Oficina de Atención al Ciudadano</div>
                        <div class="cargo-descripcion">Atención y servicio al público</div>
                    </div>
                </div>

                <!-- Oficina de Administración y Finanzas -->
                <div class="cargo-item">
                    <i class="fas fa-chart-pie"></i>
                    <div class="cargo-info">
                        <div class="cargo-nombre">Oficina de Administración y Finanzas</div>
                        <div class="cargo-descripcion">Gestión administrativa y financiera</div>
                    </div>
                </div>

                <!-- Oficina de Recursos Humanos -->
                <div class="cargo-item">
                    <i class="fas fa-users"></i>
                    <div class="cargo-info">
                        <div class="cargo-nombre">Oficina de Recursos Humanos</div>
                        <div class="cargo-descripcion">Gestión del talento humano</div>
                    </div>
                </div>

                <!-- Oficina de Información y Relaciones Institucionales -->
                <div class="cargo-item">
                    <i class="fas fa-bullhorn"></i>
                    <div class="cargo-info">
                        <div class="cargo-nombre">Oficina de Información y Relaciones Institucionales</div>
                        <div class="cargo-descripcion">Comunicación y relaciones externas</div>
                    </div>
                </div>

                <!-- Oficina de Asuntos Jurídicos -->
                <div class="cargo-item">
                    <i class="fas fa-gavel"></i>
                    <div class="cargo-info">
                        <div class="cargo-nombre">Oficina de Asuntos Jurídicos</div>
                        <div class="cargo-descripcion">Asesoría legal y jurídica</div>
                    </div>
                </div>
            </div>

            <!-- Columna derecha -->
            <div class="lista-cargos">
                <h3 class="lista-titulo">Oficinas Técnicas</h3>
                
                <!-- Oficina de Planificación, Presupuesto y Control de Gestión -->
                <div class="cargo-item">
                    <i class="fas fa-tasks"></i>
                    <div class="cargo-info">
                        <div class="cargo-nombre">Oficina de Planificación, Presupuesto y Control de Gestión</div>
                        <div class="cargo-descripcion">Planificación y control presupuestario</div>
                    </div>
                </div>

                <!-- Oficina de Cooperación Técnica y Proyecto -->
                <div class="cargo-item">
                    <i class="fas fa-handshake"></i>
                    <div class="cargo-info">
                        <div class="cargo-nombre">Oficina de Cooperación Técnica y Proyecto</div>
                        <div class="cargo-descripcion">Cooperación y desarrollo de proyectos</div>
                    </div>
                </div>

                <!-- Oficina de Tecnologías de Información y Comunicaciones -->
                <div class="cargo-item">
                    <i class="fas fa-laptop-code"></i>
                    <div class="cargo-info">
                        <div class="cargo-nombre">Oficina de Tecnologías de Información y Comunicaciones</div>
                        <div class="cargo-descripcion">Sistemas y tecnología</div>
                    </div>
                </div>

                <!-- Oficina de Gestión de Calidad -->
                <div class="cargo-item">
                    <i class="fas fa-certificate"></i>
                    <div class="cargo-info">
                        <div class="cargo-nombre">Oficina de Gestión de Calidad</div>
                        <div class="cargo-descripcion">Normas y estándares de calidad</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== FOOTER INCLUIDO ===== -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>

<!-- ===== SCRIPTS LOCALES ===== -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/background-animation.js"></script>

</body>
</html>