<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Intranet BPEZ</title>
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
        }

        .main-content { 
            flex: 1 0 auto; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 20px 10px; 
        }
        
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

        /* LOGO CON PRESENCIA INSTITUCIONAL */
        .logo-img { 
            /* Mínimo 130px en móviles pequeños, escala con el ancho, máximo 220px en monitores estándar */
            height: clamp(130px, 18vw, 220px); 
            width: auto;
            object-fit: contain; 
            filter: drop-shadow(0 8px 20px rgba(0,0,0,0.15));
            transition: all 0.3s ease;
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

        .login-card { 
            width: 100%;
            max-width: 450px; 
            border: none;
            border-radius: 25px; 
            padding: 2.5rem; 
            background: white; 
            box-shadow: 0 20px 40px rgba(0, 51, 102, 0.12);
            border-top: 6px solid var(--bpez-azul-alegre);
        }
        
        .user-icon { color: var(--bpez-azul-alegre); margin-bottom: 1rem; }

        .btn-custom { 
            background-color: var(--bpez-rojo-fuego); 
            color: white; 
            border: none; 
            border-radius: 50px; 
            padding: 14px; 
            font-weight: 800;
            transition: all 0.3s;
            width: 100%;
            box-shadow: 0 4px 12px rgba(206, 32, 41, 0.2);
            text-transform: uppercase;
        }
        .btn-custom:hover { background-color: #b01b22; color: white; transform: translateY(-2px); }
        
        .btn-link-custom { 
            color: var(--bpez-dark-blue); 
            text-decoration: none; 
            font-size: 0.85rem; 
            font-weight: 600;
        }

        .input-group-text { background: transparent; border: none; border-bottom: 2px solid #eee; border-radius: 0; color: var(--bpez-azul-alegre); }
        .form-control { border: none; border-bottom: 2px solid #eee; border-radius: 0; padding: 10px; font-weight: 500; }
        .form-control:focus { box-shadow: none; border-bottom-color: var(--bpez-azul-alegre); }

        footer { 
            background-color: var(--header-bg-integrado);
            color: var(--bpez-dark-blue);
            border-top: 1px solid rgba(0,0,0,0.1);
            padding: 20px 0; 
        }
        .footer-text { font-size: 0.8rem; font-weight: 600; }

        /* --- RESPONSIVE ESPECÍFICO --- */

        /* SMARTPHONES: El logo se mantiene visible y legible */
        @media (max-width: 576px) {
            .logo-img { height: 140px; } /* Forzamos un tamaño respetable en móvil */
            .header-box { padding: 15px; font-size: 0.85rem; }
            .login-card { padding: 1.8rem; }
        }

        /* TABLETS Y MONITORES MEDIANOS */
        @media (min-width: 768px) and (max-width: 1200px) {
            .logo-img { height: 180px; }
        }

        /* TELEVISORES Y PANTALLAS ULTRA-WIDE (4K) */
        @media (min-width: 2000px) {
            .logo-img { height: 350px; } /* Tamaño imponente para salas de espera o TV */
            .login-card { max-width: 600px; padding: 4rem; }
            .header-box { font-size: 2rem; padding: 30px 60px; border-radius: 25px; }
            .footer-text { font-size: 1.2rem; }
            .user-icon { font-size: 6rem; }
            .form-control { font-size: 1.3rem; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container d-flex flex-column align-items-center">
        
        <div class="login-header-container">
            <img src="../img/logo.png" alt="Logo BPEZ" class="logo-img">
            <div class="header-box">
                Bienvenido/a a la Intranet de la Biblioteca Pública del Estado Zulia "María Calcaño"
            </div>
        </div>

        <div class="login-card text-center">
            <i class="fas fa-user-circle fa-4x user-icon"></i>
            <h4 class="fw-bold mb-4" style="color: var(--bpez-dark-blue);">Iniciar Sesión</h4>
            
            <form action="../../auth/ingresar_frontend.php" method="POST">
                <div class="input-group mb-4">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    <input type="text" name="cedula" class="form-control" placeholder="Cédula de Identidad" required>
                </div>
                
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="passwordField" class="form-control" placeholder="Contraseña" required>
                    <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </span>
                </div>

                <div class="text-end mb-4">
                    <a href="/assets/frontend/olvido_contrasena_frontend.php" class="btn-link-custom">¿Olvidó su contraseña?</a>
                </div>

                <button type="submit" class="btn btn-custom mb-2">INGRESAR A LA INTRANET</button>
            </form>
        </div>
    </div>
</div>

<script> //Para ver la contraseña, JS
    function togglePassword() {
        const passInput = document.getElementById('passwordField');
        const eyeIcon = document.getElementById('eyeIcon');
        if (passInput.type === "password") {
            passInput.type = "text";
            eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passInput.type = "password";
            eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>

<?php include '../../includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/background-animation.js"></script>
</body>
</html>