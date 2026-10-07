<?php
/**
 * aula_virtual_frontend.php
 * VISTA para el módulo de Aula Virtual
 * Ubicación: /assets/frontend/aula_virtual_frontend.php
 * Versión 100% OFFLINE - usa recursos locales
 */
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

        /* CONTENEDOR PRINCIPAL - MÁS ANCHO PARA APROVECHAR LA PANTALLA */
        .aula-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Tarjeta principal estilo vidrio blanco - IGUAL A LOS EJEMPLOS */
        .aula-card {
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

        .aula-card:hover {
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

        /* Texto principal de introducción - MÁS ANCHO PARA APROVECHAR LA PANTALLA */
        .intro-text {
            color: var(--bpez-dark-blue);
            font-size: clamp(0.90rem, 2vw, 1rem);
            line-height: 1.4;
            text-align: center;
            max-width: 1000px;
            margin: 0 auto;
            padding: 10px 15px;
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

        /* Grid de 3 columnas para los botones - MÁS ESPACIADO */
        .buttons-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 0;
        }

        /* Tarjetas botón estilo vidrio - MÁS HORIZONTALES Y COMPACTAS */
        .card-btn {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 15px 12px;
            text-align: center;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 4px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            color: var(--bpez-dark-blue);
            height: 100%;
            min-height: 130px;
            max-height: 140px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .card-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-left-color: var(--bpez-rojo-fuego);
        }

        .card-btn i {
            font-size: clamp(1.6rem, 3vw, 2rem);
            color: var(--bpez-azul-alegre);
            transition: all 0.3s ease;
        }

        .card-btn:hover i {
            transform: scale(1.1);
            color: var(--bpez-rojo-fuego);
        }

        .card-btn h3 {
            font-weight: 700;
            font-size: clamp(0.75rem, 1.6vw, 0.85rem);
            margin: 0;
            color: var(--bpez-dark-blue);
            transition: color 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            line-height: 1.2;
            max-width: 100%;
            word-break: break-word;
        }

        .card-btn:hover h3 {
            color: var(--bpez-rojo-fuego);
        }

        /* Texto "Ver información" - MÁS COMPACTO */
        .btn-info-text {
            color: var(--bpez-azul-alegre);
            font-size: clamp(0.6rem, 1.4vw, 0.75rem);
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .btn-info-text i {
            font-size: clamp(0.6rem, 1.4vw, 0.75rem);
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

        /* ===== MEDIA QUERIES OPTIMIZADAS ===== */
        @media (min-width: 1600px) {
            .aula-container {
                max-width: 1400px;
                gap: 25px;
            }
            .aula-card {
                padding: 20px;
            }
            .buttons-grid {
                gap: 25px;
            }
            .card-btn {
                padding: 18px 15px;
                min-height: 140px;
                max-height: 150px;
            }
            .card-btn h3 {
                font-size: 0.9rem;
            }
        }

        @media (min-width: 1400px) and (max-width: 1599px) {
            .aula-container {
                max-width: 1300px;
                gap: 22px;
            }
            .buttons-grid {
                gap: 22px;
            }
            .card-btn {
                padding: 16px 12px;
                min-height: 135px;
                max-height: 145px;
            }
        }

        @media (min-width: 1200px) and (max-width: 1399px) {
            .aula-container {
                max-width: 1150px;
            }
            .buttons-grid {
                gap: 20px;
            }
        }

        @media (min-width: 992px) and (max-width: 1199px) {
            .aula-container {
                max-width: 950px;
            }
            .buttons-grid {
                gap: 18px;
            }
            .card-btn {
                min-height: 130px;
                max-height: 140px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 30px 15px; 
            }
            .aula-card { 
                padding: 15px; 
            }
            .buttons-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
            }
            .card-btn {
                padding: 14px 8px;
                min-height: 125px;
                max-height: 135px;
            }
            .card-btn h3 {
                font-size: 0.7rem;
            }
        }

        @media (min-width: 576px) and (max-width: 767px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 25px 15px; 
            }
            .aula-card { 
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
                gap: 12px;
            }
            .card-btn {
                padding: 12px 6px;
                min-height: 120px;
                max-height: 130px;
            }
            .card-btn h3 {
                font-size: 0.65rem;
            }
            .btn-info-text {
                font-size: 0.55rem;
            }
        }

        @media (max-width: 575px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 12px 25px 12px; 
            }
            .aula-card { 
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
                min-height: auto;
                max-height: none;
            }
            .card-btn i {
                font-size: 2rem;
                margin-bottom: 0;
            }
            .card-btn h3 {
                font-size: 0.9rem;
                text-align: left;
            }
            .btn-info-text {
                margin-left: auto;
            }
        }

        @media (max-width: 400px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 10px) 10px 20px 10px; 
            }
            .aula-card { 
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
                min-height: auto;
                max-height: none;
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

<!-- ===== AVATAR CHATBOT FLOTANTE ===== -->
<!-- (Espacio para futura implementación) -->

<!-- ===== CONTENIDO PRINCIPAL ===== -->
<div class="main-content">
    <div class="aula-container">
        
        <!-- PRIMERA CARD: Título y texto introductorio ACTUALIZADO según image.png -->
        <div class="aula-card">
            <div class="text-center mb-2">
                <i class="fas fa-chalkboard-teacher" style="color: var(--bpez-azul-alegre); font-size: 2rem;"></i>
                <h2 class="section-title mt-1">AULA VIRTUAL</h2>
            </div>

            <!-- Texto de introducción actualizado de image.png -->
            <div class="intro-text">
                <i class="fas fa-quote-left"></i>
                La formación y capacitación continua por competencias es un enfoque educativo efectivo que fortalece las habilidades del personal para mejorar la productividad y la satisfacción laboral. Este modelo se centra en desarrollar capacidades prácticas, actitudinales y cognitivas alineadas con los roles reales del trabajo, promoviendo una mejora constante en el desempeño.
                <i class="fas fa-quote-right"></i>
            </div>
        </div>

        <!-- SEGUNDA PARTE: Grid de 3 botones en fila (izquierda, centro, derecha) -->
        <div class="buttons-grid">
            
            <!-- Botón 1: Programa de Cursos e Inscripción (Izquierda) -->
            <a href="/modules/aula_virtual/programa_cursos_inscripcion.php" class="card-btn">
                <i class="fas fa-calendar-alt"></i>
                <h3>PROGRAMA DE CURSOS<br>E INSCRIPCIÓN</h3>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Ver información
                </span>
            </a>

            <!-- Botón 2: Aula Virtual (Centro) - con enlace externo -->
            <a href="https://classroom.google.com/c/ODQ2NzcwNjk2Mzcw?cjc=y6mocir" 
               class="card-btn" 
               target="_blank" 
               rel="noopener noreferrer">
                <i class="fas fa-laptop"></i>
                <h3>AULA VIRTUAL</h3>
                <span class="btn-info-text">
                    <i class="fas fa-external-link-alt"></i> Ir al aula virtual
                </span>
            </a>

            <!-- Botón 3: Biblioteca de Formación y Capacitación (Derecha) -->
            <a href="/modules/aula_virtual/biblioteca_formacion_capacitacion.php" class="card-btn">
                <i class="fas fa-book-open"></i>
                <h3>BIBLIOTECA DE<br>FORMACIÓN Y CAPACITACIÓN</h3>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Ver información
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