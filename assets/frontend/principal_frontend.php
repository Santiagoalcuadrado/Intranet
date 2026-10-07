<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal - Intranet BPEZ</title>
    
    <!-- ===== RECURSOS OFFLINE (MODULAR) ===== -->
    <!-- Incluye Bootstrap CSS, Font Awesome y Montserrat local -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/offline_assets.php'; ?>
    
    <!-- ===== FAVICONS (MODULAR) ===== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/favicon.php'; ?>

    <style>
        /* ===== VARIABLES GLOBALES DE COLORES ===== */
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo-fuego: #CE2029;
            --bpez-dark-blue: #003366; 
            --bpez-azul-alegre: #0077B6;
            --header-bg-integrado: #e0f2f1;
            --navbar-height: 130px;
        }

        /* ===== ESTRUCTURA BASE ===== */
        html, body { 
            height: 100%;                   
            margin: 0; 
            overflow: auto;                  
        }
        
        body { 
            display: flex;                   
            flex-direction: column; 
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            color: #333;
        }

        /* ===== CONTENEDOR PRINCIPAL ===== */
        .main-content { 
            flex: 1;                          
            display: flex;
            flex-direction: column;
            padding: calc(var(--navbar-height) + 10px) 20px 10px 20px;
            overflow: auto;
        }

        /* ===== SECCIÓN 1: SALUDO Y FECHA ===== */
        .welcome-section { 
            text-align: center; 
            margin-bottom: 10px;
            flex-shrink: 0;
        }
        
        .welcome-section h2 {
            font-size: clamp(1.2rem, 2vw, 1.5rem);
            margin-bottom: 2px !important;
            color: var(--bpez-dark-blue);
            font-weight: 700;
        }
        
        .welcome-section p {
            font-size: clamp(0.8rem, 1.2vw, 0.9rem);
            margin-bottom: 5px;
        }

        /* ===== SECCIÓN 2: TARJETA INSTITUCIONAL ===== */
        .info-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 18px 25px;
            margin: 5px auto 15px auto;
            max-width: 1000px;
            width: 90%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); 
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 6px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
            flex-shrink: 0;
        }

        .info-card:hover {
            transform: scale(1.008);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .info-card p {
            font-size: clamp(0.75rem, 1.1vw, 0.9rem);
            line-height: 1.6;
            color: var(--bpez-dark-blue);
            font-weight: 550;
            text-align: center;
            margin-bottom: 0;
            text-shadow: 0px 1px 3px rgba(255, 255, 255, 0.9); 
        }

        .info-card p i {
            color: var(--bpez-rojo-fuego);
            margin-right: 5px;
            text-shadow: 0px 1px 2px rgba(255, 255, 255, 0.7);
        }

        /* ===== MEDIA QUERIES - RESPONSIVE PARA EL CONTENIDO PRINCIPAL ===== */
        @media (max-width: 1200px) {
            .main-content {
                padding: calc(90px + 10px) 20px 10px 20px;
            }
        }

        @media (max-width: 992px) {
            .main-content {
                padding: calc(80px + 15px) 15px 15px 15px;
            }
            .info-card {
                width: 95%;
                padding: 15px 20px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: calc(120px + 10px) 15px 20px 15px;
            }
            .welcome-section h2 {
                font-size: 1.1rem;
            }
            .info-card {
                padding: 12px 15px;
                margin: 5px auto 10px auto;
            }
            .info-card p {
                font-size: 0.7rem;
                line-height: 1.4;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: calc(140px + 5px) 10px 30px 10px;
                overflow: auto;
            }
            .info-card {
                width: 100%;
                padding: 10px 12px;
            }
        }

        /* ===== ESTILOS MEJORADOS PARA MENSAJE DE ERROR ===== */
        /* ===== Totalmente centrado y responsive ===== */
        .mensaje-error-container {
            position: fixed;
            top: calc(var(--navbar-height) + 10px); /* Justo debajo del navbar */
            left: 0;
            right: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            z-index: 9999;
            pointer-events: none; /* Permite hacer clic a través del contenedor */
            padding: 0 15px; /* Padding lateral para móviles */
            animation: slideDown 0.5s ease forwards;
        }

        .mensaje-error-contenido {
            background: linear-gradient(135deg, rgba(206, 32, 41, 0.98), rgba(206, 32, 41, 0.9));
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-left: 6px solid #ffffff;
            border-radius: 50px; /* Bordes más redondeados */
            padding: 14px 25px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 15px 35px rgba(206, 32, 41, 0.4);
            color: white;
            font-weight: 600;
            font-size: clamp(0.85rem, 2.5vw, 1rem);
            max-width: 600px;
            width: 100%;
            pointer-events: auto; /* El contenido sí puede recibir clics si es necesario */
            transition: all 0.3s ease;
        }

        .mensaje-error-contenido i {
            font-size: 1.6rem;
            color: white;
            flex-shrink: 0;
        }

        .mensaje-error-contenido span {
            flex: 1;
            text-align: center;
            line-height: 1.5;
        }

        /* Animación de entrada */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animación de salida */
        @keyframes fadeOutUp {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-30px);
            }
        }

        .mensaje-error-container.oculto {
            animation: fadeOutUp 0.5s ease forwards;
        }

        /* ===== RESPONSIVE ESPECÍFICO PARA EL MENSAJE ===== */
        @media (max-width: 768px) {
            .mensaje-error-container {
                top: calc(var(--navbar-height) - 20px); /* Ajuste para móvil */
            }
            
            .mensaje-error-contenido {
                padding: 12px 20px;
                border-radius: 40px;
                gap: 12px;
            }
            
            .mensaje-error-contenido i {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 576px) {
            .mensaje-error-container {
                top: calc(var(--navbar-height) - 30px); /* Ajuste para móvil pequeño */
                padding: 0 10px;
            }
            
            .mensaje-error-contenido {
                padding: 10px 16px;
                border-radius: 30px;
                gap: 10px;
            }
            
            .mensaje-error-contenido i {
                font-size: 1.3rem;
            }
            
            .mensaje-error-contenido span {
                font-size: 0.8rem;
            }
        }

        /* ===== RESPONSIVE PARA PANTALLAS MUY GRANDES (TV) ===== */
        @media (min-width: 1400px) {
            .mensaje-error-container {
                top: calc(var(--navbar-height) + 20px);
            }
            
            .mensaje-error-contenido {
                max-width: 700px;
                padding: 18px 35px;
                font-size: 1.2rem;
                border-left-width: 8px;
            }
            
            .mensaje-error-contenido i {
                font-size: 2rem;
            }
        }

        @media (min-width: 1900px) {
            .mensaje-error-container {
                top: calc(var(--navbar-height) + 30px);
            }
            
            .mensaje-error-contenido {
                max-width: 800px;
                padding: 22px 45px;
                font-size: 1.4rem;
            }
            
            .mensaje-error-contenido i {
                font-size: 2.4rem;
            }
        }
    </style>
</head>
<body>

<!-- ===== NAVBAR INCLUIDO ===== -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

<?php
// ===== CAPTURAR MENSAJES DE ERROR DESDE LA URL =====
// Esta sección captura el parámetro 'error' en la URL (ej: ?error=acceso_denegado)
// y muestra un mensaje personalizado según el tipo de error
$error = $_GET['error'] ?? '';
$mensaje_error = '';

if ($error === 'acceso_denegado') {
    $mensaje_error = '⛔ No tienes permisos suficientes para acceder a esta pantalla.';
}
?>

<!-- ===== MENSAJE DE ERROR MEJORADO ===== -->
<!-- Totalmente centrado, responsive y con animación -->
<?php if (!empty($mensaje_error)): ?>
<div id="mensajeError" class="mensaje-error-container">
    <div class="mensaje-error-contenido">
        <i class="fas fa-exclamation-triangle"></i>
        <span><?php echo $mensaje_error; ?></span>
    </div>
</div>
<?php endif; ?>

<!-- ===== CONTENIDO PRINCIPAL ===== -->
<div class="main-content">
    
    <!-- ===== SECCIÓN 1: SALUDO Y FECHA ===== -->
    <div class="container welcome-section px-0">
        <h2 class="fw-800">
            ¡<span id="txt-saludo">Hola</span>, <?php echo $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido'];?>!
        </h2>
        <p class="text-muted fw-500">
            <i class="far fa-calendar-check me-2 text-primary"></i>
            Hoy es <span id="txt-fecha" class="text-capitalize"></span>
        </p>
    </div>

    <!-- ===== SECCIÓN 2: TARJETA INSTITUCIONAL ===== -->
    <div class="info-card">
        <p>
            <i class="fas fa-quote-left"></i> 
            Plataforma de Gestión Integral para el conocimiento del marco legal y normativo de la administración pública venezolana, los lineamientos nacionales sobre el libro, la lectura y las bibliotecas, la inducción del personal en sus funciones, procesos y procedimientos, la eficiencia en el trabajo colaborativo, el desarrollo de proyectos, la capacitación del recurso humano y los resultados del desempeño. En cumplimiento con los requisitos de certificación en gestión de la calidad establecidos por la Norma ISO 9001 y FONDONORMA.
            <i class="fas fa-quote-right"></i>
        </p>
    </div>
</div>

<!-- ===== FOOTER INCLUIDO ===== -->
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>

<!-- ===== SCRIPTS LOCALES ===== -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/background-animation.js"></script>

<!-- ===== JAVASCRIPT FUNCIONAL ===== -->
<script>
// Función para configurar el saludo y la fecha según la hora del día
function configurarBienvenida() {
    const ahora = new Date();
    const hora = ahora.getHours();
    
    let saludo = "Buen día";
    if (hora >= 12 && hora < 18) saludo = "Buenas tardes";
    if (hora >= 18 || hora < 5) saludo = "Buenas noches";
    
    const opciones = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
    document.getElementById('txt-saludo').innerText = saludo;
    document.getElementById('txt-fecha').innerText = ahora.toLocaleDateString('es-ES', opciones);
}

// ===== AUTO-CERRAR MENSAJE DE ERROR DESPUÉS DE 3 SEGUNDOS =====
// Esta función busca el mensaje de error y lo oculta con animación después de 3 segundos
document.addEventListener('DOMContentLoaded', function() {
    configurarBienvenida();
    
    const mensaje = document.getElementById('mensajeError');
    if (mensaje) {
        setTimeout(() => {
            mensaje.classList.add('oculto'); // Aplica la animación de salida
            setTimeout(() => {
                mensaje.style.display = 'none'; // Oculta completamente después de la animación
            }, 500); // 500ms = duración de la animación
        }, 3000); // 3000ms = 3 segundos visibles
    }
});
</script>
</body>
</html>