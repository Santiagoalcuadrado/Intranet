<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3;url=assets/frontend/login_frontend.php">
    <title>Bienvenido/a | Intranet BPEZ</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo: #CE2029;
            --bpez-azul: #003366;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .welcome-container {
            text-align: center;
            padding: 20px;
        }

        .logo-welcome {
            /* RUTA DE IMAGEN: Entra a assets/img/ desde la raíz */
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

        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body>

<div class="welcome-container">
    <img src="assets/img/logo.png" alt="Logo BPEZ" class="logo-welcome">
    
    <h1 class="welcome-title">
        Bienvenido/a a la Intranet de la <br class="d-none d-md-block"> 
        Biblioteca Pública del Estado Zulia
    </h1>
    
    <h2 class="welcome-subtitle">"María Calcaño"</h2>
    
    <div class="custom-loader"></div>
    
    <p class="mt-4 text-muted small fw-bold">
        Iniciando Plataforma de Gestión Integral 2026
    </p>
</div>
<script src="/assets/js/background-animation.js"></script>

</body>
</html>