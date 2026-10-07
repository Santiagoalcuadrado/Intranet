<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?> - Intranet BPEZ</title>
    
    <!-- ===== RECURSOS OFFLINE (MODULAR) ===== -->
    <!-- Incluye Bootstrap CSS, Font Awesome y Montserrat local -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/offline_assets.php'; ?>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/favicon.php'; ?>
    
    <style>
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo-fuego: #CE2029;
            --bpez-dark-blue: #003366; 
            --bpez-azul-alegre: #0077B6;
            --navbar-height: 130px;
        }

        html, body { height: 100%; margin: 0; }
        body { 
            display: flex; 
            flex-direction: column; 
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
        }

        .main-content { 
            flex: 1;
            padding: calc(var(--navbar-height) + 20px) 20px 40px 20px;
        }

        .crud-container {
            max-width: 1600px;
            margin: 0 auto;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 8px solid var(--bpez-azul-alegre);
            margin-bottom: 30px;
        }

        .section-title {
            color: var(--bpez-dark-blue);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid var(--bpez-cian);
            display: inline-block;
            padding-bottom: 5px;
            font-size: clamp(1.3rem, 3vw, 1.8rem);
        }

        .btn-admin {
            border-radius: 50px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
        }

        .btn-crear {
            background: var(--bpez-azul-alegre);
            color: white;
        }
        .btn-crear:hover {
            background: var(--bpez-dark-blue);
            transform: translateY(-2px);
            color: white;
        }

        .btn-editar {
            background: var(--bpez-azul-alegre);
            color: white;
            padding: 5px 15px;
            font-size: 0.85rem;
            border-radius: 50px;
            border: none;
            transition: all 0.3s;
        }
        .btn-editar:hover {
            background: var(--bpez-dark-blue);
            transform: translateY(-2px);
        }

        .btn-password {
            background: var(--bpez-dark-blue);
            color: white;
            padding: 5px 15px;
            font-size: 0.85rem;
            border-radius: 50px;
            border: none;
            transition: all 0.3s;
        }
        .btn-password:hover {
            background: var(--bpez-azul-alegre);
            transform: translateY(-2px);
        }

        .btn-estado {
            background: transparent;
            border: 1px solid var(--bpez-dark-blue);
            color: var(--bpez-dark-blue);
            padding: 5px 15px;
            font-size: 0.85rem;
            border-radius: 50px;
            transition: all 0.3s;
        }
        .btn-estado:hover {
            background: var(--bpez-dark-blue);
            color: white;
            transform: translateY(-2px);
        }

        .btn-eliminar {
            background: var(--bpez-rojo-fuego);
            color: white;
            padding: 5px 15px;
            font-size: 0.85rem;
            border-radius: 50px;
            border: none;
            transition: all 0.3s;
        }
        .btn-eliminar:hover {
            background: #b30000;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(206, 32, 41, 0.4);
        }

        .table {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            overflow: hidden;
        }
        .table th {
            background: rgba(0, 51, 102, 0.15);
            color: var(--bpez-dark-blue);
            font-weight: 700;
            padding: 15px 10px;
            border-bottom: 2px solid var(--bpez-cian);
            font-size: 0.85rem;
            white-space: nowrap;
        }
        .table td {
            padding: 15px 10px;
            color: var(--bpez-dark-blue);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            vertical-align: middle;
            font-size: 0.8rem;
        }
        .table tr:hover td {
            background: rgba(255, 255, 255, 0.1);
        }

        .badge-estado {
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-activo { background: #28a745; color: white; }
        .badge-inactivo { background: #6c757d; color: white; }
        .badge-suspendido { background: var(--bpez-rojo-fuego); color: white; }

        /* ===== MODAL EXPANDIDO ===== */
        .modal-dialog {
            max-width: 1200px !important;
            width: 95% !important;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-left: 6px solid var(--bpez-azul-alegre);
            border-radius: 25px;
        }

        .modal-header {
            border-bottom: 2px solid var(--bpez-cian);
            padding: 20px 25px;
        }

        .modal-title {
            color: var(--bpez-dark-blue);
            font-weight: 700;
            font-size: 1.5rem;
        }

        .modal-body {
            padding: 30px;
        }

        .modal-footer {
            border-top: 2px solid var(--bpez-cian);
            padding: 20px 30px;
        }

        /* ===== CAMPOS DE FORMULARIO MEJORADOS ===== */
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(0, 51, 102, 0.2);
            border-radius: 50px;
            padding: 12px 18px;
            color: var(--bpez-dark-blue);
            font-size: 0.95rem;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.3);
            border-color: var(--bpez-azul-alegre);
            box-shadow: none;
        }

        /* ===== PLACEHOLDERS MÁS LEGIBLES ===== */
        .form-control::placeholder {
            color: rgba(0, 51, 102, 0.5);
            font-size: 0.9rem;
            font-style: italic;
        }

        /* ===== SELECTORES DE PREGUNTAS ===== */
        .pregunta-select, .respuesta-input {
            width: 100%;
            font-size: 0.95rem;
        }

        /* ===== MENSAJES DE ERROR ===== */
        .invalid-feedback {
            color: var(--bpez-rojo-fuego);
            font-size: 0.8rem;
            margin-top: 5px;
            padding-left: 15px;
            display: none;
            text-align: left;
            font-weight: 500;
        }

        .invalid-feedback.show {
            display: block;
        }

        .is-invalid {
            border-color: var(--bpez-rojo-fuego) !important;
            background: rgba(206, 32, 41, 0.05) !important;
        }

        .pagination {
            gap: 5px;
        }
        .page-link {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--bpez-dark-blue);
            border-radius: 50px;
            padding: 8px 15px;
        }
        .page-link:hover {
            background: rgba(255, 255, 255, 0.2);
            color: var(--bpez-azul-alegre);
        }
        .page-item.active .page-link {
            background: var(--bpez-azul-alegre);
            border-color: var(--bpez-azul-alegre);
            color: white;
        }

        /* ===== MENSAJE FLOTANTE CORREGIDO (SIN ANIMACIONES) ===== */
        .mensaje-flotante {
            position: fixed;
            top: 100px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            min-width: 300px;
            max-width: 500px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .mensaje-flotante.mostrar {
            opacity: 1;
            visibility: visible;
        }

        .mensaje-contenido {
            padding: 15px 25px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-left: 6px solid;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .mensaje-success { border-color: #28a745; }
        .mensaje-error { border-color: var(--bpez-rojo-fuego); }
        .mensaje-info { border-color: var(--bpez-azul-alegre); }

        .btn-success {
            background: #28a745;
            color: white;
            padding: 5px 15px;
            font-size: 0.85rem;
            border-radius: 50px;
            border: none;
            transition: all 0.3s;
        }
        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }

        /* Seccion de preguntas */
        .separator {
            border-top: 1px solid rgba(255,255,255,0.2);
            margin: 20px 0;
        }

        .alert-info-custom {
            background: rgba(0,119,182,0.1);
            border-left: 4px solid var(--bpez-azul-alegre);
            padding: 15px;
            border-radius: 8px;
            color: var(--bpez-dark-blue);
            font-size: 0.95rem;
        }

        /* ===== CHECKBOX PERSONALIZADO ===== */
        .custom-checkbox {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            padding: 15px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            cursor: pointer;
            accent-color: var(--bpez-azul-alegre);
        }

        .form-check-input:checked {
            background-color: var(--bpez-azul-alegre);
            border-color: var(--bpez-azul-alegre);
        }

        .form-check-label {
            color: var(--bpez-dark-blue);
            font-weight: 500;
            cursor: pointer;
        }

        /* ===== PREGUNTAS DESHABILITADAS ===== */
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

        @media (max-width: 1200px) {
            .table { font-size: 0.75rem; }
            .table th, .table td { padding: 10px 5px; }
        }
        @media (max-width: 768px) {
            .table { font-size: 0.7rem; }
            .btn-editar, .btn-password, .btn-estado, .btn-eliminar { 
                padding: 3px 8px; 
                font-size: 0.7rem;
                margin: 2px;
            }
            .modal-dialog {
                max-width: 95% !important;
                margin: 10px auto;
            }
        }
    </style>
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

<div class="main-content">
    <div class="crud-container">
        
        <div class="card-glass">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h1 class="section-title"><?php echo $titulo_pagina; ?></h1>
                    <p class="lead-text mt-2"><?php echo $descripcion_pagina; ?></p>
                </div>
                <button class="btn-admin btn-crear" onclick="abrirModalCrear()">
                    <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
                </button>
            </div>
        </div>

        <div class="card-glass">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cédula</th>
                            <th>Primer Nombre</th>
                            <th>Segundo Nombre</th>
                            <th>Primer Apellido</th>
                            <th>Segundo Apellido</th>
                            <th>Email</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha Ingreso</th>
                            <th>Fecha Egreso</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-usuarios">
                        <tr><td colspan="13" class="text-center">Cargando usuarios...</td></tr>
                    </tbody>
                </table>
            </div>

            <nav class="mt-4">
                <ul class="pagination justify-content-center" id="paginacion"></ul>
            </nav>
        </div>

    </div>
</div>

<!-- Modal para crear/editar usuario (EXPANDIDO) -->
<div class="modal fade" id="usuarioModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Crear Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="usuarioForm">
                    <input type="hidden" id="usuarioId" name="id">
                    
                    <!-- ===== DATOS PERSONALES ===== -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Primer Nombre *</label>
                            <input type="text" class="form-control" id="primer_nombre" name="primer_nombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Segundo Nombre</label>
                            <input type="text" class="form-control" id="segundo_nombre" name="segundo_nombre">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Primer Apellido *</label>
                            <input type="text" class="form-control" id="primer_apellido" name="primer_apellido" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cédula *</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fecha Nacimiento *</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Género *</label>
                            <select class="form-select" id="genero" name="genero" required>
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="O">Otro</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Teléfono *</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Fecha Ingreso *</label>
                            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required max="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Dirección *</label>
                        <textarea class="form-control" id="direccion" name="direccion" rows="2" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Rol *</label>
                            <select class="form-select" id="id_rol" name="id_rol" required>
                                <?php foreach ($roles as $rol): ?>
                                <option value="<?php echo $rol['id']; ?>"><?php echo $rol['nombre_rol']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Estado *</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                <option value="Suspendido">Suspendido</option>
                            </select>
                        </div>
                        
                        <!-- ===== CONTENEDOR PARA FECHA EGRESO ===== -->
                        <div class="col-md-4 mb-3" id="fecha_egreso_container">
                            <label class="form-label">Fecha Egreso</label>
                            <input type="date" class="form-control" id="fecha_egreso" name="fecha_egreso" min="" max="<?php echo date('Y-m-d'); ?>">
                            <small class="text-muted">Solo si está inactivo</small>
                        </div>
                    </div>

                    <!-- ===== SEPARADOR ANTES DE PREGUNTAS ===== -->
                    <div class="separator my-4"></div>
                    
                    <!-- ===== PREGUNTAS DE SEGURIDAD ===== -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="fw-bold mb-3" style="color: var(--bpez-dark-blue);">
                                <i class="fas fa-shield-alt me-2"></i>Preguntas de Seguridad
                            </h5>
                            
                            <!-- CHECKBOX PARA ACTIVAR EDICIÓN (SOLO EN MODO EDICIÓN) -->
                            <div class="custom-checkbox mb-3" id="checkboxPreguntasContainer" style="display: none;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editarPreguntasCheckbox">
                                    <label class="form-check-label" for="editarPreguntasCheckbox">
                                        <i class="fas fa-pencil-alt me-2"></i>Deseo cambiar las preguntas de seguridad
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-1">Si no marca esta opción, se mantendrán las preguntas actuales.</small>
                            </div>

                            <!-- ALERTA PARA CREACIÓN (SIEMPRE VISIBLE) -->
                            <div class="alert-info-custom mb-3" id="alertCreacion">
                                <i class="fas fa-info-circle me-2"></i>
                                Seleccione 3 preguntas diferentes para el usuario. Las respuestas serán hasheadas por seguridad.
                            </div>
                        </div>
                    </div>

                    <!-- CONTENEDOR DE PREGUNTAS (deshabilitado por defecto en edición) -->
                    <div id="preguntasContainer">
                        <div class="row">
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Pregunta <?php echo $i; ?> *</label>
                                <select class="form-select pregunta-select" name="pregunta_id_<?php echo $i; ?>" id="pregunta_id_<?php echo $i; ?>" required>
                                    <option value="">-- Seleccione una pregunta --</option>
                                    <?php foreach ($preguntas_disponibles as $pregunta): ?>
                                    <option value="<?php echo $pregunta['id']; ?>"><?php echo htmlspecialchars($pregunta['pregunta']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback" id="preguntaError<?php echo $i; ?>">Seleccione una pregunta</div>
                                
                                <label class="form-label mt-2">Respuesta <?php echo $i; ?> *</label>
                                <input type="text" class="form-control respuesta-input" name="respuesta_<?php echo $i; ?>" id="respuesta_<?php echo $i; ?>" 
                                    placeholder="Respuesta (mínimo 3 caracteres)" maxlength="50" required>
                                <div class="invalid-feedback" id="respuestaError<?php echo $i; ?>">La respuesta debe tener entre 3 y 50 caracteres</div>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <!-- ===== INFO DE CONTRASEÑA ===== -->
                    <div class="alert alert-info" id="passwordInfo" style="display:none;">
                        <i class="fas fa-info-circle me-2"></i>
                        La contraseña inicial será: <strong>CÉDULA + 123456789</strong> (ej: 29955870123456789)
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarUsuario()">Guardar Usuario</button>
            </div>
        </div>
    </div>
</div>

<div id="mensajeFlotante" class="mensaje-flotante"></div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>

<!-- ===== SCRIPTS LOCALES ===== -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/background-animation.js"></script>
<script src="/assets/js/crud_admin.js"></script>

</body>
</html>