<?php
/**
 * reportes_frontend.php
 * VISTA para el módulo de Reportes del Sistema
 * Ubicación: /assets/frontend/reportes_frontend.php
 */

// Las variables $titulo_pagina, $descripcion_pagina y $reportes_info vienen del backend
?>
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
        .reportes-container {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Tarjeta principal estilo vidrio blanco */
        .reportes-card {
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

        .reportes-card:hover {
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

        .descripcion-text {
            color: var(--bpez-dark-blue);
            font-size: clamp(0.85rem, 1.8vw, 0.95rem);
            line-height: 1.5;
            text-align: center;
            max-width: 800px;
            margin: 5px auto 0;
            opacity: 0.8;
        }

        /* Texto principal de introducción */
        .intro-text {
            color: var(--bpez-dark-blue);
            font-size: clamp(0.90rem, 2vw, 1rem);
            line-height: 1.4;
            text-align: center;
            max-width: 700px;
            margin: 10px auto 0;
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

        /* Grid de 3 columnas para los botones */
        .buttons-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 0;
        }

        /* Tarjetas botón estilo vidrio */
        .card-btn {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 20px 15px;
            text-align: center;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 4px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            color: var(--bpez-dark-blue);
            height: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .card-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-left-color: var(--bpez-rojo-fuego);
        }

        .card-btn i {
            font-size: clamp(2rem, 4vw, 2.5rem);
            color: var(--bpez-azul-alegre);
            transition: all 0.3s ease;
        }

        .card-btn:hover i {
            transform: scale(1.1);
            color: var(--bpez-rojo-fuego);
        }

        .card-btn h3 {
            font-weight: 700;
            font-size: clamp(0.9rem, 2.2vw, 1.1rem);
            margin: 0;
            color: var(--bpez-dark-blue);
            transition: color 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .card-btn:hover h3 {
            color: var(--bpez-rojo-fuego);
        }

        /* Texto descriptivo del botón */
        .btn-descripcion {
            font-size: clamp(0.7rem, 1.6vw, 0.8rem);
            color: var(--bpez-dark-blue);
            opacity: 0.7;
            margin: 5px 0;
            line-height: 1.3;
        }

        /* Texto "Generar reporte" */
        .btn-info-text {
            color: var(--bpez-azul-alegre);
            font-size: clamp(0.7rem, 1.8vw, 0.85rem);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .btn-info-text i {
            font-size: clamp(0.7rem, 1.8vw, 0.85rem);
            color: var(--bpez-azul-alegre);
            transition: color 0.3s ease;
        }

        .card-btn:hover .btn-info-text {
            color: var(--bpez-rojo-fuego);
        }

        .card-btn:hover .btn-info-text i {
            color: var(--bpez-rojo-fuego);
        }

        footer {
            flex-shrink: 0;
        }

        /* ===== MEDIA QUERIES COMPLETAS ===== */

        @media (min-width: 1400px) {
            .reportes-container {
                max-width: 1000px;
                gap: 25px;
            }
            .reportes-card {
                padding: 20px;
            }
            .buttons-grid {
                gap: 20px;
            }
            .card-btn {
                padding: 25px 20px;
            }
        }

        @media (min-width: 992px) and (max-width: 1399px) {
            .reportes-container {
                max-width: 850px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 30px 15px; 
            }
            .reportes-card { 
                padding: 15px; 
            }
            .buttons-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 12px;
            }
            .card-btn {
                padding: 15px 10px;
            }
        }

        @media (min-width: 576px) and (max-width: 767px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 25px 15px; 
            }
            .reportes-card { 
                padding: 15px; 
            }
            .section-title {
                font-size: 1.2rem;
            }
            .intro-text {
                font-size: 0.8rem;
                padding: 10px;
            }
            .buttons-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }
            .card-btn {
                padding: 15px 8px;
            }
            .card-btn h3 {
                font-size: 0.8rem;
            }
            .btn-descripcion {
                font-size: 0.65rem;
            }
        }

        @media (max-width: 575px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 12px 25px 12px; 
            }
            .reportes-card { 
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
            .buttons-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .card-btn {
                padding: 15px 12px;
                flex-direction: row;
                text-align: left;
                gap: 15px;
            }
            .card-btn i {
                font-size: 2rem;
                margin-bottom: 0;
            }
            .card-btn h3 {
                font-size: 0.9rem;
                text-align: left;
            }
            .btn-descripcion {
                display: none;
            }
            .btn-info-text {
                margin-left: auto;
            }
        }

        @media (max-width: 400px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 10px) 10px 20px 10px; 
            }
            .reportes-card { 
                padding: 10px; 
            }
            .intro-text {
                font-size: 0.7rem;
                padding: 6px;
            }
            .card-btn {
                padding: 10px 8px;
                flex-wrap: wrap;
                justify-content: center;
                text-align: center;
            }
            .card-btn i {
                font-size: 1.8rem;
            }
            .card-btn h3 {
                text-align: center;
                width: 100%;
                font-size: 0.85rem;
            }
            .btn-info-text {
                margin-left: 0;
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR INCLUIDO ===== -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

<!-- ===== CONTENIDO PRINCIPAL ===== -->
<div class="main-content">
    <div class="reportes-container">
        
        <!-- PRIMERA CARD: Título y texto introductorio -->
        <div class="reportes-card">
            <div class="text-center mb-2">
                <i class="fas fa-chart-bar" style="color: var(--bpez-azul-alegre); font-size: 2rem;"></i>
                <h2 class="section-title mt-1"><?php echo $titulo_pagina; ?></h2>
                <p class="descripcion-text"><?php echo $descripcion_pagina; ?></p>
            </div>

            <!-- Texto de introducción -->
            <div class="intro-text">
                <i class="fas fa-quote-left"></i>
                 Los reportes del sistema reportes funcionan como una herramienta estratégica que centraliza la información de todos los módulos para facilitar el análisis y la toma de decisiones. Su funcionalidad principal es permitir el monitoreo detallado de la actividad de los usuarios, la gestión documental y los procesos administrativos, garantizando la trazabilidad y transparencia institucional.
                <i class="fas fa-quote-right"></i>
            </div>
        </div>

        <!-- SEGUNDA PARTE: Grid de 3 botones -->
        <div class="buttons-grid">
            
            <!-- Botón 1: Reporte General -->
            <a href="/modules/admin/reporte_general.php" class="card-btn">
                <i class="fas fa-file-alt"></i>
                <h3>REPORTE GENERAL</h3>
                <div class="btn-descripcion">
                    <?php echo isset($reportes_info['general']['descripcion']) ? $reportes_info['general']['descripcion'] : 'Reporte consolidado de todas las actividades del sistema.'; ?>
                </div>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Generar reporte
                </span>
            </a>

            <!-- Botón 2: Reporte Detallado -->
            <a href="/modules/admin/reporte_detallado.php" class="card-btn">
                <i class="fas fa-list-ul"></i>
                <h3>REPORTE DETALLADO</h3>
                <div class="btn-descripcion">
                    <?php echo isset($reportes_info['detallado']['descripcion']) ? $reportes_info['detallado']['descripcion'] : 'Reporte con información pormenorizada de cada módulo.'; ?>
                </div>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Generar reporte
                </span>
            </a>

            <!-- Botón 3: Reporte Específico -->
            <a href="/modules/admin/reporte_especifico.php" class="card-btn">
                <i class="fas fa-filter"></i>
                <h3>REPORTE ESPECÍFICO</h3>
                <div class="btn-descripcion">
                    <?php echo isset($reportes_info['especifico']['descripcion']) ? $reportes_info['especifico']['descripcion'] : 'Reporte personalizable que permite seleccionar módulos específicos.'; ?>
                </div>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Generar reporte
                </span>
            </a>
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