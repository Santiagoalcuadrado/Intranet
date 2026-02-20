<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresando... - Intranet BPEZ 2026</title>
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
            animation: fadeInPage 1s ease-out;
        }

        @keyframes fadeInPage {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .main-content { 
            flex: 1 0 auto; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            justify-content: center; 
            padding: 40px 10px;
            position: relative;
            z-index: 1;
        }
        
        /* CABECERA ESTANDARIZADA */
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
            filter: drop-shadow(0 8px 20px rgba(0,0,0,0.15));
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

        /* STATUS CONTAINER CON GLASSMORPHISM */
        .status-container { 
            max-width: 500px; 
            width: 100%;
            text-align: center; 
        }
        
        .msg-box { 
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 25px;
            color: var(--bpez-dark-blue);
            font-weight: 800;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 51, 102, 0.1);
            border-left: 8px solid var(--bpez-azul-alegre);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .shield-wrapper { 
            position: relative; 
            display: inline-block; 
            color: var(--bpez-rojo-fuego); 
            margin-bottom: 20px;
            animation: pulseShield 2s infinite ease-in-out;
        }

        @keyframes pulseShield {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .shield-icon { font-size: 110px; filter: drop-shadow(0 5px 15px rgba(206, 32, 41, 0.3)); }
        
        .check-overlay { 
            position: absolute; top: 55%; left: 50%; 
            transform: translate(-50%, -50%); 
            font-size: 40px; color: white; 
        }

        /* LOADER DYNAMICS */
        .loader-dots span {
            width: 12px; height: 12px; margin: 0 4px; 
            background-color: var(--bpez-azul-alegre);
            border-radius: 50%; display: inline-block;
            animation: bounce 1.4s infinite ease-in-out both;
        }
        .loader-dots span:nth-child(1) { animation-delay: -0.32s; }
        .loader-dots span:nth-child(2) { animation-delay: -0.16s; }

        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1.0); }
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .logo-img { height: 140px; }
            .shield-icon { font-size: 80px; }
            .check-overlay { font-size: 30px; }
        }
    </style>
</head>
<body>

<div class="main-content">
    <div class="login-header-container">
        <img src="../assets/img/logo.png" alt="Logo BPEZ" class="logo-img">
        <div class="header-box">
            Bienvenido/a a la Intranet de la Biblioteca Pública del Estado Zulia
        </div>
    </div>

    <div class="status-container">
        <div class="msg-box">
            <i class="fas fa-check-circle me-2" style="color: #28a745;"></i> 
            ¡Ingreso exitoso! Preparando su espacio de trabajo...
        </div>

        <div class="shield-wrapper">
            <i class="fas fa-shield-halved shield-icon"></i>
            <i class="fas fa-check check-overlay"></i>
        </div>

        <div class="loader-dots my-4">
            <span></span><span></span><span></span><span></span><span></span>
        </div>
        
        <p class="text-muted small fw-bold">Redirigiendo automáticamente...</p>
    </div>
</div>

<?php include '../includes/footer.php'; ?>

<script src="../assets/js/background-animation.js"></script>

<script>
    // Redirigir automáticamente tras 3.5 segundos
    setTimeout(() => {
        // Ajustado a tu ruta de frontend principal
        window.location.href = "../assets/frontend/principal_frontend.php"; 
    }, 3500);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>