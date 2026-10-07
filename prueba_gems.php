<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sandbox Gemini Gems - BPEZ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --gemini-gradient: linear-gradient(135deg, #4285f4, #9b72cb, #d96570);
            --bg-dark: #0a0c10;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: var(--bg-dark);
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(66, 133, 244, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(155, 114, 203, 0.1) 0%, transparent 40%);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: white;
            overflow: hidden;
        }

        .test-card {
            text-align: center;
            padding: 50px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 30px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            max-width: 500px;
        }

        .gem-icon {
            font-size: 80px;
            background: var(--gemini-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
            animation: pulse 3s infinite;
        }

        h1 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }

        p {
            color: #8892b0;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn-launch {
            background: var(--gemini-gradient);
            color: white;
            border: none;
            padding: 18px 45px;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            box-shadow: 0 10px 25px rgba(155, 114, 203, 0.3);
        }

        .btn-launch:hover {
            transform: scale(1.05) translateY(-5px);
            box-shadow: 0 15px 35px rgba(155, 114, 203, 0.5);
        }

        .btn-launch:active {
            transform: scale(0.98);
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); opacity: 0.8; }
        }

        /* Indicador de ayuda */
        .hint {
            margin-top: 25px;
            font-size: 0.8rem;
            color: #465069;
        }
    </style>
</head>
<body>

    <div class="test-card">
        <i class="fas fa-gem gem-icon"></i>
        <h1>Gemini Gems Tester</h1>
        <p>Esta es una pantalla aislada para verificar la apertura de la ventana flotante de tus Gems configurados.</p>
        
        <button class="btn-launch" onclick="testGemsWindow()">
            <i class="fas fa-rocket"></i> Probar Conexión
        </button>

        <div class="hint">
            <i class="fas fa-info-circle"></i> La ventana se abrirá centrada y con dimensiones de asistente.
        </div>
    </div>

    <script>
        function testGemsWindow() {
            // URL de prueba: Puedes poner el link directo a tu Gema aquí
            const urlGem = "https://gemini.google.com/gem/no-sirvio-en-ese-entonces-prueba-tu-de-todas-formas"; 
            
            // Dimensiones óptimas para que parezca un panel lateral/flotante
            const width = 550;
            const height = 800;
            
            // Calcular posición centrada
            const left = (window.screen.width / 2) - (width / 2);
            const top = (window.screen.height / 2) - (height / 2);

            // Ejecutar apertura
            const gemsWindow = window.open(
                urlGem, 
                "GemsTestWindow", 
                `width=${width},height=${height},top=${top},left=${left},resizable=yes,scrollbars=yes,status=no,location=no,toolbar=no,menubar=no`
            );

            if (!gemsWindow || gemsWindow.closed || typeof gemsWindow.closed == 'undefined') {
                alert("¡Ups! El bloqueador de ventanas emergentes está activo. Por favor, permite los pop-ups para esta prueba.");
            }
        }
    </script>

</body>
</html>