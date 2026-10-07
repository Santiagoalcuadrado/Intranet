<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo_pagina; ?> - Intranet BPEZ</title>
    
    <!-- ===== RECURSOS OFFLINE (MODULAR) ===== -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/offline_assets.php'; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/favicon.php'; ?>    

    <style>
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo-fuego: #CE2029;
            --bpez-dark-blue: #003366; 
            --bpez-azul-alegre: #0077B6;
            --estado-aprobado: #28a745;
            --estado-revision: #ffc107;
            --estado-no-disponible: #dc3545;
            --navbar-height: 130px;
        }

        html, body { height: 100%; margin: 0; overflow: auto; scroll-behavior: smooth; }
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

        .cards-container {
            max-width: 1300px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 8px solid var(--bpez-azul-alegre);
            animation: fadeInUp 0.8s ease forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .card-glass:nth-child(1) { animation-delay: 0.1s; }
        .card-glass:nth-child(2) { animation-delay: 0.3s; }
        .card-glass:nth-child(3) { animation-delay: 0.5s; }

        .title-card { text-align: center; }
        .title-icon { color: var(--bpez-azul-alegre); font-size: 3rem; margin-bottom: 15px; }
        .section-title {
            color: var(--bpez-dark-blue);
            font-weight: 800;
            text-transform: uppercase;
            border-bottom: 2px solid var(--bpez-cian);
            display: inline-block;
            padding-bottom: 5px;
            font-size: clamp(1.3rem, 4vw, 2rem);
        }
        .lead-text { color: var(--bpez-dark-blue); opacity: 0.8; font-size: clamp(1rem, 2vw, 1.2rem); }
        .card-subtitle {
            color: var(--bpez-dark-blue);
            font-weight: 700;
            font-size: clamp(1.1rem, 2.5vw, 1.3rem);
            margin: 0 0 20px 0;
            border-left: 4px solid var(--bpez-rojo-fuego);
            padding-left: 12px;
        }

        /* ===== ESTILOS DE TABLA ===== */
        .btn-admin {
            border-radius: 50px;
            padding: 6px 12px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            font-size: 0.8rem;
            margin: 2px;
        }
        .btn-ver { background: var(--bpez-azul-alegre); color: white; }
        .btn-ver:hover { background: var(--bpez-dark-blue); transform: translateY(-2px); }
        .btn-descargar { background: var(--bpez-rojo-fuego); color: white; }
        .btn-descargar:hover { background: #b30000; transform: translateY(-2px); }
        .btn-editar { background: #ffc107; color: var(--bpez-dark-blue); }
        .btn-editar:hover { background: #e0a800; transform: translateY(-2px); }
        .btn-estado { background: transparent; border: 1px solid var(--bpez-dark-blue); color: var(--bpez-dark-blue); }
        .btn-estado:hover { background: var(--bpez-dark-blue); color: white; }
        .btn-eliminar { background: var(--bpez-rojo-fuego); color: white; }
        .btn-eliminar:hover { background: #b30000; transform: translateY(-2px); }
        .btn-recuperar {
            background: #28a745;
            color: white;
        }
        .btn-recuperar:hover {
            background: #218838;
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
            padding: 15px;
            border-bottom: 2px solid var(--bpez-cian);
        }
        .table td {
            padding: 15px;
            color: var(--bpez-dark-blue);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            vertical-align: middle;
        }
        .table tr:hover td { background: rgba(255, 255, 255, 0.1); }

        .badge-estado {
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            color: white;
            display: inline-block;
        }
        .badge-aprobado { background: var(--estado-aprobado); }
        .badge-pendiente { background: var(--estado-revision); color: var(--bpez-dark-blue); }
        .badge-rechazado { background: var(--estado-no-disponible); }

        #selectorOrden {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: var(--bpez-dark-blue);
            font-weight: 500;
            cursor: pointer;
            padding: 8px 15px;
        }
        #selectorOrden:hover { background: rgba(255, 255, 255, 0.2); border-color: var(--bpez-azul-alegre); }
        #selectorOrden:focus { box-shadow: 0 0 0 0.2rem rgba(0, 119, 182, 0.25); border-color: var(--bpez-azul-alegre); }
        #selectorOrden option { background: white; color: var(--bpez-dark-blue); }

        /* ===== MODALES ===== */
        .modal-content {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-left: 6px solid var(--bpez-azul-alegre);
            border-radius: 25px;
        }
        .modal-header { border-bottom: 2px solid var(--bpez-cian); padding: 20px 25px; }
        .modal-title { color: var(--bpez-dark-blue); font-weight: 700; }
        .modal-body { padding: 25px; }
        .modal-footer { border-top: 2px solid var(--bpez-cian); padding: 20px 25px; }
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(0, 51, 102, 0.2);
            border-radius: 50px;
            padding: 10px 15px;
            color: var(--bpez-dark-blue);
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.3);
            border-color: var(--bpez-azul-alegre);
            box-shadow: none;
        }

        .pagination { gap: 5px; }
        .page-link {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--bpez-dark-blue);
            border-radius: 50px;
            padding: 8px 15px;
        }
        .page-link:hover { background: rgba(255, 255, 255, 0.2); color: var(--bpez-azul-alegre); }
        .page-item.active .page-link {
            background: var(--bpez-azul-alegre);
            border-color: var(--bpez-azul-alegre);
            color: white;
        }

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
        .mensaje-flotante.mostrar { opacity: 1; visibility: visible; }
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

        @media (max-width: 575px) {
            .main-content { padding: calc(var(--navbar-height) + 15px) 12px 20px 12px; }
            .card-glass { padding: 15px; }
            .section-title { font-size: 1.2rem; }
        }
    </style>
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

<div class="main-content">
    <div class="cards-container">
        
        <!-- CARD 1: Título principal -->
        <div class="card-glass title-card">
            <div class="text-center">
                <i class="fas fa-book-open title-icon"></i>
                <h1 class="section-title">CONTEXTO: Lineamientos nacionales sobre el libro, la lectura y las bibliotecas</h1>
                <p class="lead-text">Marco estratégico de las 7 Transformaciones (7T), la Ley de Comunas y los Lineamientos Nacionales en materia de libros y bibliotecas, enfocado específicamente en su impacto sobre la Administración Pública venezolana al cierre de febrero de 2026.</p>
            </div>
        </div>

        <!-- CARD 2: Tabla de Marco Legal / Estratégico con CRUD -->
        <div class="card-glass">
            <h3 class="card-subtitle">Marco Legal y Estratégico</h3>
            
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap: 10px;">
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <span style="color: var(--bpez-dark-blue); font-weight: 600; font-size: 0.9rem;">
                        <i class="fas fa-sort me-1"></i>Ordenar por:
                    </span>
                    <select id="selectorOrden" class="form-select" style="width: auto; min-width: 180px; background: rgba(255,255,255,0.2); border-radius: 50px; font-size: 0.9rem;" onchange="cambiarOrden()">
                        <option value="fecha_desc"> Más recientes primero</option>
                        <option value="fecha_asc"> Más antiguos primero</option>
                        <option value="titulo_asc"> Título (A-Z)</option>
                        <option value="titulo_desc"> Título (Z-A)</option>
                        <option value="estado_asc"> Por estado</option>
                        <option value="estado_desc"> Por estado inverso</option>

                    </select>
                </div>
                
                <?php if ($_SESSION['rol'] === 'Administrador'): ?>
                <button class="btn btn-primary" onclick="abrirModalSubir()" style="border-radius: 50px;">
                    <i class="fas fa-upload me-2"></i>Subir Nueva Marco Legal / Estratégico
                </button>
                <?php endif; ?>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Marco Legal / Estratégico</th>
                            <th>Impacto en la Administración Pública y Rol de las Bibliotecas</th>
                            <th>Vigencia / Gaceta</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-documentos">
                        <tr>
                            <td colspan="5" class="text-center">
                                <div class="spinner-border text-primary"></div>
                                Cargando documentos...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <nav class="mt-4">
                <ul class="pagination justify-content-center" id="paginacion"></ul>
            </nav>
        </div>

        <!-- CARD 3: Código de Ética del Empleado Público -->
        <div class="card-glass">
            <div class="info-block">
                <i class="fas fa-gavel"></i>
                <h4>Código de Ética del Empleado Público</h4>
                <div class="resumen">Código de Ética:</div>
                <p>Documento que establece los principios, valores y normas de conducta que deben regir la actuación de los servidores públicos en el ejercicio de sus funciones, garantizando la transparencia, honestidad y responsabilidad en la gestión institucional.</p>
                <a href="/uploads/documentos/codigo_etica_empleado_publico.pdf" class="btn-descarga" download>
                    <i class="fas fa-file-pdf"></i> Descargar Código de Ética
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ===== MODALES ===== -->
<div class="modal fade" id="modalSubir" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formSubir" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Marco Legal / Estratégico *</label>
                        <input type="text" class="form-control" id="titulo" placeholder="Ej: Plan 7 Transformaciones" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Impacto en la Administración Pública y Rol de las Bibliotecas *</label>
                        <textarea class="form-control" id="descripcion" rows="4" placeholder="Describa el impacto administrativo de este marco legal..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vigencia / Gaceta *</label>
                        <input type="text" class="form-control" id="gaceta" placeholder="Ej: G.O. Nº 6.907 (Mayo 2025)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Archivo PDF *</label>
                        <input type="file" class="form-control" id="archivo" accept=".pdf" required>
                        <small class="text-muted mt-1 d-block">
                            <i class="fas fa-info-circle"></i> 
                            Límite: 120MB. Solo archivos PDF.
                        </small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="subirDocumento()">Subir Documento</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label">Marco Legal / Estratégico *</label>
                        <input type="text" class="form-control" id="edit_titulo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Impacto en la Administración Pública y Rol de las Bibliotecas *</label>
                        <textarea class="form-control" id="edit_descripcion" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vigencia / Gaceta *</label>
                        <input type="text" class="form-control" id="edit_gaceta" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEdicion()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cambiar Estado -->
<div class="modal fade" id="modalEstado" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cambiar Estado del Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="estado_id">
                <div class="mb-3">
                    <label class="form-label">Nuevo Estado</label>
                    <select class="form-select" id="nuevo_estado">
                        <option value="aprobado">Aprobado</option>
                        <option value="pendiente">En Revisión</option>
                        <option value="rechazado">No Disponible</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarEstado()">Cambiar Estado</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="eliminar_id">
                <div class="mb-3">
                    <label class="form-label">Motivo de eliminación</label>
                    <textarea class="form-control" id="motivo_eliminacion" rows="3" placeholder="Especifique por qué se elimina este documento... (mínimo 9 caracteres)"></textarea>
                    <small class="text-muted mt-1 d-block" id="contadorMotivo">
                        <i class="fas fa-info-circle"></i> 
                        Letras válidas: <span id="caracteresActuales">0</span>/9 (espacios no cuentan)
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="confirmarEliminar()">Eliminar Documento</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ver PDF -->
<div class="modal fade" id="modalVer" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ver_titulo">Vista Previa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="visor_pdf" style="width:100%; height:600px; border:none;"></iframe>
            </div>
        </div>
    </div>
</div>

<div id="mensajeFlotante" class="mensaje-flotante"></div>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/background-animation.js"></script>
<script>
window.rolUsuario = '<?php echo $_SESSION['rol']; ?>';
</script>
<script src="/assets/js/lineamientos_nacionales_ajax.js"></script>

</body>
</html>