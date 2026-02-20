<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Actividades - BPEZ</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../css/styles.css">

    <style>
        /* Tarjetas de Métricas Rápidas */
        .metric-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 20px;
            border-bottom: 5px solid var(--bpez-cian);
            transition: all 0.3s ease;
        }
        .metric-card:hover {
            transform: translateY(-5px);
        }
        .metric-icon {
            width: 50px;
            height: 50px;
            background: var(--header-bg-integrado);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--bpez-dark-blue);
            margin-bottom: 15px;
        }
        .metric-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--bpez-dark-blue);
            display: block;
        }
        .metric-label {
            font-size: 0.8rem;
            color: #666;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Tabla Estilizada */
        .report-table-container {
            background: white;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }
        .status-pill {
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .bg-success-soft { background-color: #d1e7dd; color: #0f5132; }
        .bg-primary-soft { background-color: #cfe2ff; color: #084298; }
    </style>
</head>
<body>

<?php include '../../includes/navbar.php'; ?>

<div class="main-content">
    <div class="container py-5">
        
        <div class="row mb-5 text-center animate-fade-up">
            <div class="col-12">
                <h2 class="section-title">Reporte de Actividades Institucionales</h2>
                <div class="title-underline"></div>
                <p class="mt-3 text-muted">Monitoreo de impacto y servicios prestados a la comunidad zuliana</p>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3 reveal">
                <div class="metric-card shadow-sm">
                    <div class="metric-icon"><i class="fas fa-users"></i></div>
                    <span class="metric-value">1,250</span>
                    <span class="metric-label">Usuarios Atendidos</span>
                </div>
            </div>
            <div class="col-md-3 reveal">
                <div class="metric-card shadow-sm" style="border-bottom-color: var(--bpez-rojo-fuego);">
                    <div class="metric-icon"><i class="fas fa-book"></i></div>
                    <span class="metric-value">458</span>
                    <span class="metric-label">Libros Consultados</span>
                </div>
            </div>
            <div class="col-md-3 reveal">
                <div class="metric-card shadow-sm">
                    <div class="metric-icon"><i class="fas fa-laptop"></i></div>
                    <span class="metric-value">320</span>
                    <span class="metric-label">Horas de Navegación</span>
                </div>
            </div>
            <div class="col-md-3 reveal">
                <div class="metric-card shadow-sm" style="border-bottom-color: var(--bpez-dark-blue);">
                    <div class="metric-icon"><i class="fas fa-id-card"></i></div>
                    <span class="metric-value">85</span>
                    <span class="metric-label">Nuevos Carnets</span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 reveal">
                <div class="report-table-container shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0" style="color: var(--bpez-dark-blue);">Bitácora de Servicios Recientes</h5>
                        <button class="btn btn-sm btn-dark rounded-pill px-3"><i class="fas fa-download me-2"></i>Exportar Excel</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Actividad / Servicio</th>
                                    <th>Departamento</th>
                                    <th>Alcance</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>16/02/2026</td>
                                    <td class="fw-bold">Visita Guiada: U.E.N. Rafael Urdaneta</td>
                                    <td>Sala Infantil</td>
                                    <td>45 Niños</td>
                                    <td><span class="status-pill bg-success-soft">Completado</span></td>
                                </tr>
                                <tr>
                                    <td>15/02/2026</td>
                                    <td class="fw-bold">Digitalización Diario "El Fonógrafo"</td>
                                    <td>Hemeroteca</td>
                                    <td>20 Tomos</td>
                                    <td><span class="status-pill bg-primary-soft">En Proceso</span></td>
                                </tr>
                                <tr>
                                    <td>14/02/2026</td>
                                    <td class="fw-bold">Taller de Lectura Braille</td>
                                    <td>Sala Especial</td>
                                    <td>12 Personas</td>
                                    <td><span class="status-pill bg-success-soft">Completado</span></td>
                                </tr>
                            </tbody>
                        </table>
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