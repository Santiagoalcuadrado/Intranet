<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Intranet BPEZ</title>
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

        html, body { height: 100%; }
        
        body { 
            display: flex; 
            flex-direction: column; 
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            font-family: 'Montserrat', sans-serif;
            color: #333;
            /* Margen superior para que el navbar fixed no tape el contenido */
            padding-top: 100px; 
        }

        .main-content { flex: 1 0 auto; }

        /* ESTILOS EXCLUSIVOS DE LA CARD PERFIL */
        .profile-card {
            background: white;
            border-radius: 25px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            max-width: 900px;
            margin: 40px auto;
            border-top: 6px solid var(--bpez-azul-alegre);
            position: relative;
        }

        .profile-icon-top {
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--bpez-dark-blue);
            color: white;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 5px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .info-label { 
            font-weight: 800; 
            color: var(--bpez-dark-blue); 
            font-size: 0.85rem; 
            text-transform: uppercase; 
            margin-bottom: 5px; 
        }

        .info-value { 
            border-bottom: 2px solid #f0f0f0; 
            padding: 8px 0; 
            font-weight: 500; 
            color: #444; 
            margin-bottom: 20px; 
        }

        .update-tag { 
            font-size: 0.7rem; 
            color: #999; 
            font-style: italic; 
            display: block; 
        }

        .btn-action { 
            border-radius: 50px; 
            padding: 10px 30px; 
            font-weight: 800; 
            text-transform: uppercase; 
            transition: 0.3s; 
            border: none; 
        }

        .btn-save { background-color: var(--bpez-dark-blue); color: white; }
        .btn-save:hover { background-color: var(--bpez-azul-alegre); color: white; transform: scale(1.05); }
        .btn-edit { background-color: #555; color: white; }
        .btn-edit:hover { background-color: #333; color: white; transform: scale(1.05); }

    </style>
</head>
<body>

    <?php include '../../includes/navbar.php'; ?>

    <div class="main-content">
        <div class="container">
            <div class="profile-card">
                <div class="profile-icon-top">
                    <i class="fas fa-user-shield fa-2x"></i>
                </div>
                
                <h4 class="text-center fw-bold mb-5" style="color: var(--bpez-dark-blue);">MI PERFIL DE USUARIO</h4>

                <div class="row">
                    <div class="col-md-6">
                        <div class="info-label"><i class="fas fa-user me-2"></i> Nombres</div>
                        <div class="info-value">Maria Victoria</div>
                        
                        <div class="info-label"><i class="fas fa-id-card me-2"></i> Cédula</div>
                        <div class="info-value">12.345.678</div>
                        
                        <div class="info-label"><i class="fas fa-phone me-2"></i> Teléfono</div>
                        <div class="info-value">0412-1234567</div>
                        <span class="update-tag mb-4">Última mod: 12/01/2026</span>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label"><i class="fas fa-user me-2"></i> Apellidos</div>
                        <div class="info-value">Calcaño</div>
                        
                        <div class="info-label"><i class="fas fa-calendar-day me-2"></i> Edad</div>
                        <div class="info-value">28 Años</div>
                        
                        <div class="info-label"><i class="fas fa-key me-2"></i> Contraseña</div>
                        <div class="info-value">**********</div>
                        <span class="update-tag mb-4">Última mod: 05/02/2026</span>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button class="btn-action btn-save shadow-sm me-2"><i class="fas fa-save me-2"></i>Guardar</button>
                    <button class="btn-action btn-edit shadow-sm"><i class="fas fa-edit me-2"></i>Editar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/background-animation.js"></script>
</body>
</html>