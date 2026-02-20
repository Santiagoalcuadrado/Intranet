<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organización - Intranet BPEZ 2026</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo-fuego: #CE2029;
            --bpez-dark-blue: #003366; 
            --bpez-azul-alegre: #0077B6;
            --header-bg-integrado: #e0f2f1;
        }

        html, body { height: 100%; scroll-behavior: smooth; }
        body { 
            display: flex; flex-direction: column; 
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            font-family: 'Montserrat', sans-serif; color: #333; padding-top: 90px;
        }

        .main-content { flex: 1 0 auto; }

        /* --- IA ASSISTANT --- */
        .ai-assistant-card {
            background: white; border-radius: 20px; padding: 20px 30px;
            border: 2px solid var(--bpez-cian); margin-top: 20px;
            box-shadow: 0 8px 25px rgba(0, 51, 102, 0.08);
        }
        .ai-bubble {
            background: var(--header-bg-integrado); border-radius: 12px; padding: 12px 18px;
            font-size: 0.85rem; border-left: 5px solid var(--bpez-rojo-fuego);
        }

        /* --- SECCIONES --- */
        .info-section {
            background: white; border-radius: 25px; padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1); margin: 25px auto;
            border-top: 6px solid var(--bpez-azul-alegre);
        }

        /* --- LÍNEA DE TIEMPO HISTÓRICA --- */
        .timeline-container { position: relative; padding: 20px 0; }
        .timeline-item {
            padding-left: 40px; border-left: 3px solid var(--bpez-cian);
            position: relative; margin-bottom: 30px;
        }
        .timeline-item::before {
            content: ''; position: absolute; left: -11px; top: 0;
            width: 20px; height: 20px; background: var(--bpez-rojo-fuego); border-radius: 50%;
            border: 3px solid white; box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        /* --- CARDS DE ÁREAS (TÍTULO ESTILIZADO SIN TAPAR) --- */
        .area-card {
            opacity: 0; 
            transform: translateY(40px); 
            transition: all 0.7s ease-out;
            background: white; 
            border-radius: 30px; /* Un poco más redondeado para suavizar */
            overflow: visible; /* IMPORTANTE: para que el título pueda sobresalir si queremos */
            margin-bottom: 60px; 
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            border: none;
            display: flex;
            flex-direction: column;
        }

        .area-card.reveal { opacity: 1; transform: translateY(0); }

        /* Contenedor del título con estilo de etiqueta */
        .area-header-top {
            padding: 20px 30px 0 30px;
            margin-bottom: -10px; /* Acerca la imagen al título */
            z-index: 10;
        }

        .area-header-top h4 {
            background: linear-gradient(135deg, var(--bpez-dark-blue) 0%, #004080 100%);
            color: white;
            padding: 14px 28px;
            border-radius: 15px;
            font-weight: 800;
            text-transform: uppercase;
            margin: 0;
            display: inline-block;
            font-size: 1.15rem;
            letter-spacing: 1px;
            /* Sombra para dar profundidad */
            box-shadow: 0 8px 20px rgba(0, 51, 102, 0.25);
            border-bottom: 3px solid var(--bpez-cian); /* Un detalle de color abajo */
        }

        .area-img-container {
            width: 100%;
            height: 450px; 
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #fdfdfd; 
            padding: 20px; 
            border-radius: 30px;
        }

        .area-img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; 
            transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .area-card:hover .area-img {
            transform: scale(1.05); /* Zoom un poco más dinámico */
        }

        .area-info {
            padding: 20px 40px 40px;
            background: white;
            border-radius: 0 0 30px 30px;
        }
        
        /* --- LEGAL LIST --- */
        .legal-list { font-size: 0.85rem; columns: 2; column-gap: 30px; }
        .legal-list li { margin-bottom: 10px; list-style: none; position: relative; padding-left: 20px; }
        .legal-list li::before { content: '✓'; position: absolute; left: 0; color: var(--bpez-rojo-fuego); font-weight: bold; }

        .btn-bpez { background-color: var(--bpez-dark-blue); color: white; border-radius: 50px; padding: 10px 25px; font-weight: 600; border: none; transition: 0.3s; }
        .btn-bpez:hover { background-color: var(--bpez-azul-alegre); color: white; transform: scale(1.05); }
        
        .section-divider { width: 80px; height: 4px; background: var(--bpez-rojo-fuego); margin: 15px auto 30px; }
        .badge-info { background: var(--bpez-cian); color: white; padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; text-transform: uppercase; margin-bottom: 10px; display: inline-block; }

        /* MODIFICACIÓN ZOOM */
        .img-zoomable { cursor: zoom-in; transition: transform 0.3s ease; }
        .img-zoomable.zoomed { transform: scale(1.8); cursor: zoom-out; }
        .modal-body { overflow: auto; } /* Para que aparezca scroll si la imagen crece mucho */
    </style>
</head>
<body>

    <?php include '../../includes/navbar.php'; ?>

    <div class="main-content">
        <div class="container">
            
            <div class="ai-assistant-card shadow-sm mb-5">
                <div class="d-flex align-items-center gap-2 mb-2 text-primary fw-800">
                    <i class="fas fa-robot"></i> <span>BPEZ-IA: CRONISTA INSTITUCIONAL</span>
                </div>
                <div class="ai-bubble">
                    Nuestra historia nace en 1873 como la "Biblioteca Zuliana". Hoy, bajo la gestión del **Ing. Luis Caldera**, reafirmamos nuestro compromiso como la **Puerta al Conocimiento Universal**. Explora nuestra trayectoria institucional a continuación.
                </div>
            </div>

            <div class="info-section">
                <h3 class="fw-800 text-center text-uppercase"><i class="fas fa-landmark me-2"></i> Crónica e Historia</h3>
                <div class="section-divider"></div>
                <div class="timeline-container">
                    <div class="timeline-item">
                        <h5 class="fw-bold text-primary">15 de Julio, 1873 - Origen</h5>
                        <p class="small">Se decreta la creación de la "Biblioteca Zuliana". Su acervo inicial se caracterizó por la adquisición de periódicos, manuscritos e instrumentos científicos traídos de Europa.</p>
                    </div>
                    <div class="timeline-item">
                        <h5 class="fw-bold text-primary">1874 - 1876 - Rescate y Reorganización</h5>
                        <p class="small">Tras incidentes que afectaron la colección original, diversas organizaciones civiles rescataron y reorganizaron la institución para retomar servicios en 1876.</p>
                    </div>
                    <div class="timeline-item">
                        <h5 class="fw-bold text-primary">31 de Octubre, 1995 - Consolidación del Nombre</h5>
                        <p class="small">Se produce la reapertura bajo el nombre de "María Calcaño", rindiendo homenaje a la destacada poetisa zuliana.</p>
                    </div>
                    <div class="timeline-item" style="border:none">
                        <h5 class="fw-bold text-success">Febrero, 2026 - Gestión Actual</h5>
                        <p class="small">Bajo la dirección del Ejecutivo Regional, la Biblioteca Pública del Zulia se mantiene como el principal Albergue de la Memoria y centro de vanguardia tecnológica del estado.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-6">
                    <div class="info-section h-100 shadow-sm border-0" style="border-left: 6px solid var(--bpez-cian) !important;">
                        <h5 class="fw-800"><i class="fas fa-bullseye me-2"></i> Misión</h5>
                        <p class="small">Somos la organización regional que desarrolla servicios bibliotecológicos de excelencia para el crecimiento integral del ciudadano, mediante tecnología de vanguardia y resguardo de la producción intelectual zuliana.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-section h-100 shadow-sm border-0" style="border-left: 6px solid var(--bpez-rojo-fuego) !important;">
                        <h5 class="fw-800"><i class="fas fa-eye me-2"></i> Visión</h5>
                        <p class="small">Ser el modelo de gestión sociocultural referente en servicios de información y formación, garantizando el acceso ilimitado al conocimiento para una sociedad libre.</p>
                    </div>
                </div>
            </div>

            <div class="info-section">
                <h4 class="fw-800 mb-4"><i class="fas fa-gavel me-2"></i> Fundamentos Legales</h4>
                <div class="legal-list">
                    <li>Ley Orgánica de la Administración Pública</li>
                    <li>Ley del Instituto Autónomo Biblioteca Nacional</li>
                    <li>Ley de la Administración Pública del Estado Zulia</li>
                    <li>Ley Orgánica de Procedimientos Administrativos</li>
                    <li>Ley Orgánica del Trabajo (LOTTT)</li>
                    <li>Ley del Estatuto de la Función Pública</li>
                    <li>Reglamento de la BPEZ (Decreto N° 20 "A")</li>
                    <li>Decretos de Creación y Reforma de la Fundación</li>
                </div>
            </div>

            <div class="row text-center mb-5 g-4">
                <div class="col-md-6">
                    <div class="p-4 bg-white rounded-4 shadow-sm">
                        <i class="fas fa-sitemap fa-3x mb-3 text-primary"></i>
                        <h5>Estructura Organizativa</h5>
                        <p class="small text-muted">Visualiza la jerarquía y departamentos de la BPEZ.</p>
                        <button class="btn btn-bpez" data-bs-toggle="modal" data-bs-target="#modalOrganigrama">Ver Organigrama</button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 bg-white rounded-4 shadow-sm">
                        <i class="fas fa-users-cog fa-3x mb-3 text-success"></i>
                        <h5>Gerencia Social</h5>
                        <p class="small text-muted">Relaciones internas, externas y vinculación departamental.</p>
                        <button class="btn btn-bpez" data-bs-toggle="modal" data-bs-target="#modalGerencia">Ver Relaciones de Unidad</button>
                    </div>
                </div>
            </div>

            <div class="text-center mb-5">
                <h2 class="fw-800 text-uppercase">Recorrido por nuestras Salas</h2>
                <div class="section-divider"></div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-11 area-card">
                    <div class="area-header-top">
                        <h4><i class="fas fa-user-tie me-2"></i>Atención al Ciudadano</h4>
                    </div>
                    <div class="area-img-container">
                        <img src="../img/salas/atencion_cliente.png" class="area-img" alt="Atención">
                    </div>
                    <div class="area-info">
                        <span class="badge-info">Acceso Libre (8am - 4pm)</span>
                        <p class="text-muted">Puerta de entrada donde se guía a los visitantes sobre la ubicación de las zonas y servicios institucionales.</p>
                    </div>
                </div>

                <div class="col-md-11 area-card">
                    <div class="area-header-top">
                        <h4><i class="fas fa-microchip me-2"></i>Sala Digital "Humberto Fernández Morán"</h4>
                    </div>
                    <div class="area-img-container">
                        <img src="../img/salas/sala_digital.png" class="area-img" alt="Sala Digital">
                    </div>
                    <div class="area-info">
                        <span class="badge-info">Tecnología Inteligente</span>
                        <p class="text-muted">Único espacio destinado al soporte tecnológico, dividido en Zona Interactiva, Tecnoverso y Zona Portátil con WiFi gratuito.</p>
                    </div>
                </div>

                <div class="col-md-11 area-card">
                    <div class="area-header-top">
                        <h4><i class="fas fa-child me-2"></i>Sala Infantil "Amenodoro Urdaneta"</h4>
                    </div>
                    <div class="area-img-container">
                        <img src="../img/salas/sala_infantil.png" class="area-img" alt="Sala Infantil">
                    </div>
                    <div class="area-info">
                        <span class="badge-info">Educación Temprana</span>
                        <p class="text-muted">Espacio interactivo para niños de 5 a 14 años, diseñado para estimular la lectura y la investigación escolar.</p>
                    </div>
                </div>

                <div class="col-md-11 area-card">
                    <div class="area-header-top">
                        <h4><i class="fas fa-braille me-2"></i>Sala Braille "Miguel Ángel Jusayú"</h4>
                    </div>
                    <div class="area-img-container">
                        <img src="../img/salas/sala_braille.png" class="area-img" alt="Sala Braille">
                    </div>
                    <div class="area-info">
                        <span class="badge-info">Inclusión Total</span>
                        <p class="text-muted">Centro de capacitación para personas con discapacidad visual, permitiendo la integración real a través de la educación braille.</p>
                    </div>
                </div>

                <div class="col-md-11 area-card">
                    <div class="area-header-top">
                        <h4><i class="fas fa-newspaper me-2"></i>Sala Hemeroteca "Eduardo López Rivas"</h4>
                    </div>
                    <div class="area-img-container">
                        <img src="../img/salas/sala_hemeroteca.png" class="area-img" alt="Hemeroteca">
                    </div>
                    <div class="area-info">
                        <span class="badge-info">Investigación de Prensa</span>
                        <p class="text-muted">Consulta de periódicos y revistas que resguardan el acontecer histórico de la región zuliana.</p>
                    </div>
                </div>

                <div class="col-md-11 area-card">
                    <div class="area-header-top">
                        <h4><i class="fas fa-book-reader me-2"></i>Sala General de Lectura "María Calcaño"</h4>
                    </div>
                    <div class="area-img-container">
                        <img src="../img/salas/sala_general.png" class="area-img" alt="Sala General">
                    </div>
                    <div class="area-info">
                        <span class="badge-info">+20,000 Títulos</span>
                        <p class="text-muted">El corazón de la institución, con amplias colecciones bibliográficas, área expositiva y un sector dedicado al Lago de Maracaibo.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalOrganigrama" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold">ORGANIGRAMA ESTRUCTURAL BPEZ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center bg-light">
                    <img src="../img/organigrama_estructural_definitivo.png" class="img-fluid rounded shadow-sm mb-3 img-zoomable" alt="Organigrama" onclick="toggleZoom(this)">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <span class="text-muted small">Fecha de subida: 18/02/2026</span>
                        <a href="../img/organigrama_estructural_definitivo.png" download class="btn btn-primary"><i class="fas fa-download me-2"></i>Descargar Imagen</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalGerencia" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 rounded-4">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">RELACIONES INTERNAS Y EXTERNAS - GERENCIA SOCIAL</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center bg-light">
                    <img src="../img/relaciones_internas_externas_departamentos.png" class="img-fluid rounded shadow-sm mb-3 img-zoomable" alt="Relaciones Gerencia" onclick="toggleZoom(this)">
                    <div class="d-flex justify-content-between align-items-center px-3">
                        <span class="text-muted small">Fecha de subida: 18/02/2026</span>
                        <a href="../img/relaciones_internas_externas_departamentos.png" download class="btn btn-success"><i class="fas fa-download me-2"></i>Descargar Esquema</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/background-animation.js"></script>
    <script>
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('reveal');
            });
        }, { threshold: 0.15 });
        document.querySelectorAll('.area-card').forEach(card => revealObserver.observe(card));

        // NUEVA FUNCIÓN DE ZOOM
        function toggleZoom(elemento) {
            elemento.classList.toggle('zoomed');
        }
    </script>
</body>
</html>