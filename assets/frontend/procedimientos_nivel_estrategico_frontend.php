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
        .procedimientos-container {
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Tarjeta principal estilo vidrio blanco */
        .procedimientos-card {
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

        .procedimientos-card:hover {
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

        /* Tarjeta de lista de procedimientos */
        .lista-procedimientos {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 6px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
        }

        .lista-procedimientos:hover {
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
        .procedimiento-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border-left: 3px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
        }

        .procedimiento-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
            border-left-color: var(--bpez-rojo-fuego);
        }

        .procedimiento-item i {
            color: var(--bpez-azul-alegre);
            font-size: 1.5rem;
            margin-right: 15px;
            width: 30px;
            text-align: center;
            transition: color 0.3s ease;
        }

        .procedimiento-item:hover i {
            color: var(--bpez-rojo-fuego);
        }

        .procedimiento-info {
            flex: 1;
        }

        .procedimiento-nombre {
            font-weight: 600;
            color: var(--bpez-dark-blue);
            font-size: 1rem;
            margin-bottom: 3px;
        }

        .procedimiento-descripcion {
            font-size: 0.8rem;
            color: var(--bpez-dark-blue);
            opacity: 0.7;
        }

        .procedimiento-badge {
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
            .procedimientos-container {
                max-width: 1000px;
                gap: 25px;
            }
            .procedimientos-card {
                padding: 20px;
            }
            .lista-procedimientos {
                padding: 30px;
            }
        }

        @media (min-width: 992px) and (max-width: 1399px) {
            .procedimientos-container {
                max-width: 850px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 30px 15px; 
            }
            .procedimientos-card { 
                padding: 15px; 
            }
            .lista-procedimientos {
                padding: 20px;
            }
        }

        @media (min-width: 576px) and (max-width: 767px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 25px 15px; 
            }
            .procedimientos-card { 
                padding: 15px; 
            }
            .section-title {
                font-size: 1.2rem;
            }
            .intro-text {
                font-size: 0.8rem;
                padding: 10px;
            }
            .lista-procedimientos {
                padding: 20px;
            }
            .procedimiento-item {
                padding: 10px;
            }
        }

        @media (max-width: 575px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 12px 25px 12px; 
            }
            .procedimientos-card { 
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
            .lista-procedimientos {
                padding: 15px;
            }
            .procedimiento-item {
                padding: 10px;
                flex-wrap: wrap;
            }
            .procedimiento-item i {
                font-size: 1.2rem;
                margin-right: 10px;
            }
            .procedimiento-nombre {
                font-size: 0.9rem;
            }
            .procedimiento-descripcion {
                font-size: 0.7rem;
            }
            .procedimiento-badge {
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
            .procedimientos-card { 
                padding: 10px; 
            }
            .intro-text {
                font-size: 0.7rem;
                padding: 6px;
            }
            .lista-procedimientos {
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
    <div class="procedimientos-container">
        
        <!-- PRIMERA CARD: Título y texto introductorio -->
        <div class="procedimientos-card">
            <div class="text-center mb-2">
                <i class="fas fa-crown" style="color: var(--bpez-azul-alegre); font-size: 2rem;"></i>
                <h2 class="section-title mt-1">Procedimientos - Nivel Estratégico</h2>
            </div>

            <!-- Texto de introducción -->
            <div class="intro-text">
                <i class="fas fa-quote-left"></i>
                La actuación y funcionamiento de nuestra organización está dimensionado y fundamentado en las descripciones de procedimientos
                <i class="fas fa-quote-right"></i>
            </div>
        </div>

        <!-- SEGUNDA CARD: Lista de procedimientos -->
        <div class="lista-procedimientos">
            <h3 class="lista-titulo">Procedimientos del Nivel Estratégico</h3>
            
            <!-- Junta Directiva -->
            <div class="procedimiento-item">
                <i class="fas fa-users"></i>
                <div class="procedimiento-info">
                    <div class="procedimiento-nombre">Junta Directiva</div>
                    <div class="procedimiento-descripcion">Máximo órgano de dirección y toma de decisiones</div>
                </div>
                <span class="procedimiento-badge">3 miembros</span>
            </div>

            <!-- Unidad de Auditoría Interna -->
            <div class="procedimiento-item">
                <i class="fas fa-clipboard-check"></i>
                <div class="procedimiento-info">
                    <div class="procedimiento-nombre">Unidad de Auditoría Interna (1)</div>
                    <div class="procedimiento-descripcion">Control y fiscalización de procesos internos</div>
                </div>
                <span class="procedimiento-badge">1 cargo</span>
            </div>

            <!-- Presidencia -->
            <div class="procedimiento-item">
                <i class="fas fa-user-tie"></i>
                <div class="procedimiento-info">
                    <div class="procedimiento-nombre">Presidencia</div>
                    <div class="procedimiento-descripcion">Máxima autoridad ejecutiva de la institución</div>
                </div>
                <span class="procedimiento-badge">1 cargo</span>
            </div>

            <!-- Vicepresidencia -->
            <div class="procedimiento-item">
                <i class="fas fa-user-tie"></i>
                <div class="procedimiento-info">
                    <div class="procedimiento-nombre">Vicepresidencia</div>
                    <div class="procedimiento-descripcion">Segunda autoridad ejecutiva</div>
                </div>
                <span class="procedimiento-badge">1 cargo</span>
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