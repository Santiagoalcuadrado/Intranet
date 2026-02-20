<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGC: Gestión por Procesos - BPEZ</title>
    
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
            --iso-green: #28a745;
            --bpez-amarillo: #FFB703;
        }

        body { font-family: 'Montserrat', sans-serif; background-color: #f4f7f6; }

        /* Contenedor principal con margen inferior para no pisar el footer */
        .main-content { 
            padding-top: 100px; 
            min-height: calc(100vh - 100px); 
            padding-bottom: 80px; 
        }

        /* Header con toque alegre */
        .iso-header-minimal {
            border-left: 6px solid var(--bpez-cian);
            padding-left: 20px;
            margin-bottom: 40px;
        }

        .title-top { color: var(--bpez-azul-alegre); letter-spacing: 1px; }

        /* Buscador OCR Compacto y Moderno */
        .ocr-search-compact {
            background: white;
            border-radius: 50px; /* Estilo píldora interactivo */
            border: 2px solid var(--bpez-cian);
            padding: 8px 25px;
            margin-bottom: 40px;
            transition: all 0.3s ease;
        }
        .ocr-search-compact:focus-within {
            box-shadow: 0 0 15px rgba(118, 199, 192, 0.4);
            transform: translateY(-2px);
        }

        /* Tabla Estilo "Dashboard" */
        .listado-maestro {
            background: white;
            border-radius: 20px;
            border: none;
            overflow: hidden;
        }

        .table thead {
            background: var(--bpez-dark-blue);
            color: white;
            font-size: 0.8rem;
        }

        /* Tarjetas interactivas y coloridas */
        .procedure-card {
            border: none;
            border-radius: 20px;
            background: white;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            border-bottom: 4px solid transparent;
        }

        .procedure-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .card-op { border-bottom-color: var(--bpez-cian); }
        .card-it { border-bottom-color: var(--bpez-rojo-fuego); }
        .card-gs { border-bottom-color: var(--bpez-amarillo); }

        .icon-box {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
        }

        .version-tag {
            font-family: 'Consolas', monospace;
            background: #f0f0f0;
            padding: 2px 8px;
            border-radius: 6px;
            font-weight: 600;
        }

        .animate-fade-up {
            animation: fadeUp 0.8s ease forwards;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<?php include '../../includes/navbar.php'; ?>

<div class="main-content">
    <div class="container">
        
        <div class="iso-header-minimal d-flex justify-content-between align-items-center animate-fade-up">
            <div>
                <h2 class="fw-800 mb-0 title-top">Gestión de Procedimientos</h2>
                <p class="text-muted fw-600 mb-0"><i class="fas fa-certificate text-warning me-2"></i>Ruta de Calidad ISO 9001:2015</p>
            </div>
        </div>

        <div class="ocr-search-compact shadow-sm animate-fade-up">
            <div class="row align-items-center">
                <div class="col-md-5 d-flex align-items-center">
                    <i class="fas fa-bolt text-warning me-3 fa-lg"></i>
                    <span class="small fw-800 text-uppercase">Buscador Inteligente OCR</span>
                </div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 bg-transparent" placeholder="Escribe una palabra clave del PDF...">
                        <button class="btn btn-cian rounded-pill ms-2 px-4 shadow-sm text-white fw-bold" style="background: var(--bpez-cian);">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5 animate-fade-up">
            <div class="col-12">
                <div class="listado-maestro shadow-lg">
                    <div class="p-3 d-flex justify-content-between align-items-center bg-white border-bottom">
                        <h6 class="mb-0 fw-800"><i class="fas fa-database me-2 text-primary"></i>Listado Maestro de Información Documentada</h6>
                        <button class="btn btn-sm btn-outline-primary rounded-pill"><i class="fas fa-sync me-1"></i>Actualizar DB</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">PROCESO</th>
                                    <th>CÓDIGO ISO</th>
                                    <th>NOMBRE DEL DOCUMENTO</th>
                                    <th>VER.</th>
                                    <th>ESTADO</th>
                                    <th class="text-center">PDF</th>
                                </tr>
                            </thead>
                            <tbody class="small fw-600">
                                <tr>
                                    <td class="ps-4 text-primary">Operaciones</td>
                                    <td><span class="text-muted">BPEZ-OP-PRC-001</span></td>
                                    <td>Manual de Préstamo de Equipos (Sala Digital)</td>
                                    <td><span class="version-tag">2.1.0</span></td>
                                    <td><span class="badge bg-success-subtle text-success">Vigente</span></td>
                                    <td class="text-center"><a href="#" class="text-danger"><i class="fas fa-file-pdf fa-xl"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="ps-4 text-primary">Técnico</td>
                                    <td><span class="text-muted">BPEZ-TC-PRO-004</span></td>
                                    <td>Protocolo de Restauración de Papel Periódico</td>
                                    <td><span class="version-tag">1.0.2</span></td>
                                    <td><span class="badge bg-success-subtle text-success">Vigente</span></td>
                                    <td class="text-center"><a href="#" class="text-danger"><i class="fas fa-file-pdf fa-xl"></i></a></td>
                                </tr>
                                <tr>
                                    <td class="ps-4 text-primary">Seguridad</td>
                                    <td><span class="text-muted">BPEZ-IT-POL-001</span></td>
                                    <td>Plan de Contingencia ante Fallas Eléctricas</td>
                                    <td><span class="version-tag">3.4.1</span></td>
                                    <td><span class="badge bg-success-subtle text-success">Vigente</span></td>
                                    <td class="text-center"><a href="#" class="text-danger"><i class="fas fa-file-pdf fa-xl"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4 reveal">
                <div class="procedure-card card-op p-4 shadow-sm">
                    <div class="icon-box bg-info-subtle text-info">
                        <i class="fas fa-users-cog fa-lg"></i>
                    </div>
                    <h5 class="fw-800">Servicio al Lector</h5>
                    <p class="small text-muted">Asegura que cada zuliano reciba atención de calidad estandarizada.</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="badge bg-light text-dark">ISO 8.2.1</span>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4 reveal">
                <div class="procedure-card card-it p-4 shadow-sm">
                    <div class="icon-box bg-danger-subtle text-danger">
                        <i class="fas fa-shield-virus fa-lg"></i>
                    </div>
                    <h5 class="fw-800">Ciberseguridad</h5>
                    <p class="small text-muted">Resguardamos los datos históricos y la privacidad de nuestros usuarios.</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="badge bg-light text-dark">ISO 8.1.3</span>
                        <i class="fas fa-chevron-right text-muted"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-4 reveal">
                <div class="procedure-card card-gs p-4 shadow-sm">
                    <div class="icon-box bg-warning-subtle text-warning">
                        <i class="fas fa-universal-access fa-lg"></i>
                    </div>
                    <h5 class="fw-800">Accesibilidad</h5>
                    <p class="small text-muted">Protocolos inclusivos para la Sala Braille y personas con diversidad.</p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="badge bg-light text-dark">ISO 9.1.2</span>
                        <i class="fas fa-chevron-right text-muted"></i>
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
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-up');
                entry.target.style.opacity = 1;
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.reveal').forEach(el => {
        el.style.opacity = 0;
        observer.observe(el);
    });
</script>

</body>
</html>