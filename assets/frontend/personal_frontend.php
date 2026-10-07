<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal - Intranet BPEZ</title>
    
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
        .personal-container {
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Tarjeta principal estilo vidrio blanco */
        .personal-card {
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

        .personal-card:hover {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        /* Tarjeta de aviso exclusivo - estilo especial */
        .aviso-exclusivo-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 15px;
            padding: 12px 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 6px solid var(--bpez-rojo-fuego);
            transition: all 0.3s ease;
            text-align: center;
        }

        .aviso-exclusivo-card:hover {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .aviso-exclusivo-texto {
            color: var(--bpez-rojo-fuego);
            font-weight: 700;
            font-size: clamp(0.85rem, 2vw, 1rem);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .aviso-exclusivo-texto i {
            font-size: 1.2rem;
            color: var(--bpez-rojo-fuego);
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

        /* Grid de 2 columnas para los primeros 4 botones */
        .buttons-grid-2-columns {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 0;
        }

        /* Botón de ancho completo para la fila inferior */
        .button-full-width {
            display: grid;
            grid-template-columns: 1fr;
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
            .personal-container {
                max-width: 1100px;
                gap: 25px;
            }
            .personal-card {
                padding: 20px;
            }
            .buttons-grid-2-columns, .button-full-width {
                gap: 20px;
            }
            .card-btn {
                padding: 20px 15px;
                min-height: 140px;
            }
        }

        @media (min-width: 992px) and (max-width: 1399px) {
            .personal-container {
                max-width: 900px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 30px 15px; 
            }
            .personal-card, .aviso-exclusivo-card { 
                padding: 15px; 
            }
            .buttons-grid-2-columns, .button-full-width {
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
            .personal-card { 
                padding: 15px; 
            }
            .section-title {
                font-size: 1.2rem;
            }
            .intro-text {
                font-size: 0.8rem;
                padding: 10px;
            }
            .buttons-grid-2-columns {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            .button-full-width {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .card-btn {
                padding: 15px 10px;
                min-height: 110px;
            }
            .aviso-exclusivo-texto {
                font-size: 0.8rem;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 575px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 12px 25px 12px; 
            }
            .personal-card, .aviso-exclusivo-card { 
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
            .buttons-grid-2-columns {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .button-full-width {
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
            .aviso-exclusivo-texto {
                font-size: 0.75rem;
                gap: 5px;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 400px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 10px) 10px 20px 10px; 
            }
            .personal-card { 
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
            .aviso-exclusivo-texto {
                font-size: 0.7rem;
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
    <div class="personal-container">
        
        <!-- PRIMERA CARD: Título y texto introductorio de image.png -->
        <div class="personal-card">
            <div class="text-center mb-2">
                <i class="fas fa-users" style="color: var(--bpez-azul-alegre); font-size: 2rem;"></i>
                <h2 class="section-title mt-1">PERSONAL</h2>
            </div>

            <!-- Texto de introducción de image.png -->
            <div class="intro-text">
                <i class="fas fa-quote-left"></i>La gestión del capital humano es vital para el éxito de la Biblioteca Publica del Zulia, porque transforma a los empleados en un activo estratégico, impulsando la productividad, innovación y competitividad. Permite atraer, desarrollar y retener talento clave, alineando los objetivos personales con los de nuestra institución.<i class="fas fa-quote-right"></i>
            </div>
        </div>

        <!-- TARJETA DE AVISO EXCLUSIVO (estilo card pequeña) -->
        <div class="aviso-exclusivo-card">
            <div class="aviso-exclusivo-texto">
                <i class="fas fa-exclamation-triangle"></i>
                ESTE SERVICIO ES DE USO EXCLUSIVO DE LA OFICINA DE GESTION HUMANA
                <i class="fas fa-exclamation-triangle"></i>
            </div>
        </div>

        <!-- SECCIÓN DE BOTONES con organización específica -->
        <div class="buttons-section">
            
            <!-- PRIMERA FILA: 2 columnas (Directorio y Expedientes) -->
            <div class="buttons-grid-2-columns">
                
                <!-- Columna Izquierda - Directorio -->
                <a href="/modules/personal/directorio.php" class="card-btn">
                    <i class="fas fa-address-book"></i>
                    <h3>Directorio</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Columna Derecha - Expedientes -->
                <a href="/modules/personal/expedientes.php" class="card-btn">
                    <i class="fas fa-folder-open"></i>
                    <h3>Expedientes</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>
            </div>

            <!-- SEGUNDA FILA: 2 columnas (Plan de Personal y Evaluaciones del Personal) -->
            <div class="buttons-grid-2-columns">
                
                <!-- Columna Izquierda - Plan de Personal -->
                <a href="/modules/personal/plan_personal.php" class="card-btn">
                    <i class="fas fa-clipboard-list"></i>
                    <h3>Plan de Personal</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Columna Derecha - Evaluaciones del personal -->
                <a href="/modules/personal/evaluaciones_personal.php" class="card-btn">
                    <i class="fas fa-star"></i>
                    <h3>Evaluaciones del personal</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>
            </div>

            <!-- TERCERA FILA: Ancho completo (Plan de Formación y Capacitación) -->
            <div class="button-full-width">
                <a href="/modules/personal/plan_formacion_capacitacion.php" class="card-btn">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <h3>Plan de Formación y Capacitación</h3>
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