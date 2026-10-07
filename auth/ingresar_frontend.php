<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresando... - Intranet BPEZ</title>
    
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

        /* Tus estilos existentes - no los modifico */
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
            animation: fadeInPage 1s ease-out;
        }

        @keyframes fadeInPage {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .main-content { 
            flex: 1;
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            padding: 15px 20px;
            overflow: hidden;
        }
        
        .login-header-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 1.5rem;
            max-width: 900px;
            width: 100%;
        }

        .logo-img { 
            height: auto;
            width: auto;
            max-height: 110px;
            max-width: 100%;
            object-fit: contain; 
            filter: drop-shadow(0 8px 20px rgba(0,0,0,0.15));
            align-self: center;
            transition: all 0.4s ease;
        }

        .header-box { 
            background-color: var(--header-bg-integrado);
            padding: 10px 20px; 
            border-radius: 15px;
            color: var(--bpez-dark-blue);
            font-weight: 700;
            font-size: clamp(0.75rem, 1.1vw, 0.9rem);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border-bottom: 4px solid var(--bpez-rojo-fuego);
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            min-height: 50px;
            line-height: 1.2;
        }

        .status-container { 
            max-width: 450px;
            width: 100%;
            text-align: center; 
        }
        
        .msg-box { 
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 18px 20px;
            color: var(--bpez-dark-blue);
            font-weight: 700;
            margin-bottom: 1.5rem;
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.1);
            border-left: 6px solid var(--bpez-azul-alegre);
            animation: slideUp 0.6s ease-out;
            font-size: 0.95rem;
        }

        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .shield-wrapper { 
            position: relative; 
            display: inline-block; 
            color: var(--bpez-rojo-fuego); 
            margin-bottom: 1rem;
            animation: pulseShield 2s infinite ease-in-out;
        }

        @keyframes pulseShield {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .shield-icon { 
            font-size: 90px;
            filter: drop-shadow(0 5px 15px rgba(206, 32, 41, 0.3)); 
        }
        
        .check-overlay { 
            position: absolute; 
            top: 55%; 
            left: 50%; 
            transform: translate(-50%, -50%); 
            font-size: 32px;
            color: white; 
        }

        .loader-dots {
            margin: 1rem 0 0.5rem 0;
        }
        
        .loader-dots span {
            width: 10px;
            height: 10px;
            margin: 0 3px;
            background-color: var(--bpez-azul-alegre);
            border-radius: 50%; 
            display: inline-block;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .loader-dots span:nth-child(1) { animation-delay: -0.32s; }
        .loader-dots span:nth-child(2) { animation-delay: -0.16s; }

        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1.0); }
        }

        p.text-muted {
            font-size: 0.75rem;
            margin-top: 0.5rem;
            margin-bottom: 0;
        }

        footer { 
            background-color: var(--header-bg-integrado);
            color: var(--bpez-dark-blue);
            border-top: 1px solid rgba(0,0,0,0.1);
            padding: 10px 0;
            text-align: center;
            font-size: 0.8rem;
            flex-shrink: 0;
            width: 100%;
        }

        @media (max-width: 768px) {
            html, body { 
                overflow: auto; 
                height: auto; 
                min-height: 100vh;
            }
            
            .main-content { 
                padding: 15px 15px; 
                overflow-y: visible;
            }
            
            .login-header-container { 
                flex-direction: column; 
                gap: 10px; 
                margin-bottom: 1.5rem;
                max-width: 100%;
            }
            
            .logo-img { 
                max-height: 90px; 
            }
            
            .header-box { 
                width: 100%;
                font-size: 0.7rem;
                padding: 8px 15px;
                min-height: 45px;
            }
            
            .status-container {
                max-width: 100%;
                padding: 0 10px;
            }
            
            .shield-icon { 
                font-size: 70px; 
            }
            
            .check-overlay { 
                font-size: 26px; 
            }
            
            .msg-box {
                padding: 15px;
                font-size: 0.85rem;
            }
            
            footer {
                padding: 8px 0;
                font-size: 0.75rem;
            }
        }

        @media (min-width: 768px) and (max-width: 992px) {
            .login-header-container {
                max-width: 700px;
            }
            
            .status-container {
                max-width: 400px;
            }
        }

        @media (min-width: 1400px) {
            .main-content {
                padding: 20px 20px;
            }
            
            .login-header-container {
                max-width: 1000px;
                gap: 20px;
                margin-bottom: 2rem;
            }
            
            .header-box {
                font-size: 1rem;
                padding: 12px 25px;
                min-height: 60px;
            }
            
            .logo-img {
                max-height: 130px;
            }
            
            .status-container {
                max-width: 500px;
            }
            
            .shield-icon {
                font-size: 100px;
            }
            
            .msg-box {
                padding: 20px 25px;
                font-size: 1rem;
            }
            
            footer {
                padding: 12px 0;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="main-content">
    <!-- HEADER CON LOGO Y TEXTO PERSONALIZADO CON NOMBRE DEL USUARIO -->
    <div class="login-header-container">
        <!-- Ruta del logo corregida (desde la raíz) -->
        <img src="/assets/img/logo.png" alt="Logo BPEZ" class="logo-img">
        <div class="header-box">
            <?php 
            $nombre_mostrar = $_SESSION['nombre_para_mostrar'] ?? 'Bienvenido(a)';
            echo htmlspecialchars($nombre_mostrar); 
            ?>, Bienvenido(a) a la Intranet de la Biblioteca Pública del Estado Zulia...
        </div>
    </div>

    <!-- CONTENEDOR PRINCIPAL COMPACTO -->
    <div class="status-container">
        <div class="msg-box">
            <i class="fas fa-check-circle me-2" style="color: #28a745;"></i> 
            ¡Ingreso exitoso! Preparando su espacio de trabajo...
        </div>

        <div class="shield-wrapper">
            <i class="fas fa-shield-halved shield-icon"></i>
            <i class="fas fa-check check-overlay"></i>
        </div>

        <div class="loader-dots">
            <span></span><span></span><span></span><span></span><span></span>
        </div>
        
        <p class="text-muted small fw-bold">Redirigiendo automáticamente...</p>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>

<!-- ===== SCRIPTS LOCALES ===== -->
<script src="/assets/js/background-animation.js"></script>
<script src="/assets/js/bootstrap.bundle.min.js"></script>

<script>
    // Redirigir automáticamente tras 3.5 segundos
    setTimeout(() => {
        window.location.href = "/modules/principal_backend/principal_backend.php"; 
    }, 3500);
</script>

</body>
</html>