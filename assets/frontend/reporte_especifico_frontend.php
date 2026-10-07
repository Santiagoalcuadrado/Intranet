<?php
/**
 * reporte_especifico_frontend.php
 * VISTA para el Reporte Específico del Sistema
 * Ubicación: /assets/frontend/reporte_especifico_frontend.php
 */

// Obtener años disponibles desde la base de datos
$anos_disponibles = [];

try {
    $stmt = $pdo->query("SELECT DISTINCT YEAR(fecha) as anio FROM logs ORDER BY anio DESC");
    $anos_logs = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $stmt = $pdo->query("SELECT DISTINCT YEAR(fecha_registro) as anio FROM usuarios ORDER BY anio DESC");
    $anos_usuarios = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $stmt = $pdo->query("SELECT DISTINCT YEAR(fecha_creacion) as anio FROM documentos WHERE eliminado = 0 ORDER BY anio DESC");
    $anos_documentos = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    $anos_disponibles = array_unique(array_merge($anos_logs, $anos_usuarios, $anos_documentos));
    rsort($anos_disponibles);
    
} catch (PDOException $e) {
    $anos_disponibles = [date('Y')];
}

// Obtener módulos disponibles (tablas con logs)
$modulos_disponibles = [];
try {
    $stmt = $pdo->query("SELECT DISTINCT tabla FROM logs ORDER BY tabla");
    $modulos_disponibles = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    $modulos_disponibles = ['usuarios', 'documentos', 'logs', 'reportes'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title><?php echo $titulo_pagina; ?> - Intranet BPEZ</title>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/offline_assets.php'; ?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/favicon.php'; ?>
    
    <!-- CSS del buscador de usuarios y documentos -->
    <link rel="stylesheet" href="/assets/css/buscador_usuarios.css">
    
    <style>
        :root {
            --bpez-cian: #76C7C0;
            --bpez-rojo-fuego: #CE2029;
            --bpez-dark-blue: #003366; 
            --bpez-azul-alegre: #0077B6;
            --navbar-height: 130px;
        }

        html, body { height: 100%; margin: 0; overflow: auto; }
        
        body { 
            display: flex; 
            flex-direction: column; 
            background: linear-gradient(135deg, var(--bpez-cian) 0%, #ffffff 100%);
            font-family: 'Montserrat', sans-serif;
            color: #333;
        }

        .main-content { 
            flex: 1;
            padding: calc(var(--navbar-height) + 20px) 20px 40px 20px;
        }

        .reporte-container {
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            padding: 35px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-left: 8px solid var(--bpez-azul-alegre);
            transition: all 0.3s ease;
            margin-bottom: 25px;
        }

        .card-glass:hover {
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }

        .title-icon {
            color: var(--bpez-azul-alegre);
            font-size: 3rem;
            margin-bottom: 15px;
            text-align: center;
        }

        .section-title {
            color: var(--bpez-dark-blue);
            font-weight: 800;
            text-transform: uppercase;
            border-bottom: 2px solid var(--bpez-cian);
            display: inline-block;
            padding-bottom: 5px;
            font-size: clamp(1.3rem, 4vw, 1.8rem);
            margin-bottom: 15px;
        }

        .descripcion-text {
            color: var(--bpez-dark-blue);
            font-size: 0.9rem;
            margin-bottom: 25px;
            opacity: 0.8;
            text-align: center;
        }

        .filtros-container {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-bottom: 30px;
        }

        .filtros-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .filtro-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
            min-width: 150px;
        }

        .filtro-group label {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--bpez-dark-blue);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: left;
        }

        .filtro-select, .filtro-input {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 50px;
            padding: 12px 18px;
            color: var(--bpez-dark-blue);
            font-weight: 500;
            font-size: 0.95rem;
            width: 100%;
        }

        .filtro-select:focus, .filtro-input:focus {
            outline: none;
            border-color: var(--bpez-azul-alegre);
            background: rgba(255, 255, 255, 0.3);
        }

        .btn-pdf {
            background: linear-gradient(135deg, rgba(206, 32, 41, 0.2), rgba(206, 32, 41, 0.1));
            border: 1px solid rgba(206, 32, 41, 0.4);
            color: var(--bpez-dark-blue);
            padding: 12px 35px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s;
            cursor: pointer;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            justify-content: center;
        }

        .btn-pdf:hover { 
            background: rgba(206, 32, 41, 0.3); 
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(206, 32, 41, 0.2);
        }

        .btn-back {
            background: rgba(108, 117, 125, 0.2);
            border: 1px solid rgba(108, 117, 125, 0.3);
            color: var(--bpez-dark-blue);
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
        }

        .btn-back:hover { 
            background: rgba(108, 117, 125, 0.3); 
            transform: translateY(-2px);
        }

        .info-filtros {
            background: rgba(0, 119, 182, 0.1);
            border-left: 4px solid var(--bpez-azul-alegre);
            padding: 12px 18px;
            border-radius: 12px;
            margin-top: 20px;
        }

        .info-filtros p {
            margin: 0;
            color: var(--bpez-dark-blue);
            font-size: 0.8rem;
        }

        /* Estilos específicos para documentos */
        .documento-item {
            padding: 12px 18px;
            cursor: pointer;
            transition: all 0.2s;
            border-bottom: 1px solid rgba(0, 119, 182, 0.1);
        }

        .documento-item:hover {
            background: rgba(0, 119, 182, 0.1);
        }

        .documento-item-header {
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
            gap: 10px;
            margin-bottom: 6px;
        }

        .documento-titulo {
            font-weight: 700;
            color: #003366;
            font-size: 0.95rem;
        }

        .documento-tipo {
            font-size: 0.7rem;
            color: #0077B6;
            background: rgba(0, 119, 182, 0.1);
            padding: 2px 8px;
            border-radius: 20px;
        }

        .documento-item-details {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 0.7rem;
            color: #2c5a7a;
        }

        .documento-descripcion {
            font-size: 0.7rem;
            color: #6c757d;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px dashed rgba(0, 119, 182, 0.2);
        }

        .documento-gaceta {
            font-size: 0.7rem;
            color: #CE2029;
            margin-top: 3px;
        }

        .documento-badge {
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 0.65rem;
            font-weight: 600;
        }

        .estado-aprobado { background: #28a745; color: white; }
        .estado-pendiente { background: #ffc107; color: #003366; }
        .estado-rechazado { background: #dc3545; color: white; }

        .documento-seleccionado {
            background: rgba(0, 119, 182, 0.15);
            border-radius: 15px;
            padding: 10px 15px;
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .documento-seleccionado span {
            color: #003366;
            font-size: 0.85rem;
        }

        .documento-seleccionado .documento-badge {
            margin-left: 8px;
        }

        .documento-limpiar {
            background: rgba(206, 32, 41, 0.15);
            border: none;
            border-radius: 50px;
            padding: 5px 12px;
            color: #CE2029;
            cursor: pointer;
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .documento-limpiar:hover {
            background: rgba(206, 32, 41, 0.3);
        }

        .text-center { text-align: center; }
        .mt-3 { margin-top: 1rem; }

        @media (max-width: 768px) {
            .main-content { padding: calc(var(--navbar-height) + 15px) 15px 30px 15px; }
            .card-glass { padding: 25px; }
            .filtros-row { flex-direction: column; gap: 15px; }
            .documento-item-header { flex-direction: column; gap: 4px; margin-bottom: 8px; }
            .documento-item-details { flex-direction: column; gap: 6px; }
            .documento-seleccionado { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/navbar.php'; ?>

<div class="main-content">
    <div class="reporte-container">
        
        <div class="card-glass">
            <div class="title-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <h1 class="section-title"><?php echo $titulo_pagina; ?></h1>
            <p class="descripcion-text"><?php echo $descripcion_pagina; ?></p>
            
            <form id="formReporteEspecifico" method="POST" action="/modules/admin/reporte_especifico.php" target="_blank">
                <div class="filtros-container">
                    
                    <!-- FILTROS DE FECHA -->
                    <div class="filtros-row">
                        <div class="filtro-group">
                            <label><i class="fas fa-calendar-alt me-1"></i> Año</label>
                            <select name="anio" class="filtro-select">
                                <option value="">Todos los años</option>
                                <?php foreach ($anos_disponibles as $anio): ?>
                                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="filtro-group">
                            <label><i class="fas fa-calendar-week me-1"></i> Mes</label>
                            <select name="mes" class="filtro-select">
                                <option value="">Todos los meses</option>
                                <?php
                                $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?php echo $m; ?>"><?php echo $meses[$m]; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="filtro-group">
                            <label><i class="fas fa-calendar-day me-1"></i> Día</label>
                            <select name="dia" class="filtro-select">
                                <option value="">Todos los días</option>
                                <?php for ($d = 1; $d <= 31; $d++): ?>
                                    <option value="<?php echo $d; ?>"><?php echo $d; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- FILTRO POR USUARIO CON BUSCADOR -->
                    <div class="filtros-row">
                        <div class="filtro-group">
                            <label><i class="fas fa-user me-1"></i> Usuario (nombre o cédula)</label>
                            <div class="buscador-wrapper">
                                <input type="text" 
                                       id="usuarioBusqueda" 
                                       class="buscador-input" 
                                       placeholder="Escribe nombre, apellido o cédula..."
                                       autocomplete="off">
                                <div id="suggestionsContainer" class="buscador-suggestions"></div>
                            </div>
                            <input type="hidden" name="usuario_busqueda" id="usuarioSeleccionado" value="">
                            <div id="selectedUserInfo"></div>
                        </div>
                    </div>
                    
                    <!-- FILTROS AVANZADOS -->
                    <div class="filtros-row">
                        <div class="filtro-group">
                            <label><i class="fas fa-tasks me-1"></i> Tipo de Acción</label>
                            <select name="accion" class="filtro-select">
                                <option value="">Todas las acciones</option>
                                <option value="login_exitoso">Inicio de sesión exitoso</option>
                                <option value="login_fallido">Intento de inicio fallido</option>
                                <option value="subir_documento">Subir documento</option>
                                <option value="descargar_documento">Descargar documento</option>
                                <option value="editar_documento">Editar documento</option>
                                <option value="eliminar_documento">Eliminar documento</option>
                                <option value="crear_usuario">Crear usuario</option>
                                <option value="editar_usuario">Editar usuario</option>
                                <option value="eliminar_usuario">Eliminar usuario</option>
                                <option value="cambiar_estado_usuario">Cambiar estado de usuario</option>
                                <option value="cambiar_rol_usuario">Cambiar rol de usuario</option>
                                <option value="generar_reporte_pdf">Generar reporte PDF</option>
                                <option value="generar_reporte_detallado">Generar reporte detallado</option>
                                <option value="exportar_backup">Exportar backup</option>
                                <option value="importar_backup">Importar backup</option>
                            </select>
                        </div>
                        <div class="filtro-group">
                            <label><i class="fas fa-database me-1"></i> Módulo / Tabla</label>
                            <select name="modulo" class="filtro-select">
                                <option value="">Todos los módulos</option>
                                <?php foreach ($modulos_disponibles as $modulo): ?>
                                    <option value="<?php echo $modulo; ?>"><?php echo strtoupper($modulo); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- FILTRO POR DOCUMENTO CON BUSCADOR EN TIEMPO REAL -->
                    <div class="filtros-row">
                        <div class="filtro-group">
                            <label><i class="fas fa-file-alt me-1"></i> Documento (título)</label>
                            <div class="buscador-wrapper">
                                <input type="text" 
                                       id="documentoBusqueda" 
                                       class="buscador-input" 
                                       placeholder="Buscar por título, tipo, descripción..."
                                       autocomplete="off">
                                <div id="documentoSuggestions" class="buscador-suggestions"></div>
                            </div>
                            <input type="hidden" name="documento" id="documentoSeleccionado" value="">
                            <div id="selectedDocumentInfo"></div>
                        </div>
                    </div>
                    
                    <button type="submit" name="generar_pdf" value="1" class="btn-pdf" id="btnGenerarPDF">
                        <i class="fas fa-file-pdf"></i> GENERAR REPORTE ESPECÍFICO
                    </button>
                </div>
            </form>
            
            <div class="info-filtros">
                <p><i class="fas fa-info-circle"></i> <strong>Reporte Específico:</strong> Información detallada con filtros avanzados. Puede filtrar por fecha, usuario, tipo de acción, módulo y documento específico.</p>
                <p class="mt-3"><i class="fas fa-chart-line"></i> <strong>Contenido del reporte:</strong> Listado completo de acciones, resumen por acción, módulo, usuario y documentos más consultados.</p>
            </div>
            
            <div class="text-center">
                <a href="/modules/admin/reportes.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Volver a Reportes
                </a>
            </div>
        </div>
        
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>

<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/background-animation.js"></script>
<script src="/assets/js/buscador_usuarios.js"></script>
<script src="/assets/js/buscador_documentos.js"></script>

<script>
// Inicializar el buscador de usuarios
const buscador = new BuscadorUsuarios({
    inputId: 'usuarioBusqueda',
    resultsContainerId: 'suggestionsContainer',
    hiddenFieldId: 'usuarioSeleccionado',
    selectedInfoId: 'selectedUserInfo',
    onSelect: function(usuario) {
        console.log('Usuario seleccionado:', usuario);
    }
});

// Inicializar el buscador de documentos
const buscadorDocumentos = new BuscadorDocumentos({
    inputId: 'documentoBusqueda',
    resultsContainerId: 'documentoSuggestions',
    hiddenFieldId: 'documentoSeleccionado',
    selectedInfoId: 'selectedDocumentInfo',
    onSelect: function(documento) {
        console.log('Documento seleccionado:', documento);
    }
});

// Validación de fechas para el formulario
document.getElementById('formReporteEspecifico').addEventListener('submit', function(e) {
    const anio = this.querySelector('select[name="anio"]').value;
    const mes = this.querySelector('select[name="mes"]').value;
    const dia = this.querySelector('select[name="dia"]').value;
    
    if ((mes || dia) && !anio) {
        e.preventDefault();
        alert('⚠️ ATENCIÓN: Para filtrar por mes o día, debe seleccionar un año.\n\nSe utilizará el año actual (' + new Date().getFullYear() + ') para generar el reporte.');
        this.querySelector('select[name="anio"]').value = new Date().getFullYear();
        setTimeout(() => { this.submit(); }, 100);
        return false;
    }
    return true;
});
</script>

</body>
</html>