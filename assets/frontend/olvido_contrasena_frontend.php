<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Intranet BPEZ</title>
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

        html, body { height: 100%; overflow-x: hidden; }
        
        body { 
            display: flex; 
            flex-direction: column; 
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            font-family: 'Montserrat', sans-serif;
            color: #333;
            /* Animación de entrada suave al cargar */
            animation: fadeInPage 1.2s ease-out;
        }

        @keyframes fadeInPage {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .main-content { 
            flex: 1 0 auto; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 20px 10px; 
            position: relative;
            z-index: 1;
        }
        
        /* CABECERA IDÉNTICA AL LOGIN */
        .login-header-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-bottom: 2rem;
            max-width: 1000px;
            width: 100%;
        }

        .logo-img { 
            height: clamp(130px, 18vw, 220px); 
            width: auto;
            object-fit: contain; 
            filter: drop-shadow(0 8px 20px rgba(0,0,0,0.15));
            transition: all 0.4s ease;
        }
        
        .header-box { 
            background-color: var(--header-bg-integrado);
            padding: 18px 30px; 
            border-radius: 15px;
            color: var(--bpez-dark-blue);
            font-weight: 800;
            font-size: clamp(0.9rem, 1.4vw, 1.2rem); 
            text-transform: uppercase;
            letter-spacing: 0.8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            text-align: center;
            border-bottom: 5px solid var(--bpez-rojo-fuego);
            max-width: 95%;
        }

        /* TARJETA CON EFECTO GLASSMORPHISM Y FLOTADO */
        .recovery-card { 
            width: 100%;
            max-width: 450px; 
            border: none;
            border-radius: 25px; 
            padding: 2.5rem; 
            /* Fondo semi-transparente para ver los libros pasar */
            background: rgba(255, 255, 255, 0.85) !important; 
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px rgba(0, 51, 102, 0.15);
            border-top: 6px solid var(--bpez-rojo-fuego);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: floatCard 6s ease-in-out infinite;
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .recovery-card:hover {
            transform: scale(1.01);
            box-shadow: 0 25px 50px rgba(0, 51, 102, 0.2);
        }
        
        .section-icon { color: var(--bpez-dark-blue); margin-bottom: 1rem; }

        /* BOTONES DINÁMICOS */
        .btn-confirm { 
            background-color: var(--bpez-azul-alegre); 
            color: white; 
            border: none; 
            border-radius: 50px; 
            padding: 14px; 
            font-weight: 800;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            width: 100%;
            margin-bottom: 10px;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(0, 119, 182, 0.2);
        }
        .btn-confirm:hover { 
            background-color: var(--bpez-dark-blue); 
            color: white; 
            transform: translateY(-3px) scale(1.02); 
        }
        
        .btn-back { 
            background-color: #6c757d; 
            color: white; 
            border: none; 
            border-radius: 50px; 
            padding: 10px; 
            font-weight: 600;
            width: 100%;
            transition: all 0.3s;
            display: block;
            text-align: center;
            text-decoration: none;
            font-size: 0.85rem;
        }
        .btn-back:hover { background-color: #495057; color: white; }

        /* INPUTS CON ANIMACIÓN DE ICONO */
        .input-group-text { 
            background: transparent; 
            border: none; 
            border-bottom: 2px solid #eee; 
            border-radius: 0; 
            color: var(--bpez-azul-alegre); 
            transition: all 0.3s;
        }
        .form-control { border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px; font-weight: 500; background: transparent; }
        .form-control:focus { box-shadow: none; border-bottom-color: var(--bpez-azul-alegre); }

        .input-group:focus-within .input-group-text {
            color: var(--bpez-rojo-fuego);
            transform: scale(1.1);
        }

        .q-label {
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--bpez-dark-blue);
            text-transform: uppercase;
            margin-bottom: 5px;
            display: block;
            text-align: left;
            letter-spacing: 0.5px;
            opacity: 0.8;
        }

        /* RESPONSIVE */
        @media (max-width: 576px) {
            .logo-img { height: 140px; }
            .header-box { padding: 15px; font-size: 0.85rem; }
            .recovery-card { padding: 1.8rem; margin: 10px; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container d-flex flex-column align-items-center">
        
        <div class="login-header-container">
            <img src="../img/logo.png" alt="Logo BPEZ" class="logo-img">
            <div class="header-box">
                Sistema de Recuperación de Credenciales - Intranet BPEZ
            </div>
        </div>

        <div class="recovery-card text-center">
            <i class="fas fa-user-shield fa-4x section-icon"></i>
            <h4 class="fw-bold mb-4" style="color: var(--bpez-dark-blue);">Recuperar Acceso</h4>
            
            <form id="recoveryForm">
                <div class="mb-4">
                    <label class="q-label">Identificación</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" class="form-control" placeholder="Cédula del Usuario" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="q-label"><i class="fas fa-comment-dots me-2"></i>Pregunta de Seguridad 1</label>
                    <input type="text" class="form-control" placeholder="Escriba su respuesta" required>
                </div>
                <div class="mb-3">
                    <label class="q-label"><i class="fas fa-comment-dots me-2"></i>Pregunta de Seguridad 2</label>
                    <input type="text" class="form-control" placeholder="Escriba su respuesta" required>
                </div>
                <div class="mb-4">
                    <label class="q-label"><i class="fas fa-comment-dots me-2"></i>Pregunta de Seguridad 3</label>
                    <input type="text" class="form-control" placeholder="Escriba su respuesta" required>
                </div>

                <hr class="my-4" style="opacity: 0.1;">

                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                    <input type="password" id="newPass" class="form-control" placeholder="Nueva Contraseña" required>
                    <span class="input-group-text" style="cursor: pointer;" onclick="togglePass('newPass', 'eye1')">
                        <i class="fas fa-eye" id="eye1"></i>
                    </span>
                </div>
                
                <div class="input-group mb-4">
                    <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                    <input type="password" id="confirmPass" class="form-control" placeholder="Confirmar Contraseña" required>
                    <span class="input-group-text" style="cursor: pointer;" onclick="togglePass('confirmPass', 'eye2')">
                        <i class="fas fa-eye" id="eye2"></i>
                    </span>
                </div>

                <button type="submit" class="btn btn-confirm mb-2 shadow">Confirmar Cambio</button>
                <a href="/assets/frontend/login_frontend.php" class="btn btn-back">CANCELAR Y VOLVER</a>
            </form>
        </div>
    </div>
</div>

<?php include '../../includes/footer.php'; ?>

<script src="../js/background-animation.js"></script>

<script>
    function togglePass(inputId, eyeId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(eyeId);
        if (input.type === "password") {
            input.type = "text";
            eye.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = "password";
            eye.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }

    document.getElementById('recoveryForm').onsubmit = function(e) {
        e.preventDefault();
        alert("¡Proceso de recuperación completado con éxito!");
        window.location.href = "login_frontend.php";
    };
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>