<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Intranet BPEZ</title>
    
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

        /* ===== CONTENEDOR PRINCIPAL CON PADDING PARA NAVBAR ===== */
        .main-content { 
            flex: 1;
            padding: calc(var(--navbar-height) + 20px) 20px 40px 20px;
        }

        /* ===== TARJETA DE PERFIL - ESTILO VIDRIO BLANCO ===== */
        .profile-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 50px 40px 40px 40px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            max-width: 1200px;
            margin: 20px auto;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-top: 6px solid var(--bpez-azul-alegre);
            position: relative;
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        /* ===== ÍCONO FLOTANTE ===== */
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
            border: 4px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 5px 15px rgba(0, 51, 102, 0.2);
            backdrop-filter: blur(5px);
        }

        /* ===== ETIQUETAS DE INFORMACIÓN ===== */
        .info-label { 
            font-weight: 700; 
            color: var(--bpez-dark-blue); 
            font-size: 0.8rem; 
            text-transform: uppercase; 
            margin-bottom: 5px;
            letter-spacing: 0.5px;
        }

        .info-label i {
            color: var(--bpez-azul-alegre);
            width: 20px;
        }

        .info-value { 
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
            padding: 8px 0 8px 25px; 
            font-weight: 500; 
            color: var(--bpez-dark-blue);
            margin-bottom: 20px;
            font-size: 0.95rem;
            word-break: break-word;
        }

        /* ===== CAMPOS DE CONTRASEÑA (solo visibles en edición) ===== */
        .password-group {
            display: flex;
            align-items: center;
            border-bottom: 2px solid rgba(255, 255, 255, 0.3);
            padding: 4px 0 4px 25px;
            margin-bottom: 20px;
        }

        .password-input {
            border: none;
            background: transparent;
            width: 100%;
            padding: 4px 0;
            font-weight: 500;
            color: var(--bpez-dark-blue);
            font-size: 0.95rem;
            outline: none;
        }

        .password-input::placeholder {
            color: rgba(0, 51, 102, 0.4);
            font-style: italic;
        }

        .password-toggle {
            background: transparent;
            border: none;
            color: var(--bpez-azul-alegre);
            cursor: pointer;
            padding: 0 5px;
            font-size: 1rem;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: var(--bpez-dark-blue);
        }

        /* ===== TAGS DE FECHA DE MODIFICACIÓN ===== */
        .modificacion-tag { 
            font-size: 0.7rem; 
            color: rgba(0, 51, 102, 0.6);
            font-style: italic; 
            display: block;
            margin-top: -15px;
            margin-bottom: 20px;
            padding-left: 25px;
            border-left: 2px solid var(--bpez-azul-alegre);
        }

        .modificacion-tag i {
            color: var(--bpez-azul-alegre);
            margin-right: 5px;
            font-size: 0.65rem;
        }

        /* ===== SELECT PERSONALIZADO ===== */
        .edit-select {
            border: none;
            background: rgba(255, 255, 255, 0.2);
            width: 100%;
            padding: 8px 0 8px 25px;
            font-weight: 500;
            color: var(--bpez-dark-blue);
            font-size: 0.95rem;
            outline: none;
            border-bottom: 2px solid var(--bpez-azul-alegre);
            transition: border-color 0.3s;
            margin-bottom: 20px;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%230077B6' viewBox='0 0 16 16'><path d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/></svg>");
            background-repeat: no-repeat;
            background-position: calc(100% - 10px) center;
            background-size: 16px;
            cursor: pointer;
        }

        .edit-select:focus {
            border-bottom-color: var(--bpez-dark-blue);
            background-color: rgba(255, 255, 255, 0.3);
        }

        .edit-select.is-invalid {
            border-bottom-color: var(--bpez-rojo-fuego) !important;
        }

        .edit-select option {
            background: rgba(255, 255, 255, 0.9);
            color: var(--bpez-dark-blue);
        }

        /* ===== CHECKBOX PERSONALIZADO ===== */
        .custom-checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            cursor: pointer;
        }
        
        .custom-checkbox input {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            cursor: pointer;
            accent-color: var(--bpez-azul-alegre);
        }
        
        .custom-checkbox label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--bpez-dark-blue);
            cursor: pointer;
        }

        /* ===== SECCIÓN DE PREGUNTAS DESHABILITADA ===== */
        .preguntas-disabled {
            opacity: 0.6;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        
        .preguntas-enabled {
            opacity: 1;
            pointer-events: all;
            transition: opacity 0.3s ease;
        }

        /* ===== VALIDACIÓN VISUAL ===== */
        .is-invalid {
            border-bottom-color: var(--bpez-rojo-fuego) !important;
        }

        .error-message {
            color: var(--bpez-rojo-fuego);
            font-size: 0.7rem;
            margin-top: -15px;
            margin-bottom: 10px;
            padding-left: 25px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        /* ===== BOTONES DE ACCIÓN ===== */
        .btn-action { 
            border-radius: 50px; 
            padding: 12px 30px; 
            font-weight: 700; 
            text-transform: uppercase; 
            transition: all 0.3s ease; 
            border: none;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            margin: 5px;
        }

        .btn-edit { 
            background: rgba(0, 119, 182, 0.15);
            backdrop-filter: blur(5px);
            color: var(--bpez-azul-alegre);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .btn-edit:hover { 
            background: rgba(0, 119, 182, 0.25);
            color: var(--bpez-dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 119, 182, 0.15);
        }

        .btn-save { 
            background: rgba(0, 51, 102, 0.15);
            backdrop-filter: blur(5px);
            color: var(--bpez-dark-blue);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .btn-save:hover { 
            background: rgba(0, 51, 102, 0.25);
            color: var(--bpez-azul-alegre);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 51, 102, 0.15);
        }

        .btn-cancel { 
            background: rgba(108, 117, 125, 0.15);
            backdrop-filter: blur(5px);
            color: #6c757d;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .btn-cancel:hover { 
            background: rgba(108, 117, 125, 0.25);
            color: var(--bpez-dark-blue);
            transform: translateY(-2px);
        }

        /* ===== CAMPOS EDITABLES ===== */
        .edit-input {
            border: none;
            background: rgba(255, 255, 255, 0.2);
            width: 100%;
            padding: 8px 0 8px 25px;
            font-weight: 500;
            color: var(--bpez-dark-blue);
            font-size: 0.95rem;
            outline: none;
            border-bottom: 2px solid var(--bpez-azul-alegre);
            transition: border-color 0.3s;
            margin-bottom: 20px;
        }

        .edit-input:focus {
            border-bottom-color: var(--bpez-dark-blue);
            background: rgba(255, 255, 255, 0.3);
        }

        .edit-input.is-invalid {
            border-bottom-color: var(--bpez-rojo-fuego) !important;
        }

        /* ===== SEPARADOR ===== */
        .separator {
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            margin: 30px 0 20px 0;
        }

        /* ===== BADGE DE ROL ===== */
        .role-badge {
            background: rgba(0, 119, 182, 0.2);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 5px 15px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--bpez-dark-blue);
            display: inline-block;
            margin-left: 10px;
        }

        .role-badge i {
            color: var(--bpez-azul-alegre);
            margin-right: 5px;
        }

        /* ===== MENSAJES CENTRADOS EN LA CARD ===== */
        .mensaje-centrado {
            width: 100%;
            margin-bottom: 25px;
            animation: fadeInDown 0.5s ease forwards;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeOutUp {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
                display: none;
            }
        }

        .mensaje-centrado.oculto {
            animation: fadeOutUp 0.5s ease forwards;
        }

        .mensaje-contenido-centrado {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .mensaje-error .mensaje-contenido-centrado {
            background: linear-gradient(135deg, rgba(206, 32, 41, 0.25), rgba(206, 32, 41, 0.15));
            border-left: 6px solid var(--bpez-rojo-fuego);
        }

        .mensaje-success .mensaje-contenido-centrado {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.25), rgba(40, 167, 69, 0.15));
            border-left: 6px solid #28a745;
        }

        .mensaje-icono {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .mensaje-error .mensaje-icono {
            color: var(--bpez-rojo-fuego);
            background: rgba(206, 32, 41, 0.2);
        }

        .mensaje-success .mensaje-icono {
            color: #28a745;
            background: rgba(40, 167, 69, 0.2);
        }

        .mensaje-texto {
            flex: 1;
            color: var(--bpez-dark-blue);
            font-weight: 500;
            font-size: 0.95rem;
            line-height: 1.5;
            text-shadow: 0px 1px 2px rgba(255, 255, 255, 0.5);
        }

        .mensaje-cerrar {
            background: transparent;
            border: none;
            color: rgba(0, 51, 102, 0.5);
            cursor: pointer;
            font-size: 1.2rem;
            padding: 0 5px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-left: 10px;
            flex-shrink: 0;
        }

        .mensaje-cerrar:hover {
            background: rgba(255, 255, 255, 0.3);
            color: var(--bpez-dark-blue);
            transform: scale(1.1);
        }

        /* ===== ALERTA INFORMATIVA ===== */
        .alert-info-custom {
            background: rgba(0, 119, 182, 0.15);
            backdrop-filter: blur(5px);
            border-left: 4px solid var(--bpez-azul-alegre);
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            color: var(--bpez-dark-blue);
            font-size: 0.85rem;
        }

        .alert-info-custom i {
            color: var(--bpez-azul-alegre);
            margin-right: 8px;
        }

        .alert-warning-custom {
            background: rgba(206, 32, 41, 0.15);
            backdrop-filter: blur(5px);
            border-left: 4px solid var(--bpez-rojo-fuego);
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            color: var(--bpez-dark-blue);
            font-size: 0.85rem;
        }

        .alert-warning-custom i {
            color: var(--bpez-rojo-fuego);
            margin-right: 8px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .main-content {
                padding: calc(var(--navbar-height) + 15px) 15px 30px 15px;
            }
            .profile-card {
                padding: 45px 30px 30px 30px;
            }
        }

        @media (max-width: 768px) {
            .main-content {
                padding: calc(100px + 15px) 15px 25px 15px;
            }
            .profile-card {
                padding: 45px 20px 25px 20px;
            }
            .info-value, .password-group, .edit-input, .edit-select {
                padding-left: 15px;
                font-size: 0.9rem;
            }
            .modificacion-tag {
                padding-left: 15px;
            }
            .btn-action {
                width: 100%;
                margin: 5px 0 !important;
            }
            .mensaje-centrado {
                margin-bottom: 20px;
            }
            .mensaje-contenido-centrado {
                padding: 12px 15px;
            }
            .mensaje-icono {
                width: 35px;
                height: 35px;
                font-size: 1.3rem;
                margin-right: 10px;
            }
            .mensaje-texto {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .profile-card {
                padding: 45px 15px 20px 15px;
            }
            .profile-icon-top {
                width: 70px;
                height: 70px;
                top: -35px;
            }
            .profile-icon-top i {
                font-size: 1.8rem;
            }
            .edit-select {
                background-position: calc(100% - 5px) center;
            }
        }

        @media (max-width: 400px) {
            .info-label {
                font-size: 0.7rem;
            }
            .info-value, .password-group, .edit-input, .edit-select {
                font-size: 0.85rem;
                padding-left: 10px;
            }
        }

        @media (min-width: 1400px) {
            .profile-card {
                max-width: 1300px;
                padding: 60px 50px 50px 50px;
            }
            .info-label {
                font-size: 0.9rem;
            }
            .info-value, .password-group, .edit-input, .edit-select {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

    <div class="main-content">
        <div class="container">
            <div class="profile-card" id="profileCard">
                <div class="profile-icon-top">
                    <i class="fas fa-user-shield fa-2x"></i>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <h4 class="fw-bold" style="color: var(--bpez-dark-blue);">MI PERFIL DE USUARIO</h4>
                    <span class="role-badge">
                        <i class="fas fa-tag"></i> <?php echo htmlspecialchars($nombre_rol); ?>
                    </span>
                </div>

                <!-- ===== MENSAJES CENTRADOS EN LA CARD ===== -->
                <?php if (isset($error) && $error): ?>
                    <div class="mensaje-centrado mensaje-error" id="mensajeError">
                        <div class="mensaje-contenido-centrado">
                            <div class="mensaje-icono">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div class="mensaje-texto">
                                <?php echo $error; ?>
                            </div>
                            <button type="button" class="mensaje-cerrar" onclick="cerrarMensaje('mensajeError')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($success) && $success): ?>
                    <div class="mensaje-centrado mensaje-success" id="mensajeSuccess">
                        <div class="mensaje-contenido-centrado">
                            <div class="mensaje-icono">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="mensaje-texto">
                                <?php echo $success; ?>
                            </div>
                            <button type="button" class="mensaje-cerrar" onclick="cerrarMensaje('mensajeSuccess')">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- MODO VISUALIZACIÓN (por defecto) - SIN CAMPOS EDITABLES -->
                <div id="viewMode">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-label"><i class="fas fa-user me-2"></i> Nombres</div>
                            <div class="info-value"><?php echo htmlspecialchars($nombre_completo ?: 'No especificado'); ?></div>
                            
                            <div class="info-label"><i class="fas fa-id-card me-2"></i> Cédula</div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['cedula']); ?></div>
                            
                            <!-- TELÉFONO -->
                            <div class="info-label"><i class="fas fa-phone me-2"></i> Teléfono</div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['telefono']); ?></div>
                            <span class="modificacion-tag"><i class="fas fa-clock"></i> Última modificación: <?php echo $usuario['telefono_modificacion'] ? date('d/m/Y H:i', strtotime($usuario['telefono_modificacion'])) : 'Nunca'; ?></span>

                            <!-- EMAIL -->
                            <div class="info-label"><i class="fas fa-envelope me-2"></i> Correo Electrónico</div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['email']); ?></div>
                            <span class="modificacion-tag"><i class="fas fa-clock"></i> Última modificación: <?php echo $usuario['email_modificacion'] ? date('d/m/Y H:i', strtotime($usuario['email_modificacion'])) : 'Nunca'; ?></span>

                            <!-- DIRECCIÓN -->
                            <div class="info-label"><i class="fas fa-map-marker-alt me-2"></i> Dirección</div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['direccion'] ?: 'No especificada'); ?></div>
                            <span class="modificacion-tag"><i class="fas fa-clock"></i> Última modificación: <?php echo $usuario['direccion_modificacion'] ? date('d/m/Y H:i', strtotime($usuario['direccion_modificacion'])) : 'Nunca'; ?></span>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-label"><i class="fas fa-user me-2"></i> Apellidos</div>
                            <div class="info-value"><?php echo htmlspecialchars($apellido_completo ?: 'No especificado'); ?></div>
                            
                            <div class="info-label"><i class="fas fa-calendar-day me-2"></i> Edad / Nacimiento</div>
                            <div class="info-value"><?php echo $edad; ?> años (<?php echo date('d/m/Y', strtotime($usuario['fecha_nacimiento'])); ?>)</div>
                            
                            <div class="info-label"><i class="fas fa-venus-mars me-2"></i> Género</div>
                            <div class="info-value">
                                <?php 
                                $generos = ['M' => 'Masculino', 'F' => 'Femenino', 'O' => 'Otro'];
                                echo $generos[$usuario['genero']] ?? 'No especificado';
                                ?>
                            </div>
                            
                            <div class="info-label"><i class="fas fa-calendar-alt me-2"></i> Fecha de Ingreso</div>
                            <div class="info-value"><?php echo $fecha_ingreso; ?></div>
                            
                            <div class="info-label"><i class="fas fa-clock me-2"></i> Fecha de Registro</div>
                            <div class="info-value"><?php echo $fecha_registro; ?></div>
                        </div>
                    </div>

                    <!-- ===== SEPARADOR ===== -->
                    <div class="separator"></div>

                    <!-- ===== CAMPOS DE CONTRASEÑA EN MODO VISUALIZACIÓN ===== -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-label"><i class="fas fa-key me-2"></i> Contraseña</div>
                            <div class="info-value">••••••••</div>
                            <span class="modificacion-tag"><i class="fas fa-clock"></i> Última modificación: <?php echo $usuario['contrasena_modificacion'] ? date('d/m/Y H:i', strtotime($usuario['contrasena_modificacion'])) : 'Nunca'; ?></span>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-label"><i class="fas fa-check me-2"></i> Confirmar Contraseña</div>
                            <div class="info-value">••••••••</div>
                            <span class="modificacion-tag"><i class="fas fa-clock"></i> Última modificación: <?php echo $usuario['contrasena_modificacion'] ? date('d/m/Y H:i', strtotime($usuario['contrasena_modificacion'])) : 'Nunca'; ?></span>
                        </div>
                    </div>

                    <!-- ===== PREGUNTAS DE SEGURIDAD (MODO VISUALIZACIÓN) ===== -->
                    <div class="separator"></div>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="fw-bold mb-3" style="color: var(--bpez-dark-blue);">
                                <i class="fas fa-shield-alt me-2"></i>Preguntas de Seguridad
                            </h5>
                        </div>
                    </div>

                    <div class="row">
                        <?php if (!empty($preguntas_usuario)): ?>
                            <?php foreach ($preguntas_usuario as $index => $pregunta): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="info-label"><i class="fas fa-question-circle me-2"></i> Pregunta <?php echo $index + 1; ?></div>
                                    <div class="info-value"><?php echo htmlspecialchars($pregunta['pregunta']); ?></div>
                                    
                                    <span class="modificacion-tag">
                                        <i class="fas fa-clock"></i> 
                                        Última modificación: 
                                        <?php 
                                        if (!empty($pregunta['fecha_modificacion'])) {
                                            echo date('d/m/Y H:i', strtotime($pregunta['fecha_modificacion']));
                                        } else {
                                            echo 'Nunca';
                                        }
                                        ?>
                                    </span>
                                    
                                    <span class="modificacion-tag" style="border-left-color: var(--bpez-rojo-fuego); margin-top: 0;">
                                        <i class="fas fa-lock"></i> Respuesta protegida
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="alert-warning-custom">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    No tiene preguntas de seguridad configuradas. Es <strong>OBLIGATORIO</strong> configurarlas para poder recuperar su contraseña en caso de olvido.
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- MODO EDICIÓN (oculto por defecto) -->
                <div id="editMode" style="display: none;">
                    <form id="editProfileForm" method="POST" action="/modules/perfil/perfil.php">
                        <input type="hidden" name="accion" value="actualizar_perfil">
                        
                        <!-- ===== DATOS BÁSICOS EDITABLES ===== -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- TELÉFONO - EDITABLE -->
                                <div class="info-label"><i class="fas fa-phone me-2"></i> Teléfono</div>
                                <input type="text" class="edit-input" name="telefono" id="editTelefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>
                                <div class="error-message" id="telefonoError">El teléfono debe tener entre 10 y 11 dígitos numéricos</div>
                                
                                <!-- EMAIL - EDITABLE -->
                                <div class="info-label"><i class="fas fa-envelope me-2"></i> Correo Electrónico</div>
                                <input type="email" class="edit-input" name="email" id="editEmail" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                                <div class="error-message" id="emailError">Ingrese un correo electrónico válido (ejemplo@dominio.com)</div>
                                
                                <!-- DIRECCIÓN - EDITABLE -->
                                <div class="info-label"><i class="fas fa-map-marker-alt me-2"></i> Dirección</div>
                                <textarea class="edit-input" name="direccion" id="editDireccion" rows="2" required><?php echo htmlspecialchars($usuario['direccion']); ?></textarea>
                                <div class="error-message" id="direccionError">La dirección debe tener al menos 10 caracteres y solo puede contener letras, números, espacios y . , * # ? - / ( )</div>
                            </div>
                            
                            <div class="col-md-6">
                                <!-- CAMPOS DE SOLO LECTURA -->
                                <div class="info-label"><i class="fas fa-user me-2"></i> Nombres Completos</div>
                                <input type="text" class="edit-input" value="<?php echo htmlspecialchars($nombre_completo . ' ' . $apellido_completo); ?>" readonly disabled style="background: rgba(255,255,255,0.05); color: #666;">
                                
                                <div class="info-label"><i class="fas fa-id-card me-2"></i> Cédula</div>
                                <input type="text" class="edit-input" value="<?php echo htmlspecialchars($usuario['cedula']); ?>" readonly disabled style="background: rgba(255,255,255,0.05); color: #666;">
                                
                                <div class="info-label"><i class="fas fa-calendar-day me-2"></i> Fecha de Nacimiento</div>
                                <input type="text" class="edit-input" value="<?php echo date('d/m/Y', strtotime($usuario['fecha_nacimiento'])); ?>" readonly disabled style="background: rgba(255,255,255,0.05); color: #666;">
                                
                                <div class="info-label"><i class="fas fa-venus-mars me-2"></i> Género</div>
                                <input type="text" class="edit-input" value="<?php 
                                    $generos = ['M' => 'Masculino', 'F' => 'Femenino', 'O' => 'Otro'];
                                    echo $generos[$usuario['genero']] ?? 'No especificado';
                                ?>" readonly disabled style="background: rgba(255,255,255,0.05); color: #666;">
                                
                                <div class="info-label"><i class="fas fa-calendar-alt me-2"></i> Fecha de Ingreso</div>
                                <input type="text" class="edit-input" value="<?php echo $fecha_ingreso; ?>" readonly disabled style="background: rgba(255,255,255,0.05); color: #666;">
                            </div>
                        </div>

                        <!-- ===== CAMPOS DE CONTRASEÑA EN MODO EDICIÓN ===== -->
                        <div class="separator"></div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-label"><i class="fas fa-key me-2"></i> Nueva Contraseña</div>
                                <div class="password-group">
                                    <input type="password" name="nueva_password" id="editNewPassword" class="password-input" placeholder="Ingrese nueva contraseña (mín. 9 caracteres)" autocomplete="new-password">
                                    <span class="password-toggle" onclick="togglePassword('editNewPassword', 'editEyeNew')">
                                        <i class="fas fa-eye" id="editEyeNew"></i>
                                    </span>
                                </div>
                                <div class="error-message" id="passwordError">La contraseña debe tener entre 9 y 50 caracteres y solo puede contener letras, números y .*#</div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="info-label"><i class="fas fa-check me-2"></i> Confirmar Contraseña</div>
                                <div class="password-group">
                                    <input type="password" name="confirmar_password" id="editConfirmPassword" class="password-input" placeholder="Confirme la contraseña" autocomplete="new-password">
                                    <span class="password-toggle" onclick="togglePassword('editConfirmPassword', 'editEyeConfirm')">
                                        <i class="fas fa-eye" id="editEyeConfirm"></i>
                                    </span>
                                </div>
                                <div class="error-message" id="confirmPasswordError">Las contraseñas no coinciden</div>
                            </div>
                        </div>

                        <!-- ===== PREGUNTAS DE SEGURIDAD (MODO EDICIÓN) ===== -->
                        <div class="separator"></div>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="fw-bold mb-3" style="color: var(--bpez-dark-blue);">
                                    <i class="fas fa-shield-alt me-2"></i>Preguntas de Seguridad
                                </h5>
                                
                                <!-- CHECKBOX PARA ACTIVAR EDICIÓN -->
                                <div class="custom-checkbox">
                                    <input type="checkbox" id="editarPreguntas" class="form-check-input">
                                    <label for="editarPreguntas">
                                        <i class="fas fa-pencil-alt me-2"></i>Deseo cambiar mis preguntas de seguridad
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- CONTENEDOR DE PREGUNTAS (deshabilitado por defecto) -->
                        <div id="preguntasContainer" class="preguntas-disabled">
                            <div class="row">
                                <?php for ($i = 1; $i <= 3; $i++): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="info-label"><i class="fas fa-question-circle me-2"></i> Pregunta <?php echo $i; ?></div>
                                    <select name="pregunta_id[]" class="edit-select pregunta-select" id="preguntaSelect<?php echo $i; ?>" disabled>
                                        <option value="">-- Mantener pregunta actual --</option>
                                        <?php foreach ($todas_preguntas as $pregunta): ?>
                                            <option value="<?php echo $pregunta['id']; ?>" 
                                                <?php if (isset($preguntas_usuario[$i-1]) && $preguntas_usuario[$i-1]['pregunta_id'] == $pregunta['id']): ?>
                                                    selected
                                                <?php endif; ?>
                                            ><?php echo htmlspecialchars($pregunta['pregunta']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="error-message" id="preguntaError<?php echo $i; ?>">Debe seleccionar una pregunta</div>
                                    
                                    <div class="info-label mt-2"><i class="fas fa-pencil-alt me-2"></i> Respuesta <?php echo $i; ?></div>
                                    <input type="text" name="respuesta[]" class="edit-input respuesta-input" id="respuesta<?php echo $i; ?>" 
                                        value="" placeholder="Dejar vacío para mantener respuesta actual" maxlength="50" disabled>
                                    <div class="error-message" id="respuestaError<?php echo $i; ?>">La respuesta debe tener entre 3 y 50 caracteres</div>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- BOTONES DE ACCIÓN -->
                <div class="text-center mt-4" id="viewButtons">
                    <button class="btn-action btn-edit shadow-sm" onclick="editarPerfil()">
                        <i class="fas fa-edit me-2"></i>Editar Perfil
                    </button>
                </div>

                <div class="text-center mt-4" id="editButtons" style="display: none;">
                    <button class="btn-action btn-save shadow-sm" onclick="validarYGuardar()">
                        <i class="fas fa-save me-2"></i>Guardar Cambios
                    </button>
                    <button class="btn-action btn-cancel shadow-sm" onclick="cancelarEdicion()">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>

    <script>
        let cambiosPendientes = false;
        let enviandoFormulario = false;

        // ===== FUNCIÓN PARA MOSTRAR/OCULTAR CONTRASEÑA =====
        function togglePassword(inputId, eyeId) {
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

        // ===== FUNCIÓN PARA EDITAR PERFIL =====
        function editarPerfil() {
            document.getElementById('viewMode').style.display = 'none';
            document.getElementById('editMode').style.display = 'block';
            document.getElementById('viewButtons').style.display = 'none';
            document.getElementById('editButtons').style.display = 'block';
            
            // Resetear checkbox y deshabilitar preguntas
            const checkbox = document.getElementById('editarPreguntas');
            if (checkbox) {
                checkbox.checked = false;
                togglePreguntasEdit(false);
            }
            
            cambiosPendientes = true;
            enviandoFormulario = false;
        }

        // ===== FUNCIÓN PARA CANCELAR EDICIÓN =====
        function cancelarEdicion() {
            if (cambiosPendientes) {
                if (confirm('⚠️ ¿Estás seguro de que deseas cancelar la edición?\n\nLos cambios que no hayas guardado se perderán.')) {
                    document.getElementById('viewMode').style.display = 'block';
                    document.getElementById('editMode').style.display = 'none';
                    document.getElementById('viewButtons').style.display = 'block';
                    document.getElementById('editButtons').style.display = 'none';
                    cambiosPendientes = false;
                }
            } else {
                document.getElementById('viewMode').style.display = 'block';
                document.getElementById('editMode').style.display = 'none';
                document.getElementById('viewButtons').style.display = 'block';
                document.getElementById('editButtons').style.display = 'none';
            }
        }

        // ===== FUNCIÓN PARA ACTIVAR/DESACTIVAR PREGUNTAS =====
        function togglePreguntasEdit(activar) {
            const container = document.getElementById('preguntasContainer');
            const selects = document.querySelectorAll('.pregunta-select');
            const inputs = document.querySelectorAll('.respuesta-input');
            
            if (activar) {
                container.classList.remove('preguntas-disabled');
                container.classList.add('preguntas-enabled');
                selects.forEach(select => select.disabled = false);
                inputs.forEach(input => input.disabled = false);
            } else {
                container.classList.add('preguntas-disabled');
                container.classList.remove('preguntas-enabled');
                selects.forEach(select => {
                    select.disabled = true;
                    // Limpiar errores
                    select.classList.remove('is-invalid');
                });
                inputs.forEach(input => {
                    input.disabled = true;
                    input.value = ''; // Limpiar valores
                    input.classList.remove('is-invalid');
                });
                
                // Limpiar mensajes de error
                for (let i = 1; i <= 3; i++) {
                    const errorPregunta = document.getElementById(`preguntaError${i}`);
                    const errorRespuesta = document.getElementById(`respuestaError${i}`);
                    if (errorPregunta) errorPregunta.classList.remove('show');
                    if (errorRespuesta) errorRespuesta.classList.remove('show');
                }
            }
        }

        // ===== FUNCIÓN PARA CERRAR MENSAJE =====
        function cerrarMensaje(id) {
            const mensaje = document.getElementById(id);
            if (mensaje) {
                mensaje.classList.add('oculto');
                setTimeout(() => {
                    mensaje.style.display = 'none';
                }, 500);
            }
        }

        // ===== VALIDAR TELÉFONO (solo números, 10-11 dígitos) =====
        function validarTelefono() {
            const telefono = document.getElementById('editTelefono');
            const error = document.getElementById('telefonoError');
            const valor = telefono.value.trim();
            const regex = /^[0-9]{10,11}$/;
            
            if (valor.length === 0) {
                telefono.classList.add('is-invalid');
                error.textContent = "El teléfono es obligatorio";
                error.classList.add('show');
                return false;
            }
            
            if (!regex.test(valor)) {
                telefono.classList.add('is-invalid');
                error.textContent = "El teléfono debe tener entre 10 y 11 dígitos numéricos";
                error.classList.add('show');
                return false;
            } else {
                telefono.classList.remove('is-invalid');
                error.classList.remove('show');
                return true;
            }
        }

        // ===== VALIDAR EMAIL (formato válido + mínimo 5 caracteres) =====
        function validarEmail() {
            const email = document.getElementById('editEmail');
            const error = document.getElementById('emailError');
            const valor = email.value.trim();
            const regex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            
            if (valor.length === 0) {
                email.classList.add('is-invalid');
                error.textContent = "El email es obligatorio";
                error.classList.add('show');
                return false;
            }
            
            if (valor.length < 5) {
                email.classList.add('is-invalid');
                error.textContent = "El email debe tener al menos 5 caracteres";
                error.classList.add('show');
                return false;
            }
            
            if (!regex.test(valor)) {
                email.classList.add('is-invalid');
                error.textContent = "Ingrese un correo electrónico válido (ejemplo@dominio.com)";
                error.classList.add('show');
                return false;
            } else {
                email.classList.remove('is-invalid');
                error.classList.remove('show');
                return true;
            }
        }

        // ===== VALIDAR DIRECCIÓN (mínimo 10 caracteres, sin emojis) =====
        function validarDireccion() {
            const direccion = document.getElementById('editDireccion');
            const error = document.getElementById('direccionError');
            const valor = direccion.value.trim();
            
            const regex = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.,\*#\?\-/()]+$/;
            
            if (valor.length === 0) {
                direccion.classList.add('is-invalid');
                error.textContent = "La dirección es obligatoria";
                error.classList.add('show');
                return false;
            }
            
            if (valor.length < 10) {
                direccion.classList.add('is-invalid');
                error.textContent = "La dirección debe tener al menos 10 caracteres";
                error.classList.add('show');
                return false;
            }
            
            if (!regex.test(valor)) {
                direccion.classList.add('is-invalid');
                error.textContent = "La dirección solo puede contener letras, números, espacios y . , * # ? - / ( )";
                error.classList.add('show');
                return false;
            } else {
                direccion.classList.remove('is-invalid');
                error.classList.remove('show');
                return true;
            }
        }

        // ===== VALIDAR CONTRASEÑA (mínimo 9 caracteres, solo .*#) =====
        function validarPassword() {
            const password = document.getElementById('editNewPassword');
            const error = document.getElementById('passwordError');
            const valor = password.value.trim();
            const regex = /^[a-zA-Z0-9.*#]+$/;
            
            if (valor.length === 0) {
                password.classList.remove('is-invalid');
                error.classList.remove('show');
                return true;
            }
            
            if (valor.length < 9) {
                password.classList.add('is-invalid');
                error.textContent = "La contraseña debe tener al menos 9 caracteres";
                error.classList.add('show');
                return false;
            }
            
            if (valor.length > 50) {
                password.classList.add('is-invalid');
                error.textContent = "La contraseña no puede tener más de 50 caracteres";
                error.classList.add('show');
                return false;
            }
            
            if (!regex.test(valor)) {
                password.classList.add('is-invalid');
                error.textContent = "La contraseña solo puede contener letras, números y .*#";
                error.classList.add('show');
                return false;
            } else {
                password.classList.remove('is-invalid');
                error.classList.remove('show');
                return true;
            }
        }

        // ===== VALIDAR CONFIRMACIÓN DE CONTRASEÑA =====
        function validarConfirmPassword() {
            const password = document.getElementById('editNewPassword');
            const confirm = document.getElementById('editConfirmPassword');
            const error = document.getElementById('confirmPasswordError');
            const valorPass = password.value.trim();
            const valorConfirm = confirm.value.trim();
            
            if (valorPass.length === 0 && valorConfirm.length === 0) {
                confirm.classList.remove('is-invalid');
                error.classList.remove('show');
                return true;
            }
            
            if (valorPass !== valorConfirm) {
                confirm.classList.add('is-invalid');
                error.textContent = "Las contraseñas no coinciden";
                error.classList.add('show');
                return false;
            } else {
                confirm.classList.remove('is-invalid');
                error.classList.remove('show');
                return true;
            }
        }

        // ===== VALIDAR PREGUNTAS (SOLO SI SE ACTIVÓ EL CHECKBOX) =====
        function validarPreguntas() {
            const checkbox = document.getElementById('editarPreguntas');
            
            // Si no se activó el checkbox, no validar preguntas
            if (!checkbox || !checkbox.checked) {
                return true;
            }
            
            const selects = document.querySelectorAll('.pregunta-select');
            const respuestas = document.querySelectorAll('.respuesta-input');
            let camposValidos = true;
            
            // Limpiar errores previos
            selects.forEach((select, index) => {
                const errorPregunta = document.getElementById(`preguntaError${index + 1}`);
                select.classList.remove('is-invalid');
                if (errorPregunta) errorPregunta.classList.remove('show');
            });
            
            respuestas.forEach((input, index) => {
                const errorRespuesta = document.getElementById(`respuestaError${index + 1}`);
                input.classList.remove('is-invalid');
                if (errorRespuesta) errorRespuesta.classList.remove('show');
            });
            
            // Verificar que todas las preguntas estén seleccionadas
            selects.forEach((select, index) => {
                const error = document.getElementById(`preguntaError${index + 1}`);
                if (!select.value) {
                    select.classList.add('is-invalid');
                    if (error) {
                        error.textContent = "Debe seleccionar una pregunta";
                        error.classList.add('show');
                    }
                    camposValidos = false;
                }
            });
            
            // Verificar preguntas duplicadas
            const valores = [];
            selects.forEach((select, index) => {
                const error = document.getElementById(`preguntaError${index + 1}`);
                if (select.value) {
                    if (valores.includes(select.value)) {
                        select.classList.add('is-invalid');
                        if (error) {
                            error.textContent = "Esta pregunta ya fue seleccionada";
                            error.classList.add('show');
                        }
                        camposValidos = false;
                    } else {
                        valores.push(select.value);
                    }
                }
            });
            
            // Validar respuestas
            selects.forEach((select, index) => {
                const respuestaInput = respuestas[index];
                const error = document.getElementById(`respuestaError${index + 1}`);
                const valor = respuestaInput.value.trim();
                
                if (select.value) {
                    if (valor.length === 0) {
                        respuestaInput.classList.add('is-invalid');
                        if (error) {
                            error.textContent = "La respuesta es obligatoria";
                            error.classList.add('show');
                        }
                        camposValidos = false;
                    } else if (valor.length < 3) {
                        respuestaInput.classList.add('is-invalid');
                        if (error) {
                            error.textContent = "La respuesta debe tener al menos 3 caracteres";
                            error.classList.add('show');
                        }
                        camposValidos = false;
                    } else if (valor.length > 50) {
                        respuestaInput.classList.add('is-invalid');
                        if (error) {
                            error.textContent = "La respuesta no puede tener más de 50 caracteres";
                            error.classList.add('show');
                        }
                        camposValidos = false;
                    }
                }
            });
            
            return camposValidos;
        }

        // ===== VALIDAR TODO EL FORMULARIO =====
        function validarFormulario() {
            const telefonoValido = validarTelefono();
            const emailValido = validarEmail();
            const direccionValida = validarDireccion();
            const passwordValida = validarPassword();
            const confirmValida = validarConfirmPassword();
            const preguntasValidas = validarPreguntas();
            
            return telefonoValido && emailValido && direccionValida && 
                   passwordValida && confirmValida && preguntasValidas;
        }

        // ===== FUNCIÓN PARA GUARDAR CON VALIDACIÓN =====
        function validarYGuardar() {
            if (validarFormulario()) {
                enviandoFormulario = true;
                cambiosPendientes = false;
                document.getElementById('editProfileForm').submit();
            } else {
                alert('Por favor, corrija los errores en el formulario antes de guardar.');
            }
        }

        // ===== EVENTOS =====
        document.addEventListener('DOMContentLoaded', function() {
            // Evento para el checkbox de preguntas
            const checkbox = document.getElementById('editarPreguntas');
            if (checkbox) {
                checkbox.addEventListener('change', function() {
                    togglePreguntasEdit(this.checked);
                    cambiosPendientes = true;
                });
            }
            
            // DETECTAR CAMBIOS EN LOS CAMPOS
            document.querySelectorAll('#editMode input, #editMode textarea, #editMode select').forEach(element => {
                element.addEventListener('input', () => {
                    cambiosPendientes = true;
                    enviandoFormulario = false;
                });
                element.addEventListener('change', () => {
                    cambiosPendientes = true;
                    enviandoFormulario = false;
                });
            });

            // VALIDACIONES EN TIEMPO REAL
            document.getElementById('editTelefono').addEventListener('input', validarTelefono);
            document.getElementById('editEmail').addEventListener('input', validarEmail);
            document.getElementById('editDireccion').addEventListener('input', validarDireccion);
            document.getElementById('editNewPassword').addEventListener('input', function() {
                validarPassword();
                validarConfirmPassword();
            });
            document.getElementById('editConfirmPassword').addEventListener('input', validarConfirmPassword);
            
            // Eventos para preguntas (solo cuando están habilitadas)
            document.querySelectorAll('.pregunta-select, .respuesta-input').forEach(element => {
                element.addEventListener('change', function() {
                    if (!element.disabled) {
                        validarPreguntas();
                        cambiosPendientes = true;
                    }
                });
                element.addEventListener('input', function() {
                    if (!element.disabled) {
                        validarPreguntas();
                        cambiosPendientes = true;
                    }
                });
            });
        });

        // ===== PREVENIR SALIDA SIN GUARDAR =====
        window.addEventListener('beforeunload', function(e) {
            if (cambiosPendientes && !enviandoFormulario) {
                e.preventDefault();
                e.returnValue = '';
                return 'Tienes cambios sin guardar. ¿Estás seguro de que deseas salir?';
            }
        });

        // ===== RESTAURAR ESTADO DESPUÉS DE ENVIAR =====
        window.addEventListener('load', function() {
            enviandoFormulario = false;
        });

        // ===== AUTO-CERRAR MENSAJES DESPUÉS DE 3 SEGUNDOS =====
        setTimeout(() => {
            const mensajeError = document.getElementById('mensajeError');
            const mensajeSuccess = document.getElementById('mensajeSuccess');
            
            if (mensajeError) {
                cerrarMensaje('mensajeError');
            }
            
            if (mensajeSuccess) {
                cerrarMensaje('mensajeSuccess');
            }
        }, 3000);
    </script>

    <!-- ===== SCRIPTS LOCALES ===== -->
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/background-animation.js"></script>
</body>
</html>