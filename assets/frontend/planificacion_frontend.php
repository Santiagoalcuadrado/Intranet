<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planificación Estratégica - BPEZ</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        .plan-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            height: 100%;
        }
        
        .plan-header {
            background-color: var(--bpez-dark-blue);
            color: white;
            padding: 15px;
            font-weight: 700;
            text-align: center;
        }

        .service-time {
            color: var(--bpez-rojo-fuego);
            font-weight: 800;
            font-size: 1.1rem;
        }

        .day-badge {
            background-color: var(--bpez-cian);
            color: var(--bpez-dark-blue);
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 10px;
            margin-bottom: 10px;
            display: inline-block;
        }

        .timeline-item {
            padding-left: 20px;
            border-left: 3px solid var(--bpez-azul-alegre);
            margin-bottom: 20px;
            position: relative;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -9px;
            top: 0;
            width: 15px;
            height: 15px;
            background: var(--bpez-rojo-fuego);
            border-radius: 50%;
        }
    </style>
</head>
<body>

<?php include '../../includes/navbar.php'; ?>

<div class="main-content">
    <div class="container py-5">
        
        <div class="row mb-5 text-center animate-fade-up">
            <div class="col-12">
                <h2 class="section-title">Planificación Operativa y Estratégica</h2>
                <div class="title-underline"></div>
                <p class="mt-3 text-muted">Optimización de recursos y cronograma de atención al ciudadano</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4 reveal">
                <div class="bpez-card plan-card shadow-sm">
                    <div class="plan-header" style="background-color: var(--bpez-rojo-fuego);">
                        <i class="fas fa-clock me-2"></i> Servicios de Atención Fija
                    </div>
                    <div class="p-4">
                        <div class="mb-4 text-center">
                            <span class="service-time">08:00 AM - 04:00 PM</span>
                            <p class="small text-muted">Horario Corrido de Lunes a Viernes</p>
                        </div>
                        <ul class="list-unstyled">
                            <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Uso de Salas de Navegación</li>
                            <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Préstamo de Libros en Sala</li>
                            <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Referencia y Consultas Rápidas</li>
                            <li class="mb-3"><i class="fas fa-check-circle text-success me-2"></i> Visitas Guiadas Institucionales</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 reveal">
                <div class="bpez-card plan-card shadow-sm">
                    <div class="plan-header">
                        <i class="fas fa-calendar-alt me-2"></i> Agenda de Actividades Especiales
                    </div>
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-6 timeline-item">
                                <span class="day-badge">Lunes y Martes</span>
                                <h6>Mantenimiento Técnico</h6>
                                <p class="small text-muted">Actualización de software en Sala Digital y revisión de red interna.</p>
                            </div>
                            <div class="col-md-6 timeline-item">
                                <span class="day-badge">Miércoles</span>
                                <h6>Círculos de Lectura</h6>
                                <p class="small text-muted">Encuentro con comunidades escolares en la Sala Infantil "Amenodoro Urdaneta".</p>
                            </div>
                            <div class="col-md-6 timeline-item">
                                <span class="day-badge">Jueves</span>
                                <h6>Digitalización de Archivos</h6>
                                <p class="small text-muted">Jornada intensiva de escaneo de prensa histórica en la Hemeroteca.</p>
                            </div>
                            <div class="col-md-6 timeline-item">
                                <span class="day-badge">Viernes</span>
                                <h6>Cierre Administrativo</h6>
                                <p class="small text-muted">Reunión de coordinación y reporte de indicadores semanales.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 reveal">
                <div class="bpez-card p-4 text-center">
                    <h5 class="fw-bold" style="color: var(--bpez-dark-blue);">Objetivo Estratégico Mensual</h5>
                    <p>"Expandir el acceso digital a la memoria histórica del Zulia mediante la modernización de los servicios de consulta remota."</p>
                    <div class="progress" style="height: 10px; border-radius: 10px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 75%; background-color: var(--bpez-cian);" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small class="text-muted d-block mt-2">75% de la meta alcanzada en Digitalización</small>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include '../../includes/navbar.php'; ?>
<?php include '../../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/background-animation.js"></script>

<script>
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => { 
            if (entry.isIntersecting) entry.target.classList.add('active'); 
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(card => revealObserver.observe(card));
</script>

</body>
</html>