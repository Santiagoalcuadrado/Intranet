<?php
/**
 * reporte_general.php
 * BACKEND para el Reporte General del Sistema con filtros por fecha
 * Ubicación: /modules/admin/reporte_general.php
 */

// ===== VERIFICAR SESIÓN Y ROL =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VERIFICAR QUE SEA ADMINISTRADOR =====
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: /assets/frontend/principal_frontend.php?error=acceso_denegado");
    exit();
}

// ===== INCLUIR CONEXIÓN A BD =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexiondb.php';

// ===== INCLUIR TCPDF =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/tcpdf/tcpdf.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Reporte General";
$descripcion_pagina = "Reporte consolidado de todas las actividades del sistema";

// ===== OBTENER FILTROS CON VALIDACIÓN =====
$filtro_anio = isset($_POST['anio']) && $_POST['anio'] !== '' ? (int)$_POST['anio'] : null;
$filtro_mes = isset($_POST['mes']) && $_POST['mes'] !== '' ? (int)$_POST['mes'] : null;
$filtro_dia = isset($_POST['dia']) && $_POST['dia'] !== '' ? (int)$_POST['dia'] : null;

// ===== VALIDACIÓN: Si hay mes o día pero no año, usar año actual =====
$mensaje_advertencia = null;
if (($filtro_mes || $filtro_dia) && !$filtro_anio) {
    $filtro_anio = date('Y');
    $mensaje_advertencia = "No se seleccionó un año. Se usará el año actual (" . date('Y') . ") para el filtro.";
}

// ===== CONSTRUIR CONDICIONES DE FECHA =====
$fecha_inicio = null;
$fecha_fin = null;
$periodo_texto = "";

if ($filtro_dia && $filtro_mes && $filtro_anio) {
    // Día específico
    $fecha_inicio = sprintf("%04d-%02d-%02d 00:00:00", $filtro_anio, $filtro_mes, $filtro_dia);
    $fecha_fin = sprintf("%04d-%02d-%02d 23:59:59", $filtro_anio, $filtro_mes, $filtro_dia);
    $periodo_texto = date('d/m/Y', strtotime($fecha_inicio));
    
} elseif ($filtro_mes && $filtro_anio) {
    // Mes específico de un año
    $fecha_inicio = sprintf("%04d-%02d-01 00:00:00", $filtro_anio, $filtro_mes);
    $ultimo_dia = date('t', strtotime($fecha_inicio));
    $fecha_fin = sprintf("%04d-%02d-%02d 23:59:59", $filtro_anio, $filtro_mes, $ultimo_dia);
    $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $periodo_texto = $meses[$filtro_mes] . " de $filtro_anio";
    
} elseif ($filtro_anio) {
    // Solo año
    $fecha_inicio = sprintf("%04d-01-01 00:00:00", $filtro_anio);
    $fecha_fin = sprintf("%04d-12-31 23:59:59", $filtro_anio);
    $periodo_texto = "Año $filtro_anio";
    
} else {
    // Sin filtros - todos los datos
    $periodo_texto = "Todo el historial";
}

// ===== VALIDAR PERÍODO FUTURO =====
$periodo_futuro = false;
$fecha_actual = new DateTime();

if ($fecha_inicio) {
    $fecha_inicio_obj = new DateTime($fecha_inicio);
    if ($fecha_inicio_obj > $fecha_actual) {
        $periodo_futuro = true;
        if (empty($mensaje_advertencia)) {
            $mensaje_advertencia = "El período seleccionado (" . $periodo_texto . ") es futuro. No hay datos disponibles.";
        }
    }
}

// ===== INICIALIZAR VARIABLES PARA DATOS =====
$datos = [];

