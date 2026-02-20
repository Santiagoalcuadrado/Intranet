<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos Institucionales - BPEZ</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        .project-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s ease;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
        }

        .project-card:hover {
            transform: translateY(-10px);
        }

        /* Semaforización POA */
        .semaforo-poa {
            height: 12px;
            width: 100%;
            display: flex;
        }
        .status-dot {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        .bg-verde { background-color: #28a745; box-shadow: 0 0 10px rgba(40, 167, 69, 0.5); }
        .bg-amarillo { background-color: #ffc107; box-shadow: 0 0 10px rgba(255, 193, 7, 0.5); }
        .bg-rojo { background-color: #dc3545; box-shadow: 0 0 10px rgba(220, 53, 69, 0.5); }

        .project-tag {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 50px;
            background: var(--header-bg-integrado);
            color: var(--bpez-dark-blue);
        }
    </style>
</head>
<body>

<?php include '../../includes/navbar.php'; ?>

<div class="main-content">
    <div class="container py-5">
        
        <div class="row mb-5 text-center animate-fade-up">
            <div class="col-12">
                <h2 class="section-title">Portafolio de Proyectos (POA)</h2>
                <div class="title-underline"></div>
                <p class="mt-3 text-muted">Seguimiento y control de las iniciativas estratégicas del Zulia</p>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-md-6 col-lg-4 reveal">
                <div class="bpez-card project-card h-100 p-4 shadow-sm">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="project-tag">DESARROLLO INTERNO</span>
                        <div class="status-dot bg-verde" title="Estatus: En Marcha"></div>
                    </div>
                    <h5 class="fw-bold" style="color: var(--bpez-dark-blue);">Intranet BPEZ</h5>
                    <p class="small text-muted">Plataforma de gestión integral para inducción, capacitación y trabajo colaborativo del personal.</p>
                    <div class="mt-auto">
                        <small class="d-block mb-1 fw-bold">Progreso POA: 90%</small>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 90%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 reveal">
                <div class="bpez-card project-card h-100 p-4 shadow-sm">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="project-tag">WEB / EVENTOS</span>
                        <div class="status-dot bg-amarillo" title="Estatus: En Revisión"></div>
                    </div>
                    <h5 class="fw-bold" style="color: var(--bpez-dark-blue);">Memorias del Encuentro Regional</h5>
                    <p class="small text-muted">Página web dedicada a recopilar las ponencias y registros históricos del Encuentro de Bibliotecas del Zulia.</p>
                    <div class="mt-auto">
                        <small class="d-block mb-1 fw-bold">Progreso POA: 65%</small>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: 65%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 reveal">
                <div class="bpez-card project-card h-100 p-4 shadow-sm">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="project-tag">LITERATURA INFANTIL</span>
                        <div class="status-dot bg-verde" title="Estatus: Activo"></div>
                    </div>
                    <h5 class="fw-bold" style="color: var(--bpez-dark-blue);">Horizonte de Cuentos</h5>
                    <p class="small text-muted">Programa de fomento a la lectura que busca digitalizar cuentos regionales para las nuevas generaciones.</p>
                    <div class="mt-auto">
                        <small class="d-block mb-1 fw-bold">Progreso POA: 100%</small>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 reveal">
                <div class="bpez-card project-card h-100 p-4 shadow-sm">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="project-tag">PATRIMONIO</span>
                        <div class="status-dot bg-rojo" title="Estatus: Detenido"></div>
                    </div>
                    <h5 class="fw-bold" style="color: var(--bpez-dark-blue);">Foto-Memoria Zuliana</h5>
                    <p class="small text-muted">Restauración digital del archivo fotográfico del estado Zulia del siglo XIX.</p>
                    <div class="mt-auto">
                        <small class="d-block mb-1 fw-bold">Progreso POA: 15%</small>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-danger" style="width: 15%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4 reveal">
                <div class="bpez-card project-card h-100 p-4 shadow-sm">
                    <div class="d-flex justify-content-between mb-3">
                        <span class="project-tag">SOCIAL</span>
                        <div class="status-dot bg-amarillo" title="Estatus: Pendiente"></div>
                    </div>
                    <h5 class="fw-bold" style="color: var(--bpez-dark-blue);">BiblioBus Zulia</h5>
                    <p class="small text-muted">Proyecto de unidad móvil para llevar libros y tecnología a los municipios foráneos del estado.</p>
                    <div class="mt-auto">
                        <small class="d-block mb-1 fw-bold">Progreso POA: 40%</small>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: 40%"></div>
                        </div>
                    </div>
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