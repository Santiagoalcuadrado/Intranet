<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- REDIRECCIÓN AUTOMÁTICA: Redirige al login después de 3 segundos -->
    <meta http-equiv="refresh" content="3;url=assets/frontend/login_frontend.php">
    <title>Bienvenido(a) | Intranet BPEZ</title>
    
    <!-- ===== RECURSOS OFFLINE (MODULAR) ===== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/offline_assets.php'; ?>
    
    <!-- ===== FAVICONS (MODULAR) ===== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/favicon.php'; ?>    
    
    <style>
        /* ===== VARIABLES GLOBALES ===== */
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo: #CE2029;
            --bpez-azul: #003366;
        }

        /* ===== ESTRUCTURA BASE ===== */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .welcome-container {
            text-align: center;
            padding: 20px;
            max-width: 1200px;
            width: 100%;
        }

        .logo-welcome {
            width: clamp(120px, 15vw, 250px);
            height: auto;
            margin-bottom: 30px;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
            animation: fadeInDown 1.2s ease-out;
        }

        .welcome-title {
            color: var(--bpez-azul);
            font-weight: 800;
            font-size: clamp(1.2rem, 4vw, 3rem);
            margin-bottom: 15px;
            animation: fadeInUp 1s ease-out;
        }

        .welcome-subtitle {
            color: var(--bpez-rojo);
            font-weight: 600;
            font-size: clamp(0.9rem, 2vw, 1.5rem);
            text-transform: uppercase;
            animation: fadeInUp 1.3s ease-out;
        }

        .custom-loader {
            width: 45px;
            height: 45px;
            border: 5px solid rgba(0, 51, 102, 0.1);
            border-top: 5px solid var(--bpez-rojo);
            border-radius: 50%;
            display: inline-block;
            animation: spin 1s linear infinite;
            margin-top: 30px;
        }

        @keyframes spin { 
            0% { transform: rotate(0deg); } 
            100% { transform: rotate(360deg); } 
        }
        
        @keyframes fadeInUp { 
            from { opacity: 0; transform: translateY(20px); } 
            to { opacity: 1; transform: translateY(0); } 
        }
        
        @keyframes fadeInDown { 
            from { opacity: 0; transform: translateY(-20px); } 
            to { opacity: 1; transform: translateY(0); } 
        }

        @media (max-width: 480px) {
            .welcome-container { padding: 15px; }
            .logo-welcome { margin-bottom: 20px; }
            .custom-loader {
                width: 35px;
                height: 35px;
                border-width: 4px;
                margin-top: 20px;
            }
            .text-muted { font-size: 0.7rem; }
        }

        @media (min-width: 1400px) {
            .logo-welcome { width: 300px; }
            .welcome-title { font-size: 3.5rem; }
            .welcome-subtitle { font-size: 2rem; }
            .custom-loader {
                width: 60px;
                height: 60px;
                border-width: 6px;
            }
        }
    </style>
</head>
<body>

<div class="welcome-container">
    <img src="assets/img/logo.png" alt="Logo BPEZ" class="logo-welcome">
    
    <h1 class="welcome-title">
        Bienvenido(a) al Sistema de Intranet de la <br class="d-none d-md-block"> 
        Biblioteca Pública del Estado Zulia
    </h1>
    
    <h2 class="welcome-subtitle">"María Calcaño"</h2>
    
    <div class="custom-loader"></div>
    
    <p class="mt-4 text-muted small fw-bold">
        Iniciando Plataforma de Gestión Integral 2026
    </p>
</div>

<!-- ===== SCRIPTS ===== -->
<script src="/assets/js/background-animation.js"></script>
<!-- Bootstrap JS ya está incluido en offline_assets.php -->

</body>
</html>