<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reglamento Interno - Intranet BPEZ</title>
    
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

        /* Estilo de Acordeón Personalizado para el Reglamento */
        .rules-container {
            background: white;
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 51, 102, 0.1);
        }

        .accordion-item {
            border: none;
            margin-bottom: 15px;
            border-radius: 15px !important;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .accordion-button {
            font-weight: 700;
            color: var(--bpez-dark-blue);
            background-color: #f8f9fa;
        }

        .accordion-button:not(.collapsed) {
            background-color: var(--bpez-dark-blue);
            color: white;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(0,0,0,.125);
        }

        .rule-icon {
            width: 30px;
            color: var(--bpez-cian);
            margin-right: 10px;
        }

        .accordion-button:not(.collapsed) .rule-icon {
            color: white;
        }

        .btn-listen-rule {
            background: var(--bpez-rojo-fuego);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 4px 12px;
            font-size: 0.75rem;
            float: right;
            margin-top: -2px;
        }

        .section-header {
            border-left: 5px solid var(--bpez-rojo-fuego);
            padding-left: 15px;
            margin-bottom: 30px;
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
        
        <div class="rules-container animate-fade-up">
            <div class="section-header">
                <h2 class="fw-800 text-uppercase m-0" style="color: var(--bpez-dark-blue);">Reglamento Interno</h2>
                <p class="text-muted m-0">Normas generales de conducta y funcionamiento institucional BPEZ</p>
            </div>

            <div class="accordion" id="accordionReglamento">
                
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#cap1">
                            <i class="fas fa-clock rule-icon"></i> Jornada Laboral y Asistencia
                        </button>
                    </h2>
                    <div id="cap1" class="accordion-collapse collapse show" data-bs-parent="#accordionReglamento">
                        <div class="accordion-body text-muted">
                            <button class="btn-listen-rule" onclick="hablar('Capítulo uno. La jornada laboral se cumple de lunes a viernes. El registro de asistencia es obligatorio al entrar y salir.')">
                                <i class="fas fa-volume-up"></i> Leer
                            </button>
                            <ul>
                                <li>El horario administrativo es de 8:00 AM a 4:00 PM.</li>
                                <li>Se otorga una tolerancia de 15 minutos para el ingreso.</li>
                                <li>Toda ausencia debe ser notificada a su supervisor inmediato en las primeras 2 horas.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cap2">
                            <i class="fas fa-user-tie rule-icon"></i> Imagen e Identificación
                        </button>
                    </h2>
                    <div id="cap2" class="accordion-collapse collapse" data-bs-parent="#accordionReglamento">
                        <div class="accordion-body text-muted">
                            <button class="btn-listen-rule" onclick="hablar('Capítulo dos. El uso del carnet institucional es obligatorio en todas las áreas de la biblioteca para el personal activo.')">
                                <i class="fas fa-volume-up"></i> Leer
                            </button>
                            <ul>
                                <li>Uso obligatorio del carnet visible en áreas de atención al público.</li>
                                <li>Vestimenta acorde al entorno de oficina y atención ciudadana.</li>
                                <li>Mantener el orden y la limpieza en el puesto de trabajo.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cap3">
                            <i class="fas fa-laptop-code rule-icon"></i> Uso de Recursos Tecnológicos
                        </button>
                    </h2>
                    <div id="cap3" class="accordion-collapse collapse" data-bs-parent="#accordionReglamento">
                        <div class="accordion-body text-muted">
                            <button class="btn-listen-rule" onclick="hablar('Capítulo tres. Los equipos de computación son herramientas exclusivas para labores institucionales.')">
                                <i class="fas fa-volume-up"></i> Leer
                            </button>
                            <p>Queda prohibido el uso de los equipos de la biblioteca para fines personales que comprometan la seguridad de la red o el desempeño laboral.</p>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cap4">
                            <i class="fas fa-handshake rule-icon"></i> Ética y Convivencia
                        </button>
                    </h2>
                    <div id="cap4" class="accordion-collapse collapse" data-bs-parent="#accordionReglamento">
                        <div class="accordion-body text-muted">
                            <button class="btn-listen-rule" onclick="hablar('Capítulo cuatro. El respeto mutuo y la colaboración son la base de nuestra cultura en la Biblioteca Pública del Zulia.')">
                                <i class="fas fa-volume-up"></i> Leer
                            </button>
                            <p>Fomentamos un ambiente libre de acoso, discriminación y conflictos, priorizando siempre el servicio al usuario zuliano.</p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-5 p-3 rounded-4" style="background: rgba(118, 199, 192, 0.1); border: 1px dashed var(--bpez-cian);">
                <div class="d-flex align-items-center">
                    <i class="fas fa-info-circle fa-2x me-3 text-primary"></i>
                    <p class="small m-0 text-muted">Para conocer el régimen disciplinario completo y sanciones, puedes descargar el documento original en PDF aprobado por la Dirección General.</p>
                    <a href="#" class="btn btn-sm btn-dark ms-auto rounded-pill px-3">Descargar PDF</a>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include '../../includes/footer.php'; ?>

</body>
</html>