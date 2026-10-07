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
        .institucion-container {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Tarjeta principal estilo vidrio blanco */
        .institucion-card {
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

        .institucion-card:hover {
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

        /* ===== MEDIA QUERIES COMPLETAS ===== */

        @media (min-width: 1400px) {
            .institucion-container {
                max-width: 1100px;
                gap: 25px;
            }
            .institucion-card {
                padding: 20px;
            }
            .buttons-grid {
                gap: 20px;
            }
            .card-btn {
                padding: 20px 15px;
            }
        }

        @media (min-width: 992px) and (max-width: 1399px) {
            .institucion-container {
                max-width: 900px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 30px 15px; 
            }
            .institucion-card { 
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
            .institucion-card { 
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

        @media (max-width: 575px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 12px 25px 12px; 
            }
            .institucion-card { 
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

        @media (max-width: 400px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 10px) 10px 20px 10px; 
            }
            .institucion-card { 
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
    <div class="institucion-container">
        
        <!-- PRIMERA CARD: Título y texto introductorio -->
        <div class="institucion-card">
            <div class="text-center mb-2">
                <i class="fas fa-university" style="color: var(--bpez-azul-alegre); font-size: 2rem;"></i>
                <h2 class="section-title mt-1">Institución</h2>
            </div>

            <!-- Texto de introducción -->
            <div class="intro-text">
                <i class="fas fa-quote-left"></i>
                La Biblioteca cuenta con la documentación que establece los lineamientos de funcionamiento general, soportados en su acta constitutiva y objetivos institucionales
                <i class="fas fa-quote-right"></i>
            </div>
        </div>

        <!-- SEGUNDA PARTE: Grid de 6 botones -->
        <div class="buttons-grid">
            
            <!-- Botón 1: Acta Constitutiva / Decreto de Creación -->
            <a href="/modules/institucion/acta_constitutiva.php" class="card-btn">
                <i class="fas fa-file-contract"></i>
                <h3>Acta Constitutiva</h3>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Ver información
                </span>
            </a>

            <!-- Botón 2: Reseña Histórica -->
            <a href="/modules/institucion/resena_historica.php" class="card-btn">
                <i class="fas fa-history"></i>
                <h3>Reseña Histórica</h3>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Ver información
                </span>
            </a>

            <!-- Botón 3: Manual Organizacional -->
            <a href="/modules/institucion/manual_organizacional.php" class="card-btn">
                <i class="fas fa-book"></i>
                <h3>Manual Organizacional</h3>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Ver información
                </span>
            </a>

            <!-- Botón 4: Organigrama -->
            <a href="/modules/institucion/organigrama.php" class="card-btn">
                <i class="fas fa-sitemap"></i>
                <h3>Organigrama</h3>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Ver información
                </span>
            </a>

            <!-- Botón 5: Misión, Visión, Valores -->
            <a href="/modules/institucion/mision_vision_valores.php" class="card-btn">
                <i class="fas fa-bullseye"></i>
                <h3>Misión, Visión, Valores</h3>
                <span class="btn-info-text">
                    <i class="fas fa-arrow-right"></i> Ver información
                </span>
            </a>

            <!-- Botón 6: Políticas, Normativas y Código de Ética -->
            <a href="/modules/institucion/politicas_normativas_etica.php" class="card-btn">
                <i class="fas fa-balance-scale"></i>
                <h3>Políticas, Normativas<br>y Código de Ética</h3>
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