<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguridad Laboral - Intranet BPEZ</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    
    <style>
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo-fuego: #CE2029;
            --bpez-dark-blue: #003366; 
            --bpez-azul-alegre: #0077B6;
        }

        body { 
            padding-top: 100px; 
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
        }

        /* Tarjetas de Protocolo */
        .safety-card {
            background: white;
            border-radius: 20px;
            border: none;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .safety-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(206, 32, 41, 0.15);
        }

        .icon-box {
            width: 70px;
            height: 70px;
            background: rgba(206, 32, 41, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: var(--bpez-rojo-fuego);
        }

        /* Sección de Emergencia */
        .emergency-bar {
            background: var(--bpez-rojo-fuego);
            color: white;
            border-radius: 15px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-call {
            background: white;
            color: var(--bpez-rojo-fuego);
            border-radius: 50px;
            font-weight: 800;
            padding: 10px 25px;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-call:hover { background: var(--bpez-dark-blue); color: white; }

        .map-placeholder {
            background: #e9ecef;
            border-radius: 20px;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed #ccc;
        }
    </style>
</head>
<body>

<?php include '../../includes/navbar.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/background-animation.js"></script>
<script src="../js/ia_voice_global.js"></script>

<div class="main-content">
    <div class="container py-5">
        
        <div class="row mb-5 text-center">
            <div class="col-12">
                <h2 class="fw-800 text-uppercase" style="color: var(--bpez-dark-blue);">Seguridad y Salud Laboral</h2>
                <p class="text-muted">Prevención de riesgos, salud ocupacional y protocolos de emergencia BPEZ</p>
                <button class="btn btn-sm btn-dark rounded-pill px-4" onclick="hablar('Bienvenido a la sección de Seguridad Laboral. Aquí encontrarás protocolos de emergencia y prevención de riesgos laborales.')">
                    <i class="fas fa-play-circle me-2"></i> Escuchar Introducción
                </button>
            </div>
        </div>

        <div class="emergency-bar shadow-lg mb-5 animate-pulse">
            <div class="d-flex align-items-center">
                <i class="fas fa-phone-alt fa-2x me-3"></i>
                <div>
                    <h5 class="m-0 fw-800">CENTRO DE EMERGENCIAS INTERNO</h5>
                    <p class="m-0 small">Disponible 24/7 para reportar accidentes o incidencias</p>
                </div>
            </div>
            <a href="#" class="btn-call shadow">EXT. 104 / 911</a>
        </div>

        <div class="row g-4">
            
            <div class="col-md-4">
                <div class="safety-card p-4 shadow-sm">
                    <div class="icon-box"><i class="fas fa-fire-extinguisher fa-2x"></i></div>
                    <h5 class="fw-bold">Prevención de Incendios</h5>
                    <p class="small text-muted">Uso correcto de extintores, ubicación de hidrantes y prohibición de fumar en áreas restringidas.</p>
                    <button class="btn btn-link p-0 text-danger fw-bold text-decoration-none" onclick="hablar('En caso de incendio, mantenga la calma, use el extintor más cercano solo si sabe operarlo y diríjase a la salida.')">Escuchar Protocolo</button>
                </div>
            </div>

            <div class="col-md-4">
                <div class="safety-card p-4 shadow-sm">
                    <div class="icon-box"><i class="fas fa-hard-hat fa-2x"></i></div>
                    <h5 class="fw-bold">Equipos de Protección</h5>
                    <p class="small text-muted">Uso obligatorio de botas de seguridad y guantes para el personal de mantenimiento y servicios generales.</p>
                    <button class="btn btn-link p-0 text-danger fw-bold text-decoration-none" onclick="hablar('El uso de cascos y botas es obligatorio para todo el personal de infraestructura y áreas de depósito.')">Escuchar Protocolo</button>
                </div>
            </div>

            <div class="col-md-4">
                <div class="safety-card p-4 shadow-sm">
                    <div class="icon-box"><i class="fas fa-first-aid fa-2x"></i></div>
                    <h5 class="fw-bold">Primeros Auxilios</h5>
                    <p class="small text-muted">Ubicación de botiquines en cada piso y lista de brigadistas capacitados para RCP.</p>
                    <button class="btn btn-link p-0 text-danger fw-bold text-decoration-none" onclick="hablar('Los botiquines de primeros auxilios están ubicados en la recepción de cada piso y en el área administrativa.')">Escuchar Protocolo</button>
                </div>
            </div>

            <div class="col-lg-8 mt-5">
                <div class="bg-white p-4 rounded-4 shadow-sm h-100">
                    <h5 class="fw-800 mb-3" style="color: var(--bpez-dark-blue);">Ruta de Evacuación Principal</h5>
                    <p class="small text-muted">Punto de encuentro: **Patio de los Lucernarios**. No use los ascensores durante un sismo o incendio.</p>
                    <div class="map-placeholder">
                        <div class="text-center">
                            <i class="fas fa-map-marked-alt fa-3x mb-2 text-muted"></i>
                            <p class="text-muted fw-bold">Plano de Planta BPEZ (Imagen Informativa)</p>
                            <span class="badge bg-primary">Click para ampliar</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 mt-5">
                <div class="bg-dark p-4 rounded-4 shadow-sm text-white h-100">
                    <h5 class="fw-800 mb-4 text-cian" style="color: var(--bpez-cian);">Brigada BPEZ</h5>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-secondary rounded-circle me-3" style="width: 45px; height: 45px;"></div>
                        <div>
                            <p class="m-0 fw-bold">Juan Pérez</p>
                            <p class="m-0 x-small opacity-75">Jefe de Brigada - Piso 2</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-secondary rounded-circle me-3" style="width: 45px; height: 45px;"></div>
                        <div>
                            <p class="m-0 fw-bold">María González</p>
                            <p class="m-0 x-small opacity-75">Brigadista - Planta Baja</p>
                        </div>
                    </div>
                    <hr>
                    <p class="x-small opacity-50">Llamado a nuevos voluntarios: Contactar a RRHH para capacitación ante el INPSASEL.</p>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

</body>
</html>