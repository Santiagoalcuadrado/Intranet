<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minutas y Reuniones - BPEZ</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        .meeting-card {
            border-left: 6px solid var(--bpez-azul-alegre);
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }

        .meeting-card:hover {
            transform: translateX(10px);
            border-left-color: var(--bpez-rojo-fuego);
        }

        .date-badge {
            background: var(--bpez-dark-blue);
            color: white;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            min-width: 70px;
        }

        .date-badge .day { font-size: 1.5rem; font-weight: 800; line-height: 1; }
        .date-badge .month { font-size: 0.7rem; text-transform: uppercase; }

        .attendees-avatars img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid white;
            margin-left: -10px;
        }

        .meeting-type {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--bpez-rojo-fuego);
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<?php include '../../includes/navbar.php'; ?>

<div class="main-content">
    <div class="container py-5">
        
        <div class="row mb-5 text-center animate-fade-up">
            <div class="col-12">
                <h2 class="section-title">Control de Reuniones y Minutas</h2>
                <div class="title-underline"></div>
                <p class="mt-3 text-muted">Registro oficial de acuerdos y decisiones institucionales</p>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 mx-auto">
                
                <div class="bpez-card meeting-card p-4 mb-4 reveal shadow-sm">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="date-badge me-4 mb-3 mb-md-0">
                            <div class="day">18</div>
                            <div class="month">Feb</div>
                        </div>
                        <div class="flex-grow-1">
                            <span class="meeting-type">Consejo Directivo</span>
                            <h5 class="fw-bold mb-1" style="color: var(--bpez-dark-blue);">Planificación Aniversario BPEZ</h5>
                            <p class="small text-muted mb-0"><i class="fas fa-map-marker-alt me-1"></i> Auditorio Central | <i class="fas fa-clock me-1"></i> 09:30 AM</p>
                        </div>
                        <div class="text-md-end mt-3 mt-md-0">
                            <button class="btn btn-sm btn-outline-primary rounded-pill"><i class="fas fa-file-pdf me-1"></i> Ver Minuta</button>
                        </div>
                    </div>
                </div>

                <div class="bpez-card meeting-card p-4 mb-4 reveal shadow-sm">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="date-badge me-4 mb-3 mb-md-0">
                            <div class="day">20</div>
                            <div class="month">Feb</div>
                        </div>
                        <div class="flex-grow-1">
                            <span class="meeting-type">Mesa Técnica de Sistemas</span>
                            <h5 class="fw-bold mb-1" style="color: var(--bpez-dark-blue);">Migración de Base de Datos Bibliográfica</h5>
                            <p class="small text-muted mb-0"><i class="fas fa-map-marker-alt me-1"></i> Sala Digital | <i class="fas fa-clock me-1"></i> 02:00 PM</p>
                        </div>
                        <div class="text-md-end mt-3 mt-md-0">
                            <span class="badge bg-warning text-dark rounded-pill p-2 px-3">Próximamente</span>
                        </div>
                    </div>
                </div>

                <div class="bpez-card meeting-card p-4 mb-4 reveal shadow-sm">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="date-badge me-4 mb-3 mb-md-0">
                            <div class="day">12</div>
                            <div class="month">Feb</div>
                        </div>
                        <div class="flex-grow-1">
                            <span class="meeting-type">Asamblea General</span>
                            <h5 class="fw-bold mb-1" style="color: var(--bpez-dark-blue);">Nuevas Políticas de Inducción de Personal</h5>
                            <p class="small text-muted mb-0"><i class="fas fa-map-marker-alt me-1"></i> Patio de los Lucernarios | <i class="fas fa-check-double text-success ms-2"></i> Finalizada</p>
                        </div>
                        <div class="text-md-end mt-3 mt-md-0">
                            <button class="btn btn-sm btn-outline-primary rounded-pill"><i class="fas fa-file-pdf me-1"></i> Ver Minuta</button>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-5">
                    <button class="btn btn-primary rounded-pill px-5 py-2 shadow" style="background-color: var(--bpez-dark-blue); border: none;">
                        <i class="fas fa-calendar-plus me-2"></i> Agendar Nueva Reunión
                    </button>
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
            if (entry.isIntersecting) entry.target.classList.add('active'); 
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(card => revealObserver.observe(card));
</script>

</body>
</html>