try {
    // ========== 1. USUARIOS ==========
    if ($fecha_inicio && $fecha_fin && !$periodo_futuro) {
        $stmt = $pdo->prepare("
            SELECT id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                   cedula, email, telefono, estado, fecha_registro, ultimo_login, id_rol
            FROM usuarios 
            WHERE fecha_registro BETWEEN ? AND ?
            ORDER BY fecha_registro DESC
        ");
        $stmt->execute([$fecha_inicio, $fecha_fin]);
        $datos['usuarios'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos['total_usuarios_periodo'] = count($datos['usuarios']);
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM usuarios WHERE estado = 'Activo' AND fecha_registro BETWEEN ? AND ?");
        $stmt->execute([$fecha_inicio, $fecha_fin]);
        $datos['usuarios_activos'] = $stmt->fetch()['total'];
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM usuarios WHERE estado = 'Inactivo' AND fecha_registro BETWEEN ? AND ?");
        $stmt->execute([$fecha_inicio, $fecha_fin]);
        $datos['usuarios_inactivos'] = $stmt->fetch()['total'];
    } else {
        $stmt = $pdo->query("
            SELECT id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                   cedula, email, telefono, estado, fecha_registro, ultimo_login, id_rol
            FROM usuarios 
            ORDER BY fecha_registro DESC
        ");
        $datos['usuarios'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos['total_usuarios_periodo'] = count($datos['usuarios']);
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE estado = 'Activo'");
        $datos['usuarios_activos'] = $stmt->fetch()['total'];
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE estado = 'Inactivo'");
        $datos['usuarios_inactivos'] = $stmt->fetch()['total'];
    }
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
    $datos['total_usuarios_general'] = $stmt->fetch()['total'];
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE id_rol = 1");
    $datos['total_administradores'] = $stmt->fetch()['total'];
    
    // ========== 2. DOCUMENTOS ==========
    if ($fecha_inicio && $fecha_fin && !$periodo_futuro) {
        $stmt = $pdo->prepare("
            SELECT id, titulo, tipo_documento, descripcion, gaceta, estado, 
                   archivo_nombre, creado_por_nombre, fecha_creacion
            FROM documentos 
            WHERE eliminado = 0 AND fecha_creacion BETWEEN ? AND ?
            ORDER BY fecha_creacion DESC
        ");
        $stmt->execute([$fecha_inicio, $fecha_fin]);
        $datos['documentos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos['total_documentos_periodo'] = count($datos['documentos']);
        
        $stmt = $pdo->prepare("
            SELECT estado, COUNT(*) as total
            FROM documentos 
            WHERE eliminado = 0 AND fecha_creacion BETWEEN ? AND ?
            GROUP BY estado
        ");
        $stmt->execute([$fecha_inicio, $fecha_fin]);
        $datos['documentos_por_estado'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $pdo->query("
            SELECT id, titulo, tipo_documento, descripcion, gaceta, estado, 
                   archivo_nombre, creado_por_nombre, fecha_creacion
            FROM documentos 
            WHERE eliminado = 0
            ORDER BY fecha_creacion DESC
        ");
        $datos['documentos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos['total_documentos_periodo'] = count($datos['documentos']);
        
        $stmt = $pdo->query("
            SELECT estado, COUNT(*) as total
            FROM documentos 
            WHERE eliminado = 0
            GROUP BY estado
        ");
        $datos['documentos_por_estado'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM documentos WHERE eliminado = 0");
    $datos['total_documentos_general'] = $stmt->fetch()['total'];
    
    // ========== 3. LOGS (ACCIONES) ==========
    if ($fecha_inicio && $fecha_fin && !$periodo_futuro) {
        $stmt = $pdo->prepare("
            SELECT l.*, u.primer_nombre, u.primer_apellido
            FROM logs l
            JOIN usuarios u ON l.usuario_id = u.id
            WHERE l.fecha BETWEEN ? AND ?
            ORDER BY l.fecha DESC
        ");
        $stmt->execute([$fecha_inicio, $fecha_fin]);
        $datos['logs'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos['total_logs_periodo'] = count($datos['logs']);
        
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM logs WHERE fecha BETWEEN ? AND ?");
        $stmt->execute([$fecha_inicio, $fecha_fin]);
        $datos['total_logs_periodo_count'] = $stmt->fetch()['total'];
        
        // TODAS las acciones frecuentes (sin límite)
        $stmt = $pdo->prepare("
            SELECT accion, COUNT(*) as total
            FROM logs
            WHERE fecha BETWEEN ? AND ?
            GROUP BY accion
            ORDER BY total DESC
        ");
        $stmt->execute([$fecha_inicio, $fecha_fin]);
        $datos['acciones_frecuentes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // TODOS los usuarios activos (sin límite)
        $stmt = $pdo->prepare("
            SELECT u.primer_nombre, u.primer_apellido, u.cedula, u.id_rol, COUNT(l.id) as acciones
            FROM logs l
            JOIN usuarios u ON l.usuario_id = u.id
            WHERE l.fecha BETWEEN ? AND ?
            GROUP BY l.usuario_id
            ORDER BY acciones DESC
        ");
        $stmt->execute([$fecha_inicio, $fecha_fin]);
        $datos['usuarios_activos_todos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $stmt = $pdo->query("
            SELECT l.*, u.primer_nombre, u.primer_apellido
            FROM logs l
            JOIN usuarios u ON l.usuario_id = u.id
            ORDER BY l.fecha DESC
        ");
        $datos['logs'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $datos['total_logs_periodo'] = count($datos['logs']);
        
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM logs");
        $datos['total_logs_periodo_count'] = $stmt->fetch()['total'];
        
        // TODAS las acciones frecuentes (sin límite)
        $stmt = $pdo->query("
            SELECT accion, COUNT(*) as total
            FROM logs
            GROUP BY accion
            ORDER BY total DESC
        ");
        $datos['acciones_frecuentes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // TODOS los usuarios activos (sin límite)
        $stmt = $pdo->query("
            SELECT u.primer_nombre, u.primer_apellido, u.cedula, u.id_rol, COUNT(l.id) as acciones
            FROM logs l
            JOIN usuarios u ON l.usuario_id = u.id
            GROUP BY l.usuario_id
            ORDER BY acciones DESC
        ");
        $datos['usuarios_activos_todos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM logs");
    $datos['total_logs_general'] = $stmt->fetch()['total'];
    
    // ========== 4. INTENTOS DE LOGIN ==========
    if ($fecha_inicio && $fecha_fin && !$periodo_futuro) {
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM intentos_login WHERE ultimo_intento BETWEEN ? AND ?");
        $stmt->execute([$fecha_inicio, $fecha_fin]);
        $datos['intentos_fallidos_periodo'] = $stmt->fetch()['total'];
    } else {
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM intentos_login");
        $datos['intentos_fallidos_periodo'] = $stmt->fetch()['total'];
    }
    
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM intentos_login");
    $datos['intentos_fallidos_general'] = $stmt->fetch()['total'];
    
    $datos['fecha_generacion'] = date('d/m/Y H:i:s');
    $datos['periodo_texto'] = $periodo_texto;
    $datos['periodo_futuro'] = $periodo_futuro;
    $datos['mensaje_advertencia'] = $mensaje_advertencia;
    $datos['filtros'] = [
        'anio' => $filtro_anio,
        'mes' => $filtro_mes,
        'dia' => $filtro_dia,
        'fecha_inicio' => $fecha_inicio,
        'fecha_fin' => $fecha_fin
    ];
    
} catch (PDOException $e) {
    error_log("Error al generar reporte general: " . $e->getMessage());
    $datos = [
        'usuarios' => [],
        'documentos' => [],
        'logs' => [],
        'total_usuarios_periodo' => 0,
        'total_documentos_periodo' => 0,
        'total_logs_periodo' => 0,
        'periodo_texto' => 'Error al cargar datos',
        'fecha_generacion' => date('d/m/Y H:i:s'),
        'periodo_futuro' => false,
        'mensaje_advertencia' => null
    ];
}

// ===== FUNCIÓN PARA GENERAR PDF =====
function generarPDF($datos, $usuario) {
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    $pdf->SetCreator('Intranet BPEZ');
    $pdf->SetAuthor($usuario['nombre'] . ' (' . $usuario['rol'] . ')');
    $pdf->SetTitle('Reporte General - Intranet BPEZ');
    $pdf->SetSubject('Reporte General del Sistema');
    
    $pdf->SetMargins(15, 20, 15);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);
    $pdf->AddPage();
    
    // ===== HEADER =====
    $html_header = '
    <div style="text-align: center; border-bottom: 2px solid #003366; padding-bottom: 10px;">
        <h1 style="color: #003366;">Sistema Intranet - Biblioteca Pública del Estado Zulia</h1>
        <h2 style="color: #0077B6;">"María Calcaño"</h2>
        <h3 style="color: #CE2029;">Reporte General del Sistema</h3>
        <h4>Periodo: ' . htmlspecialchars($datos['periodo_texto']) . '</h4>
    </div>
    <br>';
    $pdf->writeHTML($html_header, true, false, true, false, '');
    
    // ===== ADVERTENCIA SI APLICA =====
    if (!empty($datos['mensaje_advertencia'])) {
        $html_advertencia = '
        <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 10px; margin-bottom: 15px;">
            <p style="color: #856404; margin: 0;"><strong><i class="fas fa-info-circle"></i> Nota:</strong> ' . htmlspecialchars($datos['mensaje_advertencia']) . '</p>
        </div>
        <br>';
        $pdf->writeHTML($html_advertencia, true, false, true, false, '');
    }
    
    // ===== INFORMACIÓN DE GENERACIÓN =====
    $html_info = '
    <table border="0" cellpadding="5" style="background-color: #f0f8ff;">
            <tr>
                <td><strong>Generado por:</strong></td>
                <td>' . htmlspecialchars($usuario['nombre']) . '</td>
                <td><strong>Cédula:</strong></td>
                <td>' . htmlspecialchars($usuario['cedula']) . '</td>
            </tr>
            <tr>
                <td><strong>Rol:</strong></td>
                <td>' . htmlspecialchars($usuario['rol']) . '</td>
                <td><strong>Fecha/Hora:</strong></td>
                <td>' . date('d/m/Y H:i:s') . '</td>
            </tr>
        </table>
    <br><br>';
    $pdf->writeHTML($html_info, true, false, true, false, '');
    
    // ===== RESUMEN DEL PERÍODO CON MENSAJES AMIGABLES =====
    $html_resumen = '
    <h3 style="color: #003366; border-left: 4px solid #CE2029; padding-left: 10px;">RESUMEN DEL PERIODO</h3>';
    
    // Si es período futuro
    if ($datos['periodo_futuro']) {
        $html_resumen .= '
        <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 10px 0;">
            <p style="color: #856404; margin: 0;">
                <strong><i class="fas fa-calendar-alt"></i> Período futuro:</strong> 
                El período seleccionado (' . htmlspecialchars($datos['periodo_texto']) . ') es posterior a la fecha actual.<br>
                No hay registros disponibles para este período.
            </p>
        </div>';
    } 
    // Si hay datos
    elseif ($datos['total_usuarios_periodo'] > 0 || $datos['total_documentos_periodo'] > 0 || ($datos['total_logs_periodo_count'] ?? 0) > 0) {
        $html_resumen .= '
        <table border="1" cellpadding="6" style="border-collapse: collapse; width: 100%;">
            <tr style="background-color: #76C7C0;"><th>Metrica</th><th>Valor</th></tr>
            <tr><td>Usuarios registrados</td><td>' . $datos['total_usuarios_periodo'] . '</td></tr>
            <tr><td>Documentos subidos</td><td>' . $datos['total_documentos_periodo'] . '</td></tr>
            <tr><td>Acciones realizadas</td><td>' . ($datos['total_logs_periodo_count'] ?? count($datos['logs'])) . '</td></tr>
            <tr><td>Intentos fallidos de login</td><td>' . $datos['intentos_fallidos_periodo'] . '</td></tr>
        </table>';
    } 
    // Sin datos pero período válido
    else {
        $html_resumen .= '
        <div style="background-color: #e7f3ff; border-left: 4px solid #0077B6; padding: 15px; margin: 10px 0;">
            <p style="color: #003366; margin: 0;">
                <strong><i class="fas fa-info-circle"></i> Sin datos:</strong> 
                No se encontraron registros para el período seleccionado (' . htmlspecialchars($datos['periodo_texto']) . ').
            </p>
        </div>';
    }
    $html_resumen .= '<br>';
    $pdf->writeHTML($html_resumen, true, false, true, false, '');
    
    // ===== ESTADÍSTICAS GENERALES =====
    $html_stats = '
    <h3 style="color: #003366; border-left: 4px solid #CE2029; padding-left: 10px;">ESTADISTICAS GENERALES</h3>
    <table border="1" cellpadding="6" style="border-collapse: collapse; width: 100%;">
        <tr style="background-color: #76C7C0;"><th>Metrica</th><th>Valor</th></tr>
        <tr><td>Total Usuarios (sistema)</td><td>' . $datos['total_usuarios_general'] . '</td></tr>
        <tr><td>Usuarios Activos</td><td>' . $datos['usuarios_activos'] . '</td></tr>
        <tr><td>Usuarios Inactivos</td><td>' . $datos['usuarios_inactivos'] . '</td></tr>
        <tr><td>Administradores</td><td>' . $datos['total_administradores'] . '</td></tr>
        <tr><td>Total Documentos (sistema)</td><td>' . $datos['total_documentos_general'] . '</td></tr>
        <tr><td>Total Acciones Registradas</td><td>' . $datos['total_logs_general'] . '</td></tr>
        <tr><td>Intentos Fallidos Totales</td><td>' . $datos['intentos_fallidos_general'] . '</td></tr>
    </table>
    <br>';
    $pdf->writeHTML($html_stats, true, false, true, false, '');
    
    // ===== DOCUMENTOS POR ESTADO =====
    if (!empty($datos['documentos_por_estado']) && !$datos['periodo_futuro']) {
        $html_docs = '
        <h3 style="color: #003366; border-left: 4px solid #CE2029; padding-left: 10px;">DOCUMENTOS POR ESTADO</h3>
        <table border="1" cellpadding="6" style="border-collapse: collapse; width: 100%;">
            <tr style="background-color: #76C7C0;"><th>Estado</th><th>Cantidad</th></tr>';
        $estados_nombres = ['aprobado' => 'Aprobados', 'pendiente' => 'En Revision', 'rechazado' => 'No Disponibles'];
        foreach ($datos['documentos_por_estado'] as $doc) {
            $nombre = $estados_nombres[$doc['estado']] ?? ucfirst($doc['estado']);
            $html_docs .= '<tr><td>' . $nombre . '</td><td>' . $doc['total'] . '</td></tr>';
        }
        $html_docs .= '</table><br>';
        $pdf->writeHTML($html_docs, true, false, true, false, '');
    }
    
    // ===== TODOS LOS USUARIOS ACTIVOS =====
    if (!empty($datos['usuarios_activos_todos']) && !$datos['periodo_futuro']) {
        $html_usuarios = '
        <h3 style="color: #003366; border-left: 4px solid #CE2029; padding-left: 10px;">ACTIVIDAD POR USUARIO</h3>
        <table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
            <tr style="background-color: #76C7C0;"><th>Usuario</th><th>Cedula</th><th>Rol</th><th>Acciones Realizadas</th></tr>';
        foreach ($datos['usuarios_activos_todos'] as $user) {
            $rol_nombre = ($user['id_rol'] == 1) ? 'Administrador' : 'Usuario';
            $html_usuarios .= '<tr>
                <td>' . htmlspecialchars($user['primer_nombre'] . ' ' . $user['primer_apellido']) . '</td>
                <td>' . htmlspecialchars($user['cedula']) . '</td>
                <td>' . $rol_nombre . '</td>
                <td>' . $user['acciones'] . '</td>
            </tr>';
        }
        $html_usuarios .= '</table><br>';
        $pdf->writeHTML($html_usuarios, true, false, true, false, '');
    }
    
    // ===== ACCIONES MÁS FRECUENTES =====
    if (!empty($datos['acciones_frecuentes']) && !$datos['periodo_futuro']) {
        $html_acciones = '
        <h3 style="color: #003366; border-left: 4px solid #CE2029; padding-left: 10px;">ACCIONES MAS FRECUENTES</h3>
        <table border="1" cellpadding="5" style="border-collapse: collapse; width: 100%;">
            <tr style="background-color: #76C7C0;"><th>Accion</th><th>Veces realizada</th></tr>';
        foreach ($datos['acciones_frecuentes'] as $accion) {
            $html_acciones .= '<tr><td>' . htmlspecialchars($accion['accion']) . '</td><td>' . $accion['total'] . '</td></tr>';
        }
        $html_acciones .= '</table><br>';
        $pdf->writeHTML($html_acciones, true, false, true, false, '');
    }
    
    // ===== LISTA DE USUARIOS (RESUMEN) =====
    if (!empty($datos['usuarios']) && !$datos['periodo_futuro']) {
        $html_lista_usuarios = '
        <h3 style="color: #003366; border-left: 4px solid #CE2029; padding-left: 10px;">LISTA DE USUARIOS (' . count($datos['usuarios']) . ' registros)</h3>
        <table border="1" cellpadding="4" style="border-collapse: collapse; width: 100%; font-size: 8pt;">
            <tr style="background-color: #76C7C0;"><th>Cedula</th><th>Nombre Completo</th><th>Email</th><th>Telefono</th><th>Estado</th></tr>';
        foreach ($datos['usuarios'] as $user) {
            $nombre_completo = trim($user['primer_nombre'] . ' ' . ($user['segundo_nombre'] ?? '') . ' ' . 
                                 $user['primer_apellido'] . ' ' . ($user['segundo_apellido'] ?? ''));
            $html_lista_usuarios .= '<tr>
                <td>' . htmlspecialchars($user['cedula']) . '</td>
                <td>' . htmlspecialchars($nombre_completo) . '</td>
                <td>' . htmlspecialchars($user['email']) . '</td>
                <td>' . htmlspecialchars($user['telefono']) . '</td>
                <td>' . htmlspecialchars($user['estado']) . '</td>
            </tr>';
        }
        $html_lista_usuarios .= '</table><br>';
        $pdf->writeHTML($html_lista_usuarios, true, false, true, false, '');
    }
    
    // ===== LISTA DE DOCUMENTOS =====
    if (!empty($datos['documentos']) && !$datos['periodo_futuro']) {
        $html_lista_documentos = '
        <h3 style="color: #003366; border-left: 4px solid #CE2029; padding-left: 10px;">LISTA DE DOCUMENTOS (' . count($datos['documentos']) . ' registros)</h3>
        <table border="1" cellpadding="4" style="border-collapse: collapse; width: 100%; font-size: 8pt;">
            <tr style="background-color: #76C7C0;"><th>Titulo</th><th>Tipo</th><th>Estado</th><th>Subido por</th><th>Fecha</th></tr>';
        foreach ($datos['documentos'] as $doc) {
            $html_lista_documentos .= '<tr>
                <td>' . htmlspecialchars(substr($doc['titulo'], 0, 60)) . (strlen($doc['titulo']) > 60 ? '...' : '') . '</td>
                <td>' . htmlspecialchars($doc['tipo_documento']) . '</td>
                <td>' . htmlspecialchars($doc['estado']) . '</td>
                <td>' . htmlspecialchars($doc['creado_por_nombre']) . '</td>
                <td>' . date('d/m/Y', strtotime($doc['fecha_creacion'])) . '</td>
            </tr>';
        }
        $html_lista_documentos .= '</table><br>';
        $pdf->writeHTML($html_lista_documentos, true, false, true, false, '');
    }
    
    // ===== TODAS LAS ACCIONES (LOGS) =====
    if (!empty($datos['logs']) && !$datos['periodo_futuro']) {
        $html_logs = '
        <h3 style="color: #003366; border-left: 4px solid #CE2029; padding-left: 10px;">REGISTRO DE ACCIONES (' . count($datos['logs']) . ' registros)</h3>
        <table border="1" cellpadding="4" style="border-collapse: collapse; width: 100%; font-size: 7pt;">
            <tr style="background-color: #76C7C0;"><th>Fecha</th><th>Usuario</th><th>Accion</th><th>Tabla</th><th>Registro</th></tr>';
        foreach ($datos['logs'] as $log) {
            $html_logs .= '<tr>
                <td>' . date('d/m/Y H:i', strtotime($log['fecha'])) . '</td>
                <td>' . htmlspecialchars($log['primer_nombre'] . ' ' . $log['primer_apellido']) . '</td>
                <td>' . htmlspecialchars($log['accion']) . '</td>
                <td>' . htmlspecialchars($log['tabla']) . '</td>
                <td>' . htmlspecialchars(substr($log['registro_titulo'] ?? 'ID: ' . $log['registro_id'], 0, 40)) . '</td>
            </tr>';
        }
        $html_logs .= '</table><br>';
        $pdf->writeHTML($html_logs, true, false, true, false, '');
    }
    
    // ===== FOOTER CON QUIEN GENERÓ =====
    $pdf->writeHTML('<hr><p style="text-align: center; font-size: 8pt; color: #666;">Reporte generado por: ' . htmlspecialchars($usuario['nombre']) . ' (Cedula: ' . htmlspecialchars($usuario['cedula']) . ') - ' . date('d/m/Y H:i:s') . '</p>', true, false, true, false, '');
    
    return $pdf;
}

// ===== FUNCIÓN PARA REGISTRAR EN LOGS =====
function registrarGeneracionPDF($pdo, $usuario_id, $usuario_nombre, $usuario_cedula, $usuario_rol, $datos) {
    try {
        $sql = "INSERT INTO logs 
                (usuario_id, usuario_nombre, usuario_cedula, usuario_rol, accion, tabla, registro_id, registro_titulo, detalle, fecha) 
                VALUES (?, ?, ?, ?, 'generar_reporte_pdf', 'reportes', 0, 'Reporte General', ?, NOW())";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            $usuario_id,
            $usuario_nombre,
            $usuario_cedula,
            $usuario_rol,
            "Genero reporte general en PDF - Periodo: {$datos['periodo_texto']} - Usuarios: {$datos['total_usuarios_periodo']}, Documentos: {$datos['total_documentos_periodo']}, Acciones: " . ($datos['total_logs_periodo_count'] ?? count($datos['logs']))
        ]);
    } catch (PDOException $e) {
        error_log("Error al registrar log: " . $e->getMessage());   
        return false;
    }
}

// ===== PROCESAR GENERACIÓN DE PDF =====
$generar_pdf = isset($_POST['generar_pdf']) ? true : false;

if ($generar_pdf) {
    $usuario_pdf = [
        'nombre' => $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido'],
        'cedula' => $_SESSION['cedula'] ?? '',
        'rol' => $_SESSION['rol']
    ];
    
    $pdf = generarPDF($datos, $usuario_pdf);
    registrarGeneracionPDF($pdo, $_SESSION['user_id'], $usuario_pdf['nombre'], $usuario_pdf['cedula'], $usuario_pdf['rol'], $datos);
    
    $pdf->Output('reporte_general_' . date('Ymd_His') . '.pdf', 'D');
    exit();
}

include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/reporte_general_frontend.php';
exit();
?>