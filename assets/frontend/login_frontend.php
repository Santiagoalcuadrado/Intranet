<?php
/**
 * login_frontend.php
 * Página de inicio de sesión de la Intranet BPEZ
 * Versión OFFLINE - usa recursos locales
 */

// Capturar mensajes de error enviados desde el backend
$error_msg = "";
$tiempo_restante = 0;

if (isset($_GET['error'])) {
    if ($_GET['error'] == 'credenciales_invalidas') {
        $error_msg = "Cédula o contraseña incorrectas.";
    } elseif ($_GET['error'] == 'acceso_denegado') {
        $error_msg = "Debe iniciar sesión para acceder.";
    } elseif ($_GET['error'] == 'sesion_expirada') {
        $error_msg = "Su sesión ha expirado.";
    } elseif ($_GET['error'] == 'demasiados_intentos' && isset($_GET['tiempo'])) {
        $tiempo_restante = intval($_GET['tiempo']);
        $minutos = floor($tiempo_restante / 60);
        $segundos = $tiempo_restante % 60;
        
        if ($minutos > 0) {
            $error_msg = "Demasiados intentos fallidos. Espere $minutos minutos y " . 
                        ($segundos > 0 ? "$segundos segundos" : "") . " para intentar nuevamente.";
        } else {
            $error_msg = "Demasiados intentos fallidos. Espere $segundos segundos para intentar nuevamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Intranet BPEZ</title>
    
    <!-- ===== RECURSOS OFFLINE (MODULAR) ===== -->
    <!-- Incluye Bootstrap CSS, Font Awesome y Montserrat local -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/offline_assets.php'; ?>
    
    <!-- ===== FAVICONS (MODULAR) ===== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/favicon.php'; ?>    
    
    <style>
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo-fuego: #CE2029;
            --bpez-dark-blue: #003366; 
            --bpez-azul-alegre: #0077B6;
            --header-bg-integrado: #e0f2f1;
        }

        /* ===== CORRECCIÓN 1: Mantener sin scroll en PC ===== */
        html, body { 
            height: 100vh;
            margin: 0; 
            overflow: hidden;
        }
        
        body { 
            display: flex; 
            flex-direction: column; 
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            color: #333;
        }

        /* ===== CORRECCIÓN 2: Contenedor principal con altura fija ===== */
        .main-content { 
            flex: 1;
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 10px 20px; /* Padding reducido */
            overflow: hidden;
        }
        
        /* ===== CORRECCIÓN 3: Header con márgenes reducidos ===== */
        .login-header-container {
            display: flex;
            flex-direction: row; 
            align-items: stretch;
            justify-content: center;
            gap: 12px; /* Reducido de 15px */
            margin-bottom: 0.8rem; /* Reducido de 1rem */
            max-width: 1000px;
            width: 100%;
        }

        .logo-img { 
            height: auto;
            width: auto;
            max-height: 110px; /* Reducido de 120px */
            max-width: 100%;
            object-fit: contain; 
            filter: drop-shadow(0 8px 20px rgba(0,0,0,0.15));
            align-self: center;
        }
        
        .header-box { 
            background-color: var(--header-bg-integrado);
            padding: 12px 20px; /* Reducido de 15px 25px */
            border-radius: 15px;
            color: var(--bpez-dark-blue);
            font-weight: 800;
            font-size: clamp(0.8rem, 1.1vw, 0.95rem); /* Reducido */
            text-transform: uppercase;
            letter-spacing: 0.8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-bottom: 5px solid var(--bpez-rojo-fuego);
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-height: 80px; /* Reducido de 90px */
            line-height: 1.3;
        }

        /* ===== CORRECCIÓN 4: Tarjeta de login con padding reducido ===== */
        .login-card { 
            width: 100%;
            max-width: 400px; /* Reducido de 420px */
            border: none;
            border-radius: 25px; 
            padding: 1.5rem 1.8rem; /* Reducido de 1.8rem 2.2rem */
            background: white; 
            box-shadow: 0 20px 40px rgba(0, 51, 102, 0.12);
            border-top: 6px solid var(--bpez-azul-alegre);
            margin: 0 auto;
        }
        
        .user-icon { 
            color: var(--bpez-azul-alegre); 
            margin-bottom: 0.3rem; /* Reducido de 0.5rem */
            font-size: clamp(2rem, 4.5vw, 2.8rem); /* Reducido */
        }

        h4.fw-bold {
            margin-bottom: 0.8rem !important; /* Reducido de 1rem */
            font-size: clamp(1rem, 1.8vw, 1.2rem); /* Reducido */
        }

        /* ===== ESTILO DEL MENSAJE DE ERROR - MÁS COMPACTO ===== */
        .alert-custom {
            font-size: 0.8rem; /* Reducido */
            border-radius: 10px; /* Reducido */
            border: none;
            background-color: #fce4e4;
            color: #922b21;
            padding: 8px 12px; /* Reducido de 10px 15px */
            margin-bottom: 0.8rem; /* Reducido de 1rem */
            display: flex;
            align-items: center;
            gap: 8px; /* Reducido */
            box-shadow: 0 2px 8px rgba(146, 43, 33, 0.1);
            animation: slideIn 0.3s ease-out;
        }

        /* Estilo especial para el mensaje de bloqueo (un poco diferente) */
        .alert-custom.blocked {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-custom i {
            font-size: 1rem; /* Reducido */
            flex-shrink: 0;
        }

        .btn-custom { 
            background-color: var(--bpez-rojo-fuego); 
            color: white; 
            border: none; 
            border-radius: 50px; 
            padding: 8px 16px; /* Reducido de 10px 20px */
            font-weight: 800;
            width: 100%;
            text-transform: uppercase;
            transition: all 0.3s ease;
            font-size: 0.9rem; /* Reducido */
        }

        .btn-custom:hover {
            background-color: #b01b22;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(206, 32, 41, 0.3);
        }

        .input-group {
            flex-wrap: nowrap;
        }

        .input-group-text { 
            background: transparent; 
            border: none; 
            border-bottom: 2px solid #eee; 
            border-radius: 0; 
            color: var(--bpez-azul-alegre);
            padding-left: 0;
            padding-bottom: 6px; /* Reducido de 8px */
        }

        .form-control { 
            border: none; 
            border-bottom: 2px solid #eee; 
            border-radius: 0; 
            padding: 6px 6px; /* Reducido de 8px 8px */
            font-weight: 500;
            font-size: 0.9rem; /* Reducido */
        }

        .form-control:focus { 
            box-shadow: none; 
            border-bottom-color: var(--bpez-azul-alegre);
            outline: none; 
        }
        
        footer { 
            background-color: var(--header-bg-integrado);
            color: var(--bpez-dark-blue);
            border-top: 1px solid rgba(0,0,0,0.1);
            padding: 8px 0; /* Reducido de 10px */
            text-align: center;
            font-size: 0.8rem; /* Reducido */
            flex-shrink: 0;
            width: 100%;
        }

        /* ===== CORRECCIÓN 5: Responsive ajustado ===== */
        @media (max-width: 768px) {
            html, body { 
                overflow: auto; 
                height: auto; 
                min-height: 100vh;
            }
            
            .main-content { 
                padding: 10px; 
                overflow-y: visible;
            }
            
            .login-header-container { 
                flex-direction: column; 
                gap: 8px; /* Reducido */
                margin-bottom: 0.6rem; /* Reducido */
            }
            
            .logo-img { 
                max-height: 80px; /* Reducido */
            }
            
            .header-box { 
                width: 100%;
                font-size: 0.8rem;
                padding: 10px 12px;
                min-height: auto;
            }
            
            .login-card { 
                padding: 1.2rem 1rem; /* Reducido */
                max-width: 100%;
            }
            
            .btn-custom { 
                padding: 8px; 
            }
            
            footer {
                padding: 6px 0;
                font-size: 0.75rem;
            }
        }

        @media (min-width: 768px) and (max-width: 992px) {
            .login-header-container {
                gap: 10px;
            }
            
            .header-box {
                font-size: 0.85rem;
                padding: 10px 18px;
                min-height: 65px;
            }
            
            .login-card {
                max-width: 380px;
                padding: 1.3rem 1.8rem;
            }
            
            .logo-img {
                max-height: 90px;
            }
        }

        @media (min-width: 1400px) {
            .main-content {
                padding: 20px 20px;
            }
            
            .login-header-container {
                max-width: 1100px;
                gap: 20px;
                margin-bottom: 1.2rem;
            }
            
            .header-box {
                font-size: 1.1rem;
                padding: 20px 30px;
                min-height: 100px;
            }
            
            .logo-img {
                max-height: 130px;
            }
            
            .login-card {
                max-width: 450px;
                padding: 2rem 2.2rem;
            }
            
            .btn-custom {
                padding: 12px;
                font-size: 1rem;
            }
            
            footer {
                padding: 12px 0;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 400px) {
            .login-card {
                padding: 1rem 0.8rem;
            }
            
            .header-box {
                font-size: 0.7rem;
                padding: 8px 10px;
            }
            
            .user-icon {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="container d-flex flex-column align-items-center">
        
        <!-- ===== HEADER CON LOGO Y TÍTULO ===== -->
        <div class="login-header-container">
            <!-- Ruta del logo actualizada (desde la raíz) -->
            <img src="/assets/img/logo.png" alt="Logo BPEZ" class="logo-img">
            <div class="header-box">
                Bienvenido(a) al Sistema de Intranet de la Biblioteca Pública del Estado Zulia "María Calcaño"
            </div>
        </div>

        <!-- ===== TARJETA DE LOGIN ===== -->
        <div class="login-card text-center">
            <i class="fas fa-user-circle user-icon"></i>
            <h4 class="fw-bold" style="color: var(--bpez-dark-blue);">Iniciar Sesión</h4>
            
            <!-- ===== MENSAJE DE ERROR INTEGRADO ===== -->
            <?php if (!empty($error_msg)): ?>
                <div class="alert-custom <?php echo (strpos($error_msg, 'Demasiados') !== false) ? 'blocked' : ''; ?>">
                    <i class="fas <?php echo (strpos($error_msg, 'Demasiados') !== false) ? 'fa-clock' : 'fa-exclamation-triangle'; ?>"></i>
                    <div><?php echo $error_msg; ?></div>
                </div>
            <?php endif; ?>

            <!-- ===== FORMULARIO DE LOGIN ===== -->
            <form action="/modules/login_backend/login_backend.php" method="POST" id="loginForm">
                <!-- Campo de cédula -->
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                    <input type="text" name="cedula" id="cedula" class="form-control" 
                        placeholder="Número de Cédula (7-8 dígitos)" required 
                        pattern="[0-9]{7,8}" maxlength="8" 
                        title="La cédula debe tener 7 u 8 dígitos numéricos">
                </div>
                
                <!-- Campo de contraseña con toggle -->
                <div class="input-group mb-2">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" id="passwordField" class="form-control" placeholder="Contraseña" required
                           minlength="9" maxlength="50" pattern="[a-zA-Z0-9.*#]{9,50}" title="Mínimo 9 caracteres. Solo letras, números, . * #">
                    <span class="input-group-text" style="cursor: pointer;" onclick="togglePassword()">
                        <i class="fas fa-eye" id="eyeIcon"></i>
                    </span>
                </div>
                
                <!-- Enlace "¿Olvidó su contraseña?" -->
                <div class="text-end mb-2">
                    <a href="/assets/frontend/olvido_contrasena_frontend.php" style="color: var(--bpez-dark-blue); text-decoration: none; font-size: 0.8rem; font-weight: 600;">¿Olvidó su contraseña?</a>
                </div>
                
                <!-- Botón de envío -->
                <button type="submit" class="btn btn-custom">INGRESAR</button>
            </form>

        </div>
    </div>
</div>

<!-- ===== FOOTER INCLUIDO ===== -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>

<!-- ===== SCRIPTS LOCALES ===== -->
<!-- Bootstrap JS (ya incluido en offline_assets.php, pero lo dejamos por si acaso) -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<!-- Animación de fondo -->
<script src="/assets/js/background-animation.js"></script>

<script>
    // Función para mostrar/ocultar contraseña
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

    // Validación adicional en el envío del formulario
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const cedula = document.getElementById('cedula').value;
        const password = document.getElementById('passwordField').value;
        
        // Validar cédula: solo números, mínimo 7, máximo 8 dígitos
        if (!/^[0-9]{7,8}$/.test(cedula)) {
            e.preventDefault(); // Detiene el envío
            alert('La cédula debe tener 7 u 8 dígitos numéricos');
            return false;
        }
        
        // Validar contraseña: mínimo 9 caracteres, solo letras, números, . * #
        if (!/^[a-zA-Z0-9.*#]{9,}$/.test(password)) {
            e.preventDefault(); // Detiene el envío
            alert('La contraseña debe tener mínimo 9 caracteres y solo puede contener letras, números, . * #');
            return false;
        }
    });

    // Prevenir que el usuario escriba caracteres no permitidos en cédula
    document.getElementById('cedula').addEventListener('keypress', function(e) {
        // Permitir solo números (0-9) y teclas de control (backspace, tab, enter, etc.)
        const charCode = e.which ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            e.preventDefault();
        }
    });

    // Prevenir que el usuario escriba caracteres no permitidos en contraseña
    document.getElementById('passwordField').addEventListener('keypress', function(e) {
        const char = String.fromCharCode(e.which);
        // Permitir letras, números, . * # y teclas de control
        if (!/^[a-zA-Z0-9.*#]$/.test(char) && e.which > 31) {
            e.preventDefault();
        }
    });
</script>

</body>
</html>