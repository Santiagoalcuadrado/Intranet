<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de la Calidad - Intranet BPEZ</title>
    
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
        .sgc-container {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Tarjeta principal estilo vidrio blanco */
        .sgc-card {
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

        .sgc-card:hover {
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

        /* Texto principal de introducción (extraído de image.png) */
        .intro-text {
            color: var(--bpez-dark-blue);
            font-size: clamp(0.90rem, 2vw, 1rem);
            line-height: 1.5;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 500;
        }

        .intro-text i {
            color: var(--bpez-rojo-fuego);
            margin: 0 3px;
            font-size: clamp(0.8rem, 1.6vw, 1rem);
        }

        .intro-text i:first-child {
            margin-right: 5px;
        }

        .intro-text i:last-child {
            margin-left: 5px;
        }

        /* Grid de 2 columnas para los primeros 2 botones */
        .buttons-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 0;
        }

        /* Grid de 3 columnas para los últimos 3 botones */
        .buttons-grid-3 {
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
            padding: 15px 10px;
            text-align: center;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 4px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: var(--bpez-dark-blue);
            height: 100%;
            min-height: 130px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .card-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-left-color: var(--bpez-rojo-fuego);
        }

        .card-btn i {
            font-size: clamp(1.8rem, 4vw, 2.2rem);
            color: var(--bpez-azul-alegre);
            transition: all 0.3s ease;
        }

        .card-btn:hover i {
            transform: scale(1.1);
            color: var(--bpez-rojo-fuego);
        }

        .card-btn h3 {
            font-weight: 700;
            font-size: clamp(0.8rem, 2vw, 1rem);
            margin: 0;
            color: var(--bpez-dark-blue);
            transition: color 0.3s ease;
            line-height: 1.3;
        }

        .card-btn:hover h3 {
            color: var(--bpez-rojo-fuego);
        }

        /* Texto "Ver información" */
        .btn-info-text {
            color: var(--bpez-azul-alegre);
            font-size: clamp(0.7rem, 1.8vw, 0.85rem);
            margin-top: 2px;
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

        /* Separador entre grupos de botones */
        .buttons-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* ===== MEDIA QUERIES ===== */

        @media (min-width: 1400px) {
            .sgc-container {
                max-width: 1100px;
                gap: 25px;
            }
            .sgc-card {
                padding: 20px;
            }
            .buttons-grid-2, .buttons-grid-3 {
                gap: 20px;
            }
            .card-btn {
                padding: 20px 15px;
                min-height: 140px;
            }
        }

        @media (min-width: 992px) and (max-width: 1399px) {
            .sgc-container {
                max-width: 900px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 30px 15px; 
            }
            .sgc-card { 
                padding: 15px; 
            }
            .buttons-grid-2, .buttons-grid-3 {
                gap: 12px;
            }
            .card-btn {
                padding: 15px 10px;
                min-height: 120px;
            }
        }

        @media (min-width: 576px) and (max-width: 767px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 25px 15px; 
            }
            .sgc-card { 
                padding: 15px; 
            }
            .section-title {
                font-size: 1.2rem;
            }
            .intro-text {
                font-size: 0.8rem;
                padding: 10px;
            }
            .buttons-grid-2 {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            .buttons-grid-3 {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            .card-btn {
                padding: 15px 10px;
                min-height: 110px;
            }
        }

        @media (max-width: 575px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 12px 25px 12px; 
            }
            .sgc-card { 
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
            .buttons-grid-2, .buttons-grid-3 {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .card-btn {
                padding: 15px 12px;
                flex-direction: row;
                text-align: left;
                gap: 10px;
                min-height: auto;
            }
            .card-btn i {
                font-size: 1.6rem;
                margin-bottom: 0;
            }
            .card-btn h3 {
                font-size: 0.9rem;
                text-align: left;
                flex: 1;
            }
            .btn-info-text {
                margin-left: auto;
            }
        }

        @media (max-width: 400px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 10px) 10px 20px 10px; 
            }
            .sgc-card { 
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

<!-- ===== CHATBOT / AVATAR INCLUIDO ===== -->
<!-- (Espacio para futura implementación) -->

<!-- ===== CONTENIDO PRINCIPAL ===== -->
<div class="main-content">
    <div class="sgc-container">
        
        <!-- PRIMERA CARD: Título y texto introductorio de image.png -->
        <div class="sgc-card">
            <div class="text-center mb-2">
                <i class="fas fa-certificate" style="color: var(--bpez-azul-alegre); font-size: 2rem;"></i>
                <h2 class="section-title mt-1">Sistema de Gestión de la Calidad</h2>
            </div>

            <!-- Texto de introducción de image.png -->
            <div class="intro-text">
                <i class="fas fa-quote-left"></i>El SGC es una herramienta estratégica que facilita a la Biblioteca Publica del Zulia el optimizar sus procesos para asegurar que sus servicios cumplan con los requisitos de sus usuarios, partes interesadas y las normativas legales. Permite mejorar procesos, optimizar la satisfacción de los usuarios y potenciar la imagen institucional.<i class="fas fa-quote-right"></i>
            </div>
        </div>

        <!-- SECCIÓN DE BOTONES -->
        <div class="buttons-section">
            
            <!-- PRIMERA FILA: 2 botones (Norma ISO 9001 y Mapa de Procesos) -->
            <div class="buttons-grid-2">
                
                <!-- Botón 1: Norma ISO 9001 -->
                <a href="/modules/sgc/norma_iso_9001.php" class="card-btn">
                    <i class="fas fa-file-circle-check"></i>
                    <h3>Norma ISO 9001</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 2: Mapa de Procesos -->
                <a href="/modules/sgc/mapa_procesos.php" class="card-btn">
                    <i class="fas fa-diagram-project"></i>
                    <h3>Mapa de Procesos</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>
            </div>

            <!-- SEGUNDA FILA: 3 botones (Política y Principios, Manual de Calidad, Pasos para la Certificación) -->
            <div class="buttons-grid-3">
                
                <!-- Botón 3: Política y Principios de Calidad -->
                <a href="/modules/sgc/politica_principios_calidad.php" class="card-btn">
                    <i class="fas fa-bullseye"></i>
                    <h3>Política y Principios de Calidad</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 4: Manual de Calidad -->
                <a href="/modules/sgc/manual_calidad.php" class="card-btn">
                    <i class="fas fa-book"></i>
                    <h3>Manual de Calidad</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 5: Pasos para la Certificación -->
                <a href="/modules/sgc/pasos_certificacion.php" class="card-btn">
                    <i class="fas fa-road"></i>
                    <h3>Pasos para la Certificación</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>
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