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
            padding: calc(var(--navbar-height) + 18px) 20px 25px 20px;
        }

        /* CONTENEDOR PRINCIPAL */
        .biblioteca-container {
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 8px; /* Espaciado entre de contexto y las otras cards */
        }

        /* Tarjeta principal estilo vidrio blanco - REDUCIDA */
        .biblioteca-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 16px;
            padding: 5px 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 5px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
        }

        .section-title {
            color: var(--bpez-dark-blue);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.9px;
            margin-bottom: 2px;
            border-bottom: 2px solid var(--bpez-cian);
            display: inline-block;
            padding-bottom: 1px;
            font-size: clamp(1rem, 2.2vw, 1.3rem);
        }

        /* Texto principal de introducción - MÁS COMPACTO */
        .intro-text {
            color: var(--bpez-dark-blue);
            font-size: clamp(0.75rem, 1.6vw, 0.85rem);
            line-height: 1.2;
            text-align: center;
            max-width: 750px;
            margin: 3px auto 0;
            padding: 5px 12px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .intro-text i {
            color: var(--bpez-rojo-fuego);
            margin: 0 2px;
            font-size: clamp(0.65rem, 1.4vw, 0.75rem);
        }

        /* Grid de 2 columnas para los 4 botones */
        .buttons-grid-2x2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px; /* Espacio entre las cardsbuttons */
            margin-top: 0;
        }

        /* Tarjetas botón estilo vidrio - TODOS IGUALES */
        .card-btn {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 14px;
            padding: 14px 10px;
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
            min-height: 110px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .card-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
            border-left-color: var(--bpez-rojo-fuego);
        }

        .card-btn i {
            font-size: clamp(1.6rem, 2.8vw, 1.9rem);
            color: var(--bpez-azul-alegre);
            transition: all 0.3s ease;
        }

        .card-btn:hover i {
            transform: scale(1.1);
            color: var(--bpez-rojo-fuego);
        }

        .card-btn h3 {
            font-weight: 700;
            font-size: clamp(0.7rem, 1.7vw, 0.85rem);
            margin: 0;
            color: var(--bpez-dark-blue);
            transition: color 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }

        .card-btn:hover h3 {
            color: var(--bpez-rojo-fuego);
        }

        /* Texto "Ver información" - IGUAL PARA TODOS */
        .btn-info-text {
            color: var(--bpez-azul-alegre);
            font-size: clamp(0.6rem, 1.4vw, 0.75rem);
            margin-top: 3px;
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

        /* Texto pequeño dentro del botón (solo para Notibibliotecas) */
        .texto-pequeno { font-size: 0.6rem; color: var(--bpez-dark-blue); opacity: 0.8; line-height: 1.1; display: block; margin: 0; font-style: normal; text-transform: none; letter-spacing: 0.3px; font-weight: 400; max-width: 100%; white-space: normal; }

        footer {
            flex-shrink: 0;
            margin-top: 10px;
        }

        /* ===== MEDIA QUERIES ===== */

        @media (min-width: 1400px) {
            .biblioteca-container {
                max-width: 1000px;
            }
            .biblioteca-card {
                padding: 12px 16px;
            }
            .card-btn {
                min-height: 120px;
                padding: 16px 12px;
            }
        }

        @media (min-width: 576px) and (max-width: 767px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 12px) 15px 20px 15px; 
            }
            .buttons-grid-2x2 {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .card-btn {
                min-height: 90px;
            }
        }

        @media (max-width: 575px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 10px) 12px 15px 12px; 
            }
            .biblioteca-card {
                padding: 8px 12px;
            }
            .buttons-grid-2x2 {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .card-btn {
                flex-direction: row;
                text-align: left;
                gap: 12px;
                min-height: auto;
                padding: 12px;
            }
            .card-btn i {
                font-size: 1.6rem;
                margin-bottom: 0;
            }
            .card-btn h3 {
                font-size: 0.8rem;
                text-align: left;
            }
            .btn-info-text {
                margin-left: auto;
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR INCLUIDO ===== -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

<!-- ===== CHATBOT / AVATAR FLOTANTE ===== -->
<!-- (Espacio para futura implementación) -->

<!-- ===== CONTENIDO PRINCIPAL ===== -->
<div class="main-content">
    <div class="biblioteca-container">
        
        <!-- PRIMERA CARD: Título y texto introductorio - MÁS COMPACTA -->
        <div class="biblioteca-card">
            <div class="text-center">
                <i class="fas fa-book-open" style="color: var(--bpez-azul-alegre); font-size: 1.6rem;"></i>
                <h2 class="section-title">Actualización y Biblioteca Digital</h2>
            </div>

            <!-- Texto de introducción -->
            <div class="intro-text">
                <i class="fas fa-quote-left"></i>
                Espacio para la actualización en el mundo de las bibliotecas, la detección de oportunidades de participación en eventos internacionales y obtención de medios de financiamientos de nuestros proyectos.
                <i class="fas fa-quote-right"></i>
            </div>
        </div>

        <!-- SECCIÓN DE 4 BOTONES ORGANIZADOS EN 2x2 - TODOS DEL MISMO TAMAÑO -->
        <div class="buttons-grid-2x2">
            
            <!-- Botón 1 (Superior Izquierdo): Notibibliotecas -->
            <a href="/modules/actualizacion_biblioteca_digital/notibibliotecas.php" class="card-btn">
                <i class="fas fa-newspaper"></i>
                <h3>NOTIBIBLIOTECAS</h3>
                <span class="texto-pequeno">Noticias y Acontecer en Bibliotecas</span>   
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Ver información
                </span>
            </a>

            <!-- Botón 2 (Superior Derecho): Eventos internacionales -->
            <a href="/modules/actualizacion_biblioteca_digital/eventos_internacionales.php" class="card-btn">
                <i class="fas fa-globe-americas"></i>
                <h3>EVENTOS INTERNACIONALES</h3>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Ver información
                </span>
            </a>

            <!-- Botón 3 (Inferior Izquierdo): Conocer y Saber sobre Bibliotecas -->
            <a href="/modules/actualizacion_biblioteca_digital/conocer_saber_bibliotecas.php" class="card-btn">
                <i class="fas fa-graduation-cap"></i>
                <h3>CONOCER Y SABER SOBRE BIBLIOTECAS</h3>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Ver información
                </span>
            </a>

            <!-- Botón 4 (Inferior Derecho): Oportunidades de fuentes de financiamiento -->
            <a href="/modules/actualizacion_biblioteca_digital/fuentes_financiamiento.php" class="card-btn">
                <i class="fas fa-coins"></i>
                <h3>OPORTUNIDADES DE FUENTES DE FINANCIAMIENTO</h3>
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