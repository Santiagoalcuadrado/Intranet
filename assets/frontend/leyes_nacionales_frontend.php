<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leyes Nacionales - Intranet BPEZ</title>
    
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

        /* Estilo de Tomos Legales */
        .law-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            border-left: 8px solid var(--bpez-dark-blue);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }
        
        .law-card:hover {
            transform: translateY(-5px);
            border-left-color: var(--bpez-rojo-fuego);
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.15);
        }

        .law-icon {
            font-size: 2.8rem;
            color: var(--bpez-dark-blue);
            opacity: 0.9;
        }

        .btn-listen {
            background: var(--bpez-cian);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 8px 18px;
            font-size: 0.85rem;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-listen:hover { 
            background: var(--bpez-azul-alegre); 
            color: white;
            transform: scale(1.05);
        }

        .section-title-custom {
            font-weight: 800;
            color: var(--bpez-dark-blue);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .badge-legal {
            background: rgba(0, 51, 102, 0.1);
            color: var(--bpez-dark-blue);
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 5px;
            font-size: 0.75rem;
            margin-bottom: 15px;
            display: inline-block;
        }

        .text-muted-custom {
            color: #555;
            font-weight: 500;
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
                <h2 class="section-title-custom">Marco Legal Venezolano</h2>
                <p class="text-muted-custom">Compendio de leyes fundamentales que rigen la seguridad y los derechos laborales en la BPEZ</p>
                <hr style="width: 100px; border: 2px solid var(--bpez-rojo-fuego); margin: 0 auto; opacity: 1;">
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            
            <div class="col-md-6 col-lg-4">
                <div class="law-card h-100">
                    <span class="badge-legal">CARTA MAGNA</span>
                    <i class="fas fa-balance-scale law-icon mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">CRBV</h5>
                    <p class="small text-muted-custom">Constitución de la República Bolivariana de Venezuela. Es la base de todos los derechos ciudadanos y laborales.</p>
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-sm btn-outline-danger border-0 fw-bold"><i class="fas fa-file-pdf me-1"></i> PDF</a>
                        <button class="btn-listen" onclick="hablar('La Constitución establece en su artículo 87 que toda persona tiene derecho al trabajo y el deber de trabajar.')">
                            <i class="fas fa-volume-up me-1"></i> Escuchar
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="law-card h-100">
                    <span class="badge-legal">LEY ORGÁNICA</span>
                    <i class="fas fa-gavel law-icon mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">LOTTT</h5>
                    <p class="small text-muted-custom">Ley Orgánica del Trabajo, los Trabajadores y las Trabajadoras. Rige la relación laboral, beneficios y estabilidad.</p>
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-sm btn-outline-danger border-0 fw-bold"><i class="fas fa-file-pdf me-1"></i> PDF</a>
                        <button class="btn-listen" onclick="hablar('La LOTTT garantiza estabilidad laboral, el pago de prestaciones sociales y el derecho a vacaciones.')">
                            <i class="fas fa-volume-up me-1"></i> Escuchar
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="law-card h-100">
                    <span class="badge-legal">SALUD LABORAL</span>
                    <i class="fas fa-hard-hat law-icon mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">LOPCYMAT</h5>
                    <p class="small text-muted-custom">Ley Orgánica de Prevención, Condiciones y Medio Ambiente de Trabajo. Tu seguridad es nuestra prioridad.</p>
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-sm btn-outline-danger border-0 fw-bold"><i class="fas fa-file-pdf me-1"></i> PDF</a>
                        <button class="btn-listen" onclick="hablar('La LOPCYMAT obliga a mantener condiciones óptimas de higiene y seguridad para prevenir accidentes y enfermedades ocupacionales.')">
                            <i class="fas fa-volume-up me-1"></i> Escuchar
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="law-card h-100">
                    <span class="badge-legal">SECTOR PÚBLICO</span>
                    <i class="fas fa-user-shield law-icon mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">LEFP</h5>
                    <p class="small text-muted-custom">Ley del Estatuto de la Función Pública. Define las normas y deberes para los servidores del Estado.</p>
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-sm btn-outline-danger border-0 fw-bold"><i class="fas fa-file-pdf me-1"></i> PDF</a>
                        <button class="btn-listen" onclick="hablar('Este estatuto regula el ingreso, ascenso y retiro de los funcionarios públicos de la Biblioteca.')">
                            <i class="fas fa-volume-up me-1"></i> Escuchar
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="law-card h-100">
                    <span class="badge-legal">SEGURIDAD SOCIAL</span>
                    <i class="fas fa-hospital-user law-icon mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">Ley del IVSS</h5>
                    <p class="small text-muted-custom">Ley del Seguro Social. Protección integral ante salud, maternidad, invalidez y vejez.</p>
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <a href="#" class="btn btn-sm btn-outline-danger border-0 fw-bold"><i class="fas fa-file-pdf me-1"></i> PDF</a>
                        <button class="btn-listen" onclick="hablar('El Seguro Social garantiza el derecho a la salud y pensiones para todo el personal.')">
                            <i class="fas fa-volume-up me-1"></i> Escuchar
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

</body>
</html>