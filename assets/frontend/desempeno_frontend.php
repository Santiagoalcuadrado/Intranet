<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desempeño - Intranet BPEZ</title>
    
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
        .desempeno-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Tarjeta principal estilo vidrio blanco */
        .desempeno-card {
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

        .desempeno-card:hover {
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
            max-width: 1000px;
            margin: 0 auto;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 500;
        }

        .intro-text i {
            color: var(--bpez-rojo-fuego);
            margin: 0 2px;
            font-size: clamp(0.8rem, 1.6vw, 1rem);
        }

        .intro-text i:first-child {
            margin-right: 4px;
        }

        .intro-text i:last-child {
            margin-left: 4px;
        }

        /* Grid de 3 columnas para los botones - organización vertical */
        .buttons-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 0;
        }

        /* Estilo para cada columna */
        .columna {
            display: flex;
            flex-direction: column;
            gap: 15px;
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
            min-height: 120px;
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
            max-width: 100%;
            word-break: break-word;
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

        /* ===== MEDIA QUERIES ===== */

        @media (min-width: 1400px) {
            .desempeno-container {
                max-width: 1300px;
                gap: 25px;
            }
            .desempeno-card {
                padding: 20px;
            }
            .buttons-grid {
                gap: 20px;
            }
            .columna {
                gap: 20px;
            }
            .card-btn {
                padding: 20px 15px;
                min-height: 140px;
            }
        }

        @media (min-width: 992px) and (max-width: 1399px) {
            .desempeno-container {
                max-width: 1100px;
            }
        }

        @media (min-width: 768px) and (max-width: 991px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 30px 15px; 
            }
            .desempeno-card { 
                padding: 15px; 
            }
            .buttons-grid {
                gap: 12px;
            }
            .columna {
                gap: 12px;
            }
            .card-btn {
                padding: 15px 8px;
                min-height: 120px;
            }
        }

        @media (min-width: 576px) and (max-width: 767px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 15px 25px 15px; 
            }
            .desempeno-card { 
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
                grid-template-columns: 1fr;
                gap: 15px;
            }
            .columna {
                gap: 12px;
            }
        }

        @media (max-width: 575px) {
            .main-content { 
                padding: calc(var(--navbar-height) + 15px) 12px 25px 12px; 
            }
            .desempeno-card { 
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
            .columna {
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
            .desempeno-card { 
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
    <div class="desempeno-container">
        
        <!-- PRIMERA CARD: Título y texto introductorio -->
        <div class="desempeno-card">
            <div class="text-center mb-2">
                <i class="fas fa-chart-bar" style="color: var(--bpez-azul-alegre); font-size: 2rem;"></i>
                <h2 class="section-title mt-1">Desempeño</h2>
            </div>

            <!-- Texto de introducción con comillas pegadas -->
            <div class="intro-text">
                <i class="fas fa-quote-left"></i>Reportar el desempeño de las actividades realizadas es el mecanismo de trazabilidad del cumplimiento de los planes de la institución vinculantes con la razón de ser y sus objetivos institucionales<i class="fas fa-quote-right"></i>
            </div>
        </div>

        <!-- Grid de 3 columnas verticales -->
        <div class="buttons-grid">
            
            <!-- COLUMNA IZQUIERDA (4 botones) -->
            <div class="columna">
                <!-- Botón 1: Presidencia y Vicepresidencia -->
                <a href="/modules/desempeno/presidencia_vicepresidencia.php" class="card-btn">
                    <i class="fas fa-landmark"></i>
                    <h3>Presidencia y Vicepresidencia</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 2: OFIC. Admón. y Finanzas -->
                <a href="/modules/desempeno/oficina_administracion_finanzas.php" class="card-btn">
                    <i class="fas fa-calculator"></i>
                    <h3>OFIC. Admón. y Finanzas</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 3: Cord. de Bienes Públicos -->
                <a href="/modules/desempeno/cord_bienes_publicos.php" class="card-btn">
                    <i class="fas fa-building"></i>
                    <h3>Cord. de Bienes Públicos</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 4: Cord. de Servicios Generales -->
                <a href="/modules/desempeno/cord_servicios_generales.php" class="card-btn">
                    <i class="fas fa-tools"></i>
                    <h3>Cord. de Servicios Generales</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>
            </div>

            <!-- COLUMNA CENTRO (4 botones) -->
            <div class="columna">
                <!-- Botón 5: GCIA. Serv. Bibliotecológicos -->
                <a href="/modules/desempeno/gerencia_servicios_bibliotecologicos.php" class="card-btn">
                    <i class="fas fa-book-open"></i>
                    <h3>GCIA. Serv. Bibliotecológicos</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 6: GCIA. Social -->
                <a href="/modules/desempeno/gerencia_social.php" class="card-btn">
                    <i class="fas fa-hand-holding-heart"></i>
                    <h3>GCIA. Social</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 7: Ofic. Atención al Ciudadano -->
                <a href="/modules/desempeno/oficina_atencion_ciudadano.php" class="card-btn">
                    <i class="fas fa-users"></i>
                    <h3>Ofic. Atención al Ciudadano</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 8: Ofic. Plan. Prsto. de Gestión -->
                <a href="/modules/desempeno/oficina_planificacion_presupuesto_gestion.php" class="card-btn">
                    <i class="fas fa-chart-pie"></i>
                    <h3>Ofic. Plan. Prsto. de Gestión</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>
            </div>

            <!-- COLUMNA DERECHA (5 botones) -->
            <div class="columna">
                <!-- Botón 9: Unidad de Auditoria Interna -->
                <a href="/modules/desempeno/unidad_auditoria_interna.php" class="card-btn">
                    <i class="fas fa-clipboard-check"></i>
                    <h3>Unidad de Auditoria Interna</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 10: Ofic. Gestión de Calidad -->
                <a href="/modules/desempeno/oficina_gestion_calidad.php" class="card-btn">
                    <i class="fas fa-medal"></i>
                    <h3>Ofic. Gestión de Calidad</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 11: Ofic. Gestión Humana -->
                <a href="/modules/desempeno/oficina_gestion_humana.php" class="card-btn">
                    <i class="fas fa-user-tie"></i>
                    <h3>Ofic. Gestión Humana</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 12: Ofic. Asuntos Jurídicos -->
                <a href="/modules/desempeno/oficina_asuntos_juridicos.php" class="card-btn">
                    <i class="fas fa-gavel"></i>
                    <h3>Ofic. Asuntos Jurídicos</h3>
                    <span class="btn-info-text">
                        <i class="fas fa-arrow-right"></i> Ver información
                    </span>
                </a>

                <!-- Botón 13: Ofic. Inform. y Relac. Institucionales -->
                <a href="/modules/desempeno/oficina_informacion_relaciones_institucionales.php" class="card-btn">
                    <i class="fas fa-globe"></i>
                    <h3>Ofic. Inform. y Relac. Institucionales</h3>
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