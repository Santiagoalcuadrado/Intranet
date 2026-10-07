<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contexto Venezolano - Intranet BPEZ</title>
    
    <!-- ===== RECURSOS OFFLINE (MODULAR) ===== -->
    <!-- Incluye Bootstrap CSS, Font Awesome y Montserrat local -->
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/offline_assets.php'; ?>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/favicon.php'; ?>
    
    <style>
        /* Tus estilos existentes */
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

        html, body { height: 100%; margin: 0; overflow: auto; }
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
        .card-glass:nth-child(4) { animation-delay: 0.7s; }
        .card-glass:nth-child(5) { animation-delay: 0.9s; }

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

        /* Bloques de información */
        .info-block {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 18px;
            padding: 20px;
            margin-bottom: 15px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 4px solid var(--bpez-azul-alegre);
        }
        .info-block:hover { background: rgba(255, 255, 255, 0.15); transform: translateX(5px); }
        .info-block i { color: var(--bpez-azul-alegre); font-size: 1.8rem; margin-bottom: 10px; }
        .info-block h4 { color: var(--bpez-dark-blue); font-weight: 700; font-size: clamp(1rem, 2.2vw, 1.1rem); margin-bottom: 10px; }
        .info-block p { color: var(--bpez-dark-blue); font-size: clamp(0.85rem, 1.8vw, 0.95rem); line-height: 1.6; }
        .info-block ul { list-style-type: none; padding-left: 0; }
        .info-block li:before { content: "•"; color: var(--bpez-rojo-fuego); font-weight: bold; margin-right: 8px; }

        .destacado {
            background: rgba(0, 118, 182, 0.03);
            border-left: 4px solid var(--bpez-azul-alegre);
            padding: 15px;
            border-radius: 12px;
            margin: 15px 0;
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
        .btn-info {
            background: #17a2b8;
            color: white;
        }
        .btn-info:hover {
            background: #138496;
            transform: translateY(-2px);
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

        /* Estilo para el selector ordenar por */
        #selectorOrden {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: var(--bpez-dark-blue);
            font-weight: 500;
            cursor: pointer;
            padding: 8px 15px;
        }

        #selectorOrden:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: var(--bpez-azul-alegre);
        }

        #selectorOrden:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 119, 182, 0.25);
            border-color: var(--bpez-azul-alegre);
        }

        /* Para las opciones del select */
        #selectorOrden option {
            background: white;
            color: var(--bpez-dark-blue);
        }

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
                <i class="fas fa-gavel title-icon"></i>
                <h1 class="section-title">CONTEXTO: Marco Legal Venezolano</h1>
                <p class="lead-text">Administración Pública Venezolana</p>
            </div>
        </div>

        <!-- CARD 2: Marco Legal -->
        <div class="card-glass">
            <h3 class="card-subtitle">Marco Legal Venezolano sobre la Administración Pública</h3>
            <div class="destacado">
                <p><strong>Digitalización Obligatoria:</strong> Bajo la Ley de Infogobierno y las recientes reformas de 2025, la Administración Pública Nacional está migrando gran parte de su gestión a sistemas interoperables (evitando el uso de papel).</p>
            </div>
            <div class="destacado">
                <p><strong>Estado Comunal:</strong> Existe una fuerte tendencia a transferir competencias de la administración central a los Consejos Comunales y Comunas, bajo la Ley Orgánica de las Comunas y la Ley de Planificación Pública y Popular.</p>
            </div>
            <div class="destacado">
                <p><strong>Proceso de Reforma 2026:</strong> Actualmente, la Asamblea Nacional discute la Ley de Aceleración y Optimización de Trámites, la cual se espera que sustituya o complemente a la LOPA de 1981 para reducir los tiempos de respuesta del Estado.</p>
            </div>
        </div>

        <!-- CARD 3: 7 Transformaciones -->
        <div class="card-glass">
            <h3 class="card-subtitle">Las 7 Transformaciones y su Impacto en Bibliotecas</h3>
            <div class="info-block">
                <i class="fas fa-book"></i>
                <h4>1. Bibliotecas como Nodos de la 2da Transformación</h4>
                <p>En el marco de las 7T, la Administración Pública ha redefinido a las bibliotecas. Ya no dependen únicamente del Ministerio de Cultura para "prestar libros", sino que ahora actúan como Centros de Información Ciudadana. Su rol administrativo es:</p>
                <ul>
                    <li>Garantizar el acceso gratuito a bases de datos científicas.</li>
                    <li>Servir de punto de apoyo para el registro en sistemas estatales (Patria, VenApp).</li>
                    <li>Preservar la memoria histórica local como parte de la "Independencia Intelectual".</li>
                </ul>
            </div>
            <div class="info-block">
                <i class="fas fa-users"></i>
                <h4>2. La Administración Pública "Comunalizada" (6ta T)</h4>
                <p>La gestión de los recursos públicos se está desplazando hacia el territorio. Las leyes actuales exigen que la administración central "escuche" a las bases. Aquí, el Sistema Nacional de Bibliotecas Públicas es la infraestructura física que permite la formación política y técnica de los consejos comunales para que gestionen sus propios proyectos.</p>
            </div>
            <div class="info-block">
                <i class="fas fa-shield-alt"></i>
                <h4>3. Eficiencia y Ética (3ra y 7ma T)</h4>
                <p>Con la reciente Reforma de la Ley contra la Corrupción (2025), cada funcionario administrativo, incluyendo los directores de bibliotecas y museos, está bajo un sistema de vigilancia en tiempo real a través del Sistema Integrado de Gestión y Control de las Finanzas Públicas (SIGECOF).</p>
            </div>
        </div>

        <!-- CARD 4: Leyes e Instrumentos Legales (TABLA) -->
        <div class="card-glass">
            <h3 class="card-subtitle">Leyes e Instrumentos Legales</h3>
            
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap: 10px;">
                <!-- SELECTOR ORDENAR POR (OPCIÓN 1) -->
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
                    <i class="fas fa-upload me-2"></i>Subir Nueva Ley / Instrumento
                </button>
                <?php endif; ?>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ley / Instrumento</th>
                            <th>Última Actualización / Gaceta</th>
                            <th>Resumen de Impacto Administrativo</th>
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
    </div>
