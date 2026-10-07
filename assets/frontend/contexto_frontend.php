<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contexto - Intranet BPEZ</title>
    
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
        .context-container {
            max-width: 900px;  /* Reducido para que quepa en una pantalla */
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;  /* Reducido */
        }

        /* Tarjeta principal estilo vidrio blanco - MÁS REDUCIDA */
        .context-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;  /* Reducido */
            padding: 15px;  /* Reducido a 15px */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 6px solid var(--bpez-azul-alegre);  /* Reducido */
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
            margin-bottom: 5px;  /* Reducido */
            border-bottom: 2px solid var(--bpez-cian);
            display: inline-block;
            padding-bottom: 3px;  /* Reducido */
            font-size: clamp(1rem, 3vw, 1.4rem);  /* Reducido */
        }

        /* Texto principal de introducción - MÁS REDUCIDO */
        .intro-text {
            color: var(--bpez-dark-blue);
            font-size: clamp(0.90rem, 2vw, 1rem);  /* Reducido */
            line-height: 1.4;  /* Reducido */
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
            padding: 10px;  /* Reducido */
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 12px;  /* Reducido */
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .intro-text i {
            color: var(--bpez-rojo-fuego);
            margin: 0 5px;  /* Reducido */
            font-size: clamp(0.8rem, 1.6vw, 1rem);  /* Reducido */
        }

        /* Grid de 3 columnas para los botones */
        .buttons-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;  /* Reducido */
            margin-top: 0;
        }

        /* Tarjetas botón estilo vidrio - COLORES INVERTIDOS CORRECTAMENTE */
        .card-btn {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 15px;  /* Reducido */
            padding: 15px 10px;  /* Reducido */
            text-align: center;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 4px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;  /* Reducido */
            color: var(--bpez-dark-blue);
            height: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
        }

        .card-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-left-color: var(--bpez-rojo-fuego);  /* Borde rojo en hover */
        }

        .card-btn i {
            font-size: clamp(1.8rem, 4vw, 2.2rem);  /* Reducido */
            color: var(--bpez-azul-alegre);  /* AZUL por defecto */
            transition: all 0.3s ease;
        }

        .card-btn:hover i {
            transform: scale(1.1);
            color: var(--bpez-rojo-fuego);  /* ROJO en hover */
        }

        .card-btn h3 {
            font-weight: 700;
            font-size: clamp(0.8rem, 2vw, 1rem);  /* Reducido */
            margin: 0;
            color: var(--bpez-dark-blue);  /* Azul oscuro por defecto */
            transition: color 0.3s ease;
        }

        .card-btn:hover h3 {
            color: var(--bpez-rojo-fuego);  /* ROJO en hover */
        }

        /* Texto "Ver información" */
        .btn-info-text {
            color: var(--bpez-azul-alegre);  /* AZUL por defecto */
            font-size: clamp(0.7rem, 1.8vw, 0.85rem);  /* Reducido */
            margin-top: 2px;  /* Reducido */
            display: flex;
            align-items: center;
            gap: 4px;  /* Reducido */
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .btn-info-text i {
            font-size: clamp(0.7rem, 1.8vw, 0.85rem);  /* Reducido */
            color: var(--bpez-azul-alegre);  /* AZUL por defecto */
            transition: color 0.3s ease;
        }

        .card-btn:hover .btn-info-text {
            color: var(--bpez-rojo-fuego);  /* ROJO en hover */
        }

        .card-btn:hover .btn-info-text i {
            color: var(--bpez-rojo-fuego);  /* ROJO en hover */
        }

        footer {
            flex-shrink: 0;
        }

        /* ===== MEDIA QUERIES COMPLETAS ===== */

        /* Pantallas grandes / TV (1400px en adelante) */
        @media (min-width: 1400px) {
            .context-container {
                max-width: 1000px;
                gap: 25px;
            }
            .context-card {
                padding: 20px;
            }
            .buttons-grid {
                gap: 20px;
            }
            .card-btn {
                padding: 20px 15px;
            }
        }

        /* Desktop / Laptops (992px - 1399px) */
        @media (min-width: 992px) and (max-width: 1399px) {
            .context-container {
                max-width: 850px;
            }
        }

        /* Tablets horizontales / desktop pequeño (768px - 991px) */
        @media (min-width: 768px) and (max-width: 991px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 30px 15px; 
            }
            .context-card { 
                padding: 15px; 
            }
            .buttons-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 12px;
            }
            .card-btn {
                padding: 15px 10px;
            }
            .card-btn i {
                font-size: 1.8rem;
            }
        }

        /* Tablets verticales / móviles grandes (576px - 767px) */
        @media (min-width: 576px) and (max-width: 767px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 25px 15px; 
            }
            .context-card { 
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
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            .card-btn {
                padding: 15px 10px;
            }
        }

        /* Móviles (hasta 575px) */
        @media (max-width: 575px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 12px 25px 12px; 
            }
            .context-card { 
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
                gap: 10px;
            }
            .card-btn i {
                font-size: 1.6rem;
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

        /* Móviles pequeños (hasta 400px) */
        @media (max-width: 400px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 10px) 10px 20px 10px; 
            }
            .context-card { 
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

<!-- ===== CONTENIDO PRINCIPAL ===== -->
<div class="main-content">
    <div class="context-container">
        
        <!-- PRIMERA CARD: Título y texto introductorio - REDUCIDA A 15px -->
        <div class="context-card">
            <div class="text-center mb-2">  <!-- Reducido -->
                <i class="fas fa-globe-americas" style="color: var(--bpez-azul-alegre); font-size: 2rem;"></i>  <!-- Tamaño personalizado -->
                <h2 class="section-title mt-1">Contexto</h2>  <!-- Reducido -->
            </div>

            <!-- Texto de introducción -->
            <div class="intro-text">
                <i class="fas fa-quote-left"></i>
                Conocer y aplicar el marco legal y los lineamientos del contexto, garantiza el cumplimiento de la razón de ser institucional y resultados de una gestión alineada con las expectativas de la globalidad.
                <i class="fas fa-quote-right"></i>
            </div>
        </div>

        <!-- SEGUNDA PARTE: Grid de 3 botones (SEPARADOS) -->
        <div class="buttons-grid">
            
            <!-- Botón 1: Lineamientos Internacionales -->
            <a href="/modules/contexto/internacional.php" class="card-btn">
                <i class="fas fa-globe-americas"></i>
                <h3>Lineamientos Internacionales</h3>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Ver información
                </span>
            </a>

            <!-- Botón 2: Marco Legal Venezolano -->
            <a href="/modules/contexto/venezolano.php" class="card-btn">
                <i class="fas fa-gavel"></i>
                <h3>Marco Legal Venezolano</h3>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Ver información
                </span>
            </a>

            <!-- Botón 3: Lineamientos Nacionales Libro y Lectura -->
            <a href="/modules/contexto/lineamentos_nacionales_libro_lectura_bibliotecas.php" class="card-btn">
                <i class="fas fa-book-open"></i>
                <h3>Lineamientos Nacionales</h3>
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