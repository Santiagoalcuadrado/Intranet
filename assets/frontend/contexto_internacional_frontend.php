<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contexto Internacional - Intranet BPEZ</title>
    
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

        /* Tarjeta principal estilo vidrio blanco */
        .context-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 8px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
        }

        .context-card:hover {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            color: var(--bpez-dark-blue);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 25px;
            border-bottom: 2px solid var(--bpez-cian);
            display: inline-block;
            padding-bottom: 5px;
            font-size: clamp(1.3rem, 4vw, 2rem);
        }

        .subsection-title {
            color: var(--bpez-dark-blue);
            font-weight: 700;
            font-size: clamp(1.1rem, 3vw, 1.3rem);
            margin: 30px 0 15px 0;
            border-left: 4px solid var(--bpez-rojo-fuego);
            padding-left: 12px;
        }

        /* Tarjetas de contenido estilo cristal */
        .info-block {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 18px;
            padding: 25px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 4px solid var(--bpez-azul-alegre);
            height: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .info-block:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.05);
        }

        /* Iconos de las cards AHORA EN AZUL */
        .info-block i {
            color: var(--bpez-azul-alegre);  /* Cambiado de rojo a azul */
            font-size: clamp(1.8rem, 4vw, 2.2rem);
            margin-bottom: 15px;
        }

        .info-block h4 {
            color: var(--bpez-dark-blue);
            font-weight: 700;
            font-size: clamp(1rem, 2.5vw, 1.2rem);
            margin-bottom: 12px;
        }

        .info-block p {
            color: var(--bpez-dark-blue);
            font-weight: 500;
            font-size: clamp(0.85rem, 2vw, 0.95rem);
            line-height: 1.6;
            margin-bottom: 0;
            text-shadow: 0px 1px 2px rgba(255, 255, 255, 0.8);
        }

        .info-block .resumen {
            font-weight: 600;
            color: var(--bpez-dark-blue);
            margin-bottom: 8px;
            font-size: clamp(0.8rem, 1.8vw, 0.9rem);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.8;
        }

        /* Botones de descarga - Estilo actualizado */
        .btn-descarga {
            background: rgba(206, 32, 41, 0.1);  /* Fondo rojo más suave */
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: var(--bpez-dark-blue);  /* Texto azul oscuro */
            border: 1px solid rgba(206, 32, 41, 0.3);  /* Borde rojo suave */
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            font-size: clamp(0.8rem, 1.8vw, 0.9rem);
            transition: all 0.3s;
            display: inline-block;
            text-decoration: none;
            margin: 10px 10px 0 0;
        }

        .btn-descarga:hover {
            background: rgba(206, 32, 41, 0.2);  /* Fondo rojo ligeramente más intenso */
            color: var(--bpez-azul-alegre);  /* Texto azul alegre en hover */
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(206, 32, 41, 0.15);
            border-color: rgba(206, 32, 41, 0.5);
        }

        .btn-descarga i {
            color: var(--bpez-rojo-fuego);  /* Icono rojo por defecto */
            margin-right: 8px;
            font-size: clamp(0.8rem, 1.8vw, 1rem);
            transition: color 0.3s ease;
        }

        .btn-descarga:hover i {
            color: var(--bpez-azul-alegre);  /* Icono azul en hover */
        }

        .cita {
            font-style: italic;
            color: var(--bpez-dark-blue);
            opacity: 0.9;
            border-left: 3px solid var(--bpez-cian);
            padding-left: 20px;
            margin: 20px 0 5px 0;
            font-size: clamp(0.85rem, 2vw, 0.95rem);
        }

        /* Grid para separar cards */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin: 20px 0;
        }

        .cards-grid .info-block {
            margin-bottom: 0;
        }

        footer {
            flex-shrink: 0;
        }

        /* ===== MEDIA QUERIES COMPLETAS ===== */

        /* Pantallas grandes / TV (1400px en adelante) */
        @media (min-width: 1400px) {
            .main-content {
                padding: calc(var(--navbar-height) + 30px) 30px 50px 30px;
            }
            .context-card {
                max-width: 1300px;
                padding: 40px;
            }
            .info-block {
                padding: 30px;
            }
            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
            }
        }

        /* Desktop / Laptops (992px - 1399px) */
        @media (min-width: 992px) and (max-width: 1399px) {
            .context-card {
                max-width: 1100px;
            }
        }

        /* Tablets horizontales / desktop pequeño (768px - 991px) */
        @media (min-width: 768px) and (max-width: 991px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 30px 15px; 
            }
            .context-card { 
                padding: 25px; 
            }
            .section-title {
                font-size: 1.4rem;
            }
            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
        }

        /* Tablets verticales / móviles grandes (576px - 767px) */
        @media (min-width: 576px) and (max-width: 767px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 25px 15px; 
            }
            .context-card { 
                padding: 20px; 
            }
            .section-title {
                font-size: 1.3rem;
            }
            .cards-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            .btn-descarga {
                width: 100%;
                text-align: center;
                margin: 5px 0;
            }
        }

        /* Móviles (hasta 575px) */
        @media (max-width: 575px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 12px 20px 12px; 
            }
            .context-card { 
                padding: 15px; 
            }
            .section-title {
                font-size: 1.2rem;
                margin-bottom: 15px;
            }
            .subsection-title {
                font-size: 1rem;
                margin: 20px 0 10px 0;
            }
            .info-block {
                padding: 15px;
            }
            .info-block i {
                font-size: 1.8rem;
            }
            .btn-descarga {
                width: 100%;
                text-align: center;
                margin: 5px 0;
            }
            .btn-descarga:first-of-type {
                margin-top: 10px;
            }
        }

        /* Móviles pequeños (hasta 400px) */
        @media (max-width: 400px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 10px) 10px 15px 10px; 
            }
            .context-card { 
                padding: 12px; 
            }
            .section-title {
                font-size: 1.1rem;
            }
            .info-block {
                padding: 12px;
            }
            .info-block i {
                font-size: 1.6rem;
                margin-bottom: 10px;
            }
            .info-block h4 {
                font-size: 0.95rem;
            }
            .info-block p {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR INCLUIDO ===== -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

<!-- ===== CONTENIDO PRINCIPAL ===== -->
<div class="main-content">
    <div class="container">
        <div class="context-card">
            
            <!-- Título principal -->
            <div class="text-center mb-4">
                <i class="fas fa-globe-americas fa-3x" style="color: var(--bpez-azul-alegre);"></i>
                <h2 class="section-title mt-3">CONTEXTO: Lineamientos Internacionales</h2>
                <p class="lead" style="color: var(--bpez-dark-blue); opacity: 0.8;">Marco legal y normativo global y regional</p>
            </div>

            <!-- PARTE 1: IFLA / UNESCO -->
            <h3 class="subsection-title">1. IFLA / UNESCO (El Estándar Global)</h3>
            
            <div class="info-block">
                <i class="fas fa-landmark"></i>
                <h4>Manifiesto IFLA-UNESCO sobre la Biblioteca Pública (2022)</h4>
                <div class="resumen">Resumen:</div>
                <p>Es el documento más importante del sector. Define a la biblioteca como una fuerza viva para la educación, la cultura y la información. Su actualización de 2022 pone énfasis en la <strong>alfabetización mediática</strong>, el acceso digital y el desarrollo sostenible.</p>
            </div>

            <div class="info-block">
                <i class="fas fa-book"></i>
                <h4>Pautas IFLA/UNESCO para el desarrollo del servicio de bibliotecas públicas (2001 / Actualización 2022)</h4>
                <div class="resumen">Resumen:</div>
                <p>Ofrecen las "reglas del juego" técnicas: cuánto espacio debe tener una biblioteca por habitante, cuántos libros, qué servicios ofrecer y cómo debe ser el personal profesional.</p>
                
                <a href="#" class="btn-descarga">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>
            </div>

            <!-- PARTE 2: CERLALC -->
            <h3 class="subsection-title">2. CERLALC (El Enfoque Regional - Iberoamérica)</h3>
            
            <div class="info-block">
                <i class="fas fa-map"></i>
                <h4>Manifiesto de la Biblioteca Pública en América Latina y el Caribe (2000)</h4>
                <div class="resumen">Resumen:</div>
                <p>Fue una declaración pionera en <strong>Caracas</strong> que adaptó el manifiesto de la UNESCO a las necesidades de la región, enfatizando la biblioteca como un espacio de paz y reconstrucción social.</p>
                
                <a href="#" class="btn-descarga">
                    <i class="fas fa-file-pdf"></i> Descargar manifiesto
                </a>
            </div>

            <!-- Grid para Agenda 2030 -->
            <div class="cards-grid">
                <div class="info-block">
                    <i class="fas fa-calendar-check"></i>
                    <h4>Agenda 2030 y Bibliotecas</h4>
                    <div class="resumen">Libro, la lectura, la escritura y la oralidad:</div>
                    <p>Vincula el trabajo de la biblioteca pública con los <strong>Objetivos de Desarrollo Sostenible (ODS)</strong> de la ONU. Explica cómo la biblioteca combate la pobreza a través del acceso a la información.</p>
                    
                    <a href="#" class="btn-descarga">
                        <i class="fas fa-file-pdf"></i> Descargar documento
                    </a>
                </div>
            </div>

            <div class="mt-4"></div>
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