</div>

<!-- ===== MODALES ===== -->
<div class="modal fade" id="modalSubir" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subir Nueva Ley / Instrumento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formSubir" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Ley / Instrumento *</label>
                        <input type="text" class="form-control" id="titulo" placeholder="Ej: Ley Orgánica del Plan de la Patria" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Última Actualización / Gaceta</label>
                        <input type="text" class="form-control" id="gaceta" placeholder="Ej: G.O. Nº 6.907 (Mayo 2025)" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Resumen de Impacto Administrativo</label>
                        <textarea class="form-control" id="descripcion" rows="3" placeholder="Describa el impacto administrativo de esta ley..." required></textarea>
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
                <button type="button" class="btn btn-primary" onclick="subirDocumento()">Subir Ley / Instrumento</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Ley / Instrumento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formEditar">
                    <input type="hidden" id="edit_id">
                    <div class="mb-3">
                        <label class="form-label">Ley / Instrumento *</label>
                        <input type="text" class="form-control" id="edit_titulo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Última Actualización / Gaceta</label>
                        <input type="text" class="form-control" id="edit_gaceta" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Resumen de Impacto Administrativo</label>
                        <textarea class="form-control" id="edit_descripcion" rows="3" required></textarea>
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
                <h5 class="modal-title">Cambiar Estado de la Ley</h5>
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
                <h5 class="modal-title">Eliminar Ley / Instrumento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="eliminar_id">
                <div class="mb-3">
                    <label class="form-label">Motivo de eliminación</label>
                    <textarea class="form-control" id="motivo_eliminacion" rows="3" placeholder="Especifique por qué se elimina esta ley... (mínimo 9 caracteres)"></textarea>
                    <small class="text-muted mt-1 d-block" id="contadorMotivo">
                        <i class="fas fa-info-circle"></i> 
                        Letras válidas: <span id="caracteresActuales">0</span>/9 (espacios no cuentan)
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" onclick="confirmarEliminar()">Eliminar Ley</button>
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

<!-- ===== SCRIPTS LOCALES ===== -->
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/background-animation.js"></script>
<script>
// ===== PASAR EL ROL DEL USUARIO A JAVASCRIPT =====
window.rolUsuario = '<?php echo $_SESSION['rol']; ?>';
</script>
<!-- ===== JAVASCRIPT ESPECÍFICO DE CONTEXTO VENEZOLANO ===== -->
<script src="/assets/js/contexto_venezolano_ajax.js"></script>

</body>
</html>