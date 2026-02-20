<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informes de Gestión - BPEZ</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        .report-folder {
            border: none;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            transition: all 0.4s ease;
            border-top: 6px solid var(--bpez-azul-alegre);
            position: relative;
            overflow: hidden;
        }

        .report-folder:hover {
            transform: translateY(-12px);
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.15);
            border-top-color: var(--bpez-rojo-fuego);
        }

        .folder-icon {
            font-size: 3.5rem;
            color: var(--bpez-dark-blue);
            margin-bottom: 20px;
            display: block;
        }

        .year-label {
            position: absolute;
            top: 15px;
            right: -30px;
            background: var(--bpez-cian);
            color: var(--bpez-dark-blue);
            padding: 5px 40px;
            transform: rotate(45deg);
            font-size: 0.7rem;
            font-weight: 800;
        }

        .download-btn {
            background-color: var(--bpez-dark-blue);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            transition: 0.3s;
            margin-top: 15px;
        }

        .download-btn:hover {
            background-color: var(--bpez-rojo-fuego);
            color: white;
        }

        .stat-summary {
            font-size: 0.85rem;
            color: #555;
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>
<body>

<?php include '../../includes/navbar.php'; ?>

<div class="main-content">
    <div class="container py-5">
        
        <div class="row mb-5 text-center animate-fade-up">
            <div class="col-12">
                <h2 class="section-title">Informes de Gestión Institucional</h2>
                <div class="title-underline"></div>
                <p class="mt-3 text-muted">Archivo histórico de rendición de cuentas y metas alcanzadas</p>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4 reveal">
                <div class="bpez-card report-folder shadow-sm">
                    <div class="year-label">2026</div>
                    <i class="fas fa-file-invoice folder-icon"></i>
                    <h5 class="fw-bold">Enero - 2026</h5>
                    <p class="small">Informe detallado de actividades, estadísticas y uso presupuestario mensual.</p>
                    <div class="stat-summary border-top pt-2">
                        <i class="fas fa-check-circle text-success me-1"></i> Aprobado por Dirección
                    </div>
                    <button class="download-btn"><i class="fas fa-cloud-download-alt me-2"></i>Descargar PDF</button>
                </div>
            </div>

            <div class="col-md-4 reveal">
                <div class="bpez-card report-folder shadow-sm" style="border-top-color: var(--bpez-cian);">
                    <div class="year-label">2025</div>
                    <i class="fas fa-chart-line folder-icon"></i>
                    <h5 class="fw-bold">4to Trimestre 2025</h5>
                    <p class="small">Balance general del último periodo del año anterior: Metas vs Realidad.</p>
                    <div class="stat-summary border-top pt-2">
                        <i class="fas fa-archive text-muted me-1"></i> Archivado en Sistema
                    </div>
                    <button class="download-btn"><i class="fas fa-file-pdf me-2"></i>Ver Informe</button>
                </div>
            </div>

            <div class="col-md-4 reveal">
                <div class="bpez-card report-folder shadow-sm" style="border-top-color: var(--bpez-rojo-fuego);">
                    <div class="year-label">2025</div>
                    <i class="fas fa-award folder-icon"></i>
                    <h5 class="fw-bold">Memoria y Cuenta 2025</h5>
                    <p class="small">Resumen ejecutivo anual presentado ante la Gobernación del Estado Zulia.</p>
                    <div class="stat-summary border-top pt-2">
                        <i class="fas fa-star text-warning me-1"></i> Documento Destacado
                    </div>
                    <button class="download-btn"><i class="fas fa-external-link-alt me-2"></i>Consultar</button>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-lg-8 mx-auto reveal">
                <div class="bpez-card p-4 text-center border-dashed" style="border: 2px dashed #ccc; background: rgba(255,255,255,0.5);">
                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                    <h6 class="fw-bold">¿Necesitas subir un nuevo informe?</h6>
                    <p class="small text-muted">Solo los coordinadores de área pueden cargar documentos oficiales de gestión.</p>
                    <button class="btn btn-sm btn-outline-dark rounded-pill">Solicitar Acceso</button>
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