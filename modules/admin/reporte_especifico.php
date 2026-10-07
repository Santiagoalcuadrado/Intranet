<?php
/**
 * reporte_especifico.php
 * BACKEND para el Reporte Específico del Sistema
 * Filtros combinables: fechas, usuario, acción, módulo, documento
 * Ubicación: /modules/admin/reporte_especifico.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VERIFICAR QUE EL USUARIO SEA ADMINISTRADOR =====
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    header("Location: /modules/principal_backend/principal_backend.php?error=acceso_denegado");
    exit();
}

// ===== INCLUIR CONEXIÓN A LA BASE DE DATOS =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexiondb.php';

// ===== INCLUIR TCPDF =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/tcpdf/tcpdf.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Reporte Específico";
$descripcion_pagina = "Reporte detallado con filtros combinables: fechas, usuario, acción, módulo y documento";

// ===== OBTENER FILTROS =====
$filtro_anio = isset($_POST['anio']) && $_POST['anio'] !== '' ? (int)$_POST['anio'] : null;
$filtro_mes = isset($_POST['mes']) && $_POST['mes'] !== '' ? (int)$_POST['mes'] : null;
$filtro_dia = isset($_POST['dia']) && $_POST['dia'] !== '' ? (int)$_POST['dia'] : null;
$usuario_busqueda = isset($_POST['usuario_busqueda']) && $_POST['usuario_busqueda'] !== '' ? trim($_POST['usuario_busqueda']) : null;
$filtro_accion = isset($_POST['accion']) && $_POST['accion'] !== '' ? $_POST['accion'] : null;
$filtro_modulo = isset($_POST['modulo']) && $_POST['modulo'] !== '' ? $_POST['modulo'] : null;
$filtro_documento = isset($_POST['documento']) && $_POST['documento'] !== '' ? trim($_POST['documento']) : null;

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
    $fecha_inicio = sprintf("%04d-%02d-%02d 00:00:00", $filtro_anio, $filtro_mes, $filtro_dia);
    $fecha_fin = sprintf("%04d-%02d-%02d 23:59:59", $filtro_anio, $filtro_mes, $filtro_dia);
    $periodo_texto = date('d/m/Y', strtotime($fecha_inicio));
} elseif ($filtro_mes && $filtro_anio) {
    $fecha_inicio = sprintf("%04d-%02d-01 00:00:00", $filtro_anio, $filtro_mes);
    $ultimo_dia = date('t', strtotime($fecha_inicio));
    $fecha_fin = sprintf("%04d-%02d-%02d 23:59:59", $filtro_anio, $filtro_mes, $ultimo_dia);
    $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $periodo_texto = $meses[$filtro_mes] . " de $filtro_anio";
} elseif ($filtro_anio) {
    $fecha_inicio = sprintf("%04d-01-01 00:00:00", $filtro_anio);
    $fecha_fin = sprintf("%04d-12-31 23:59:59", $filtro_anio);
    $periodo_texto = "Año $filtro_anio";
} else {
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

// ===== INICIALIZAR VARIABLES =====
$datos = [];
$logs = [];
$documentos_info = [];

try {
    // ===== CONSTRUIR CONSULTA SQL CON FILTROS COMBINABLES =====
    $sql = "
        SELECT 
            l.id,
            l.fecha,
            l.accion,
            l.tabla,
            l.registro_id,
            l.registro_titulo,
            l.detalle,
            u.id as usuario_id,
            u.primer_nombre,
            u.segundo_nombre,
            u.primer_apellido,
            u.segundo_apellido,
            u.cedula,
            u.email
        FROM logs l
        INNER JOIN usuarios u ON l.usuario_id = u.id
        WHERE 1=1
    ";
    
    $params = [];
    
    // Filtro de fecha (si se selecciona)
    if ($fecha_inicio && $fecha_fin && !$periodo_futuro) {
        $sql .= " AND l.fecha BETWEEN ? AND ?";
        $params[] = $fecha_inicio;
        $params[] = $fecha_fin;
    }
    
    // Filtro de usuario (si se selecciona)
    if ($usuario_busqueda) {
        $sql .= " AND (
            u.cedula LIKE ? 
            OR u.primer_nombre LIKE ?
            OR u.primer_apellido LIKE ?
            OR CONCAT(u.primer_nombre, ' ', u.primer_apellido) LIKE ?
        )";
        $busqueda = "%$usuario_busqueda%";
        $params[] = $busqueda;
        $params[] = $busqueda;
        $params[] = $busqueda;
        $params[] = $busqueda;
    }
    
    // Filtro de acción (si se selecciona)
    if ($filtro_accion) {
        $sql .= " AND l.accion = ?";
        $params[] = $filtro_accion;
    }
    
    // Filtro de módulo (si se selecciona)
    if ($filtro_modulo) {
        $sql .= " AND l.tabla = ?";
        $params[] = $filtro_modulo;
    }
    
    // ===== FILTRO DE DOCUMENTO (MEJORADO) =====
    // Cuando se selecciona un documento, busca en registro_titulo y detalle
    if ($filtro_documento) {
        $sql .= " AND (l.registro_titulo LIKE ? OR l.detalle LIKE ?)";
        $doc_busqueda = "%$filtro_documento%";
        $params[] = $doc_busqueda;
        $params[] = $doc_busqueda;
    }
    
    $sql .= " ORDER BY l.fecha DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== OBTENER INFORMACIÓN ADICIONAL DE DOCUMENTOS =====
    $documentos_ids = [];
    foreach ($logs as $log) {
        if ($log['tabla'] === 'documentos' && $log['registro_id']) {
            $documentos_ids[] = $log['registro_id'];
        }
    }
    
    if (!empty($documentos_ids)) {
        $ids_unicos = array_unique($documentos_ids);
        $placeholders = implode(',', array_fill(0, count($ids_unicos), '?'));
        
        $sql_docs = "
            SELECT 
                id,
                titulo,
                tipo_documento,
                estado,
                creado_por_nombre,
                creado_por_cedula,
                DATE_FORMAT(fecha_creacion, '%d/%m/%Y %H:%i') as fecha_creacion_formateada,
                modificado_por_nombre,
                modificado_por_cedula,
                DATE_FORMAT(fecha_modificacion, '%d/%m/%Y %H:%i') as fecha_modificacion_formateada,
                eliminado,
                eliminado_por_nombre,
                eliminado_por_cedula,
                DATE_FORMAT(fecha_eliminacion, '%d/%m/%Y %H:%i') as fecha_eliminacion_formateada,
                motivo_eliminacion
            FROM documentos 
            WHERE id IN ($placeholders)
        ";
        
        $stmt_docs = $pdo->prepare($sql_docs);
        $stmt_docs->execute($ids_unicos);
        $docs_info = $stmt_docs->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($docs_info as $doc) {
            $documentos_info[$doc['id']] = $doc;
        }
    }
    
    $datos['total_registros'] = count($logs);
    $datos['periodo_texto'] = $periodo_texto;
    $datos['periodo_futuro'] = $periodo_futuro;
    $datos['mensaje_advertencia'] = $mensaje_advertencia;
    $datos['fecha_generacion'] = date('d/m/Y H:i:s');
    $datos['logs'] = $logs;
    $datos['documentos_info'] = $documentos_info;
    
    // ===== FILTROS APLICADOS (para mostrar en PDF) =====
    $filtros_texto = [];
    if ($periodo_texto != "Todo el historial") {
        $filtros_texto[] = "Período: $periodo_texto";
    }
    if ($usuario_busqueda) {
        $filtros_texto[] = "Usuario: $usuario_busqueda";
    }
    if ($filtro_accion) {
        $accion_nombres = [
            'login_exitoso' => 'Inicio de sesión exitoso',
            'login_fallido' => 'Intento fallido',
            'subir_documento' => 'Subir documento',
            'descargar_documento' => 'Descargar documento',
            'editar_documento' => 'Editar documento',
            'eliminar_documento' => 'Eliminar documento',
            'crear_usuario' => 'Crear usuario',
            'editar_usuario' => 'Editar usuario',
            'eliminar_usuario' => 'Eliminar usuario',
            'cambiar_estado_usuario' => 'Cambiar estado',
            'cambiar_rol_usuario' => 'Cambiar rol',
            'generar_reporte_pdf' => 'Generar reporte',
            'generar_reporte_detallado' => 'Reporte detallado',
            'exportar_backup' => 'Exportar backup',
            'importar_backup' => 'Importar backup',
        ];
        $filtros_texto[] = "Acción: " . ($accion_nombres[$filtro_accion] ?? $filtro_accion);
    }
    if ($filtro_modulo) {
        $filtros_texto[] = "Módulo: " . strtoupper($filtro_modulo);
    }
    if ($filtro_documento) {
        $filtros_texto[] = "Documento: $filtro_documento";
    }
    $datos['filtros_texto'] = $filtros_texto;
    
    // ===== RESÚMENES =====
    
    // Resumen por acción
    $acciones_resumen = [];
    foreach ($logs as $log) {
        $accion = $log['accion'];
        if (!isset($acciones_resumen[$accion])) $acciones_resumen[$accion] = 0;
        $acciones_resumen[$accion]++;
    }
    arsort($acciones_resumen);
    $datos['acciones_resumen'] = $acciones_resumen;
    
    // Resumen por módulo
    $modulos_resumen = [];
    foreach ($logs as $log) {
        $modulo = $log['tabla'];
        if (!isset($modulos_resumen[$modulo])) $modulos_resumen[$modulo] = 0;
        $modulos_resumen[$modulo]++;
    }
    arsort($modulos_resumen);
    $datos['modulos_resumen'] = $modulos_resumen;
    
    // Resumen por usuario
    $usuarios_resumen = [];
    foreach ($logs as $log) {
        $usuario = trim($log['primer_nombre'] . ' ' . $log['primer_apellido']) . ' (' . $log['cedula'] . ')';
        if (!isset($usuarios_resumen[$usuario])) $usuarios_resumen[$usuario] = 0;
        $usuarios_resumen[$usuario]++;
    }
    arsort($usuarios_resumen);
    $datos['usuarios_resumen'] = $usuarios_resumen;
    
    // Documentos más afectados (SOLO de la tabla documentos)
    $documentos_resumen = [];
    foreach ($logs as $log) {
        if ($log['tabla'] === 'documentos' && !empty($log['registro_titulo'])) {
            $doc = $log['registro_titulo'];
            if (!isset($documentos_resumen[$doc])) $documentos_resumen[$doc] = 0;
            $documentos_resumen[$doc]++;
        }
    }
    arsort($documentos_resumen);
    $datos['documentos_resumen'] = $documentos_resumen;
    
} catch (PDOException $e) {
    error_log("Error en reporte específico: " . $e->getMessage());
    $datos = [
        'total_registros' => 0,
        'periodo_texto' => 'Error al cargar datos',
        'fecha_generacion' => date('d/m/Y H:i:s'),
        'periodo_futuro' => false,
        'mensaje_advertencia' => null,
        'logs' => [],
        'documentos_info' => [],
        'filtros_texto' => [],
        'acciones_resumen' => [],
        'modulos_resumen' => [],
        'usuarios_resumen' => [],
        'documentos_resumen' => []
    ];
}

// ===== FUNCIÓN PARA GENERAR PDF (MANTENER IGUAL) =====
function generarPDFEspecifico($datos, $usuario) {
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    $pdf->SetCreator('Intranet BPEZ');
    $pdf->SetAuthor($usuario['nombre'] . ' (' . $usuario['rol'] . ')');
    $pdf->SetTitle('Reporte Específico - Intranet BPEZ');
    $pdf->SetSubject('Reporte Específico del Sistema');
    
    $pdf->SetMargins(15, 20, 15);
    $pdf->SetHeaderMargin(10);
    $pdf->SetFooterMargin(10);
    $pdf->AddPage();
    
    // ===== TÍTULO PRINCIPAL =====
    $pdf->SetTextColor(0, 51, 102);
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Sistema Intranet - Biblioteca Pública del Estado Zulia', 0, 1, 'C');
    $pdf->SetTextColor(0, 119, 182);
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 8, '"María Calcaño"', 0, 1, 'C');
    $pdf->SetTextColor(206, 32, 41);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 8, 'Reporte Específico del Sistema', 0, 1, 'C');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(0, 6, 'Periodo: ' . $datos['periodo_texto'], 0, 1, 'C');
    $pdf->Ln(5);
    
    // ===== ADVERTENCIA =====
    if (!empty($datos['mensaje_advertencia'])) {
        $pdf->SetFillColor(255, 243, 205);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->MultiCell(0, 5, 'Nota: ' . $datos['mensaje_advertencia'], 0, 'L', 1);
        $pdf->Ln(3);
    }
    
    // ===== INFORMACIÓN DE GENERACIÓN =====
    $pdf->SetTextColor(0, 51, 102);
    $pdf->SetFont('helvetica', 'B', 9);
    $pdf->Cell(0, 5, 'INFORMACIÓN DEL REPORTE', 0, 1, 'L');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->Cell(0, 5, 'Generado por: ' . $usuario['nombre'] . ' (Cédula: ' . $usuario['cedula'] . ')', 0, 1, 'L');
    $pdf->Cell(0, 5, 'Rol: ' . $usuario['rol'] . ' | Fecha/Hora: ' . $datos['fecha_generacion'], 0, 1, 'L');
    $pdf->Cell(0, 5, 'Total registros: ' . $datos['total_registros'] . ' | Tipo: Reporte Específico', 0, 1, 'L');
    $pdf->Ln(3);
    
    // ===== FILTROS APLICADOS =====
    if (!empty($datos['filtros_texto'])) {
        $pdf->SetFillColor(231, 243, 255);
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->Cell(0, 5, 'FILTROS APLICADOS', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 9);
        foreach ($datos['filtros_texto'] as $filtro) {
            $pdf->Cell(0, 5, '  • ' . $filtro, 0, 1, 'L');
        }
        $pdf->Ln(3);
    }
    
    // ===== RESUMEN DEL REPORTE =====
    $pdf->SetTextColor(0, 51, 102);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 6, 'RESUMEN DEL REPORTE', 0, 1, 'L');
    $pdf->SetTextColor(0, 0, 0);
    
    if ($datos['periodo_futuro']) {
        $pdf->SetFillColor(255, 243, 205);
        $pdf->MultiCell(0, 5, 'El período seleccionado es futuro. No hay datos disponibles.', 0, 'L', 1);
    } elseif ($datos['total_registros'] > 0) {
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell(0, 5, 'Total de acciones registradas: ' . $datos['total_registros'], 0, 1, 'L');
        $pdf->Ln(2);
        
        // Top acciones
        if (!empty($datos['acciones_resumen'])) {
            $pdf->SetTextColor(0, 119, 182);
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->Cell(0, 5, 'Acciones más frecuentes:', 0, 1, 'L');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('helvetica', '', 9);
            $accion_nombres = [
                'login_exitoso' => 'Inicio de sesión exitoso',
                'login_fallido' => 'Intento fallido',
                'subir_documento' => 'Subir documento',
                'descargar_documento' => 'Descargar documento',
                'editar_documento' => 'Editar documento',
                'eliminar_documento' => 'Eliminar documento',
                'crear_usuario' => 'Crear usuario',
                'editar_usuario' => 'Editar usuario',
                'eliminar_usuario' => 'Eliminar usuario',
                'cambiar_estado_usuario' => 'Cambiar estado',
                'cambiar_rol_usuario' => 'Cambiar rol',
                'generar_reporte_pdf' => 'Generar reporte',
                'generar_reporte_detallado' => 'Reporte detallado',
                'exportar_backup' => 'Exportar backup',
                'importar_backup' => 'Importar backup',
            ];
            $i = 1;
            foreach (array_slice($datos['acciones_resumen'], 0, 10, true) as $accion => $total) {
                $nombre = $accion_nombres[$accion] ?? $accion;
                $pdf->Cell(0, 5, '  ' . $i . '. ' . $nombre . ': ' . $total . ' veces', 0, 1, 'L');
                $i++;
            }
            $pdf->Ln(2);
        }
        
        // Top módulos
        if (!empty($datos['modulos_resumen'])) {
            $pdf->SetTextColor(0, 119, 182);
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->Cell(0, 5, 'Módulos más afectados:', 0, 1, 'L');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('helvetica', '', 9);
            $i = 1;
            foreach (array_slice($datos['modulos_resumen'], 0, 10, true) as $modulo => $total) {
                $pdf->Cell(0, 5, '  ' . $i . '. ' . strtoupper($modulo) . ': ' . $total . ' acciones', 0, 1, 'L');
                $i++;
            }
            $pdf->Ln(2);
        }
        
        // Top usuarios
        if (!empty($datos['usuarios_resumen'])) {
            $pdf->SetTextColor(0, 119, 182);
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->Cell(0, 5, 'Usuarios más activos:', 0, 1, 'L');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('helvetica', '', 9);
            $i = 1;
            foreach (array_slice($datos['usuarios_resumen'], 0, 10, true) as $usuario_nombre => $total) {
                $pdf->Cell(0, 5, '  ' . $i . '. ' . $usuario_nombre . ': ' . $total . ' acciones', 0, 1, 'L');
                $i++;
            }
            $pdf->Ln(2);
        }
        
        // Top documentos
        if (!empty($datos['documentos_resumen'])) {
            $pdf->SetTextColor(0, 119, 182);
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->Cell(0, 5, 'Documentos más consultados:', 0, 1, 'L');
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('helvetica', '', 9);
            $i = 1;
            foreach (array_slice($datos['documentos_resumen'], 0, 10, true) as $documento => $total) {
                $doc_corto = strlen($documento) > 50 ? substr($documento, 0, 47) . '...' : $documento;
                $pdf->Cell(0, 5, '  ' . $i . '. ' . $doc_corto . ': ' . $total . ' consultas', 0, 1, 'L');
                $i++;
            }
            $pdf->Ln(5);
        }
    } else {
        $pdf->SetFillColor(231, 243, 255);
        $pdf->MultiCell(0, 5, 'No se encontraron registros para los filtros seleccionados.', 0, 'L', 1);
    }
    
    // ===== LISTA DETALLADA DE ACCIONES =====
    if (!empty($datos['logs']) && !$datos['periodo_futuro']) {
        $pdf->AddPage();
        $pdf->SetTextColor(0, 51, 102);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 6, 'REGISTRO DETALLADO DE ACCIONES (' . count($datos['logs']) . ' registros)', 0, 1, 'L');
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);
        
        $accion_nombres = [
            'login_exitoso' => 'Inicio de sesión',
            'login_fallido' => 'Intento fallido',
            'subir_documento' => 'Subir documento',
            'descargar_documento' => 'Descargar documento',
            'editar_documento' => 'Editar documento',
            'eliminar_documento' => 'Eliminar documento',
            'crear_usuario' => 'Crear usuario',
            'editar_usuario' => 'Editar usuario',
            'eliminar_usuario' => 'Eliminar usuario',
            'cambiar_estado_usuario' => 'Cambiar estado',
            'cambiar_rol_usuario' => 'Cambiar rol',
            'generar_reporte_pdf' => 'Generar reporte',
            'generar_reporte_detallado' => 'Reporte detallado',
            'exportar_backup' => 'Exportar backup',
            'importar_backup' => 'Importar backup',
        ];
        
        foreach ($datos['logs'] as $log) {
            $nombre_usuario = trim($log['primer_nombre'] . ' ' . $log['primer_apellido']);
            $nombre_accion = $accion_nombres[$log['accion']] ?? $log['accion'];
            $detalle = $log['registro_titulo'] ?? $log['detalle'] ?? 'ID: ' . $log['registro_id'];
            
            $pdf->SetDrawColor(118, 199, 192);
            $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
            $pdf->Ln(2);
            
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->SetTextColor(0, 119, 182);
            $pdf->Cell(0, 5, 'Fecha: ' . date('d/m/Y H:i', strtotime($log['fecha'])), 0, 1, 'L');
            $pdf->SetFont('helvetica', '', 9);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(0, 5, 'Usuario: ' . $nombre_usuario . ' (' . $log['cedula'] . ')', 0, 1, 'L');
            $pdf->Cell(0, 5, 'Acción: ' . $nombre_accion, 0, 1, 'L');
            $pdf->Cell(0, 5, 'Módulo: ' . strtoupper($log['tabla']), 0, 1, 'L');
            
            // Información adicional del documento si aplica
            if ($log['tabla'] === 'documentos' && isset($datos['documentos_info'][$log['registro_id']])) {
                $doc_info = $datos['documentos_info'][$log['registro_id']];
                
                $pdf->SetFont('helvetica', 'B', 8);
                $pdf->SetTextColor(0, 51, 102);
                $pdf->Cell(0, 4, 'Información del documento:', 0, 1, 'L');
                $pdf->SetFont('helvetica', '', 8);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(0, 4, '  • Título: ' . $doc_info['titulo'], 0, 1, 'L');
                $pdf->Cell(0, 4, '  • Tipo: ' . $doc_info['tipo_documento'], 0, 1, 'L');
                $pdf->Cell(0, 4, '  • Estado: ' . $doc_info['estado'], 0, 1, 'L');
                $pdf->Cell(0, 4, '  • Creado por: ' . $doc_info['creado_por_nombre'] . ' (Cédula: ' . $doc_info['creado_por_cedula'] . ') - Fecha: ' . $doc_info['fecha_creacion_formateada'], 0, 1, 'L');
                
                if ($doc_info['fecha_modificacion_formateada']) {
                    $pdf->Cell(0, 4, '  • Última modificación: ' . ($doc_info['modificado_por_nombre'] ?? 'Desconocido') . ' - Fecha: ' . $doc_info['fecha_modificacion_formateada'], 0, 1, 'L');
                }
                
                if ($doc_info['eliminado'] == 1 && $doc_info['fecha_eliminacion_formateada']) {
                    $pdf->SetTextColor(206, 32, 41);
                    $pdf->Cell(0, 4, '  • ELIMINADO por: ' . ($doc_info['eliminado_por_nombre'] ?? 'Desconocido') . ' (Cédula: ' . ($doc_info['eliminado_por_cedula'] ?? 'N/A') . ')', 0, 1, 'L');
                    $pdf->Cell(0, 4, '  • Fecha de eliminación: ' . $doc_info['fecha_eliminacion_formateada'], 0, 1, 'L');
                    if ($doc_info['motivo_eliminacion']) {
                        $pdf->Cell(0, 4, '  • Motivo: ' . $doc_info['motivo_eliminacion'], 0, 1, 'L');
                    }
                    $pdf->SetTextColor(0, 0, 0);
                }
            }
            
            $pdf->MultiCell(0, 5, 'Detalle: ' . substr($detalle, 0, 150), 0, 'L');
            $pdf->Ln(2);
        }
        
        $pdf->SetDrawColor(118, 199, 192);
        $pdf->Line(15, $pdf->GetY(), 195, $pdf->GetY());
        $pdf->Ln(2);
    }
    
    // ===== FIRMA =====
    $pdf->AddPage();
    $pdf->SetTextColor(0, 51, 102);
    $pdf->SetFont('helvetica', 'B', 11);
    $pdf->Cell(0, 8, 'DECLARACIÓN DE RESPONSABILIDAD', 0, 1, 'C');
    $pdf->Ln(5);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->MultiCell(0, 5, 'Certifico que la información contenida en este reporte es fiel reflejo de los registros almacenados en el sistema de gestión documental de la Biblioteca Pública del Estado Zulia "María Calcaño".', 0, 'J');
    $pdf->Ln(5);
    $pdf->MultiCell(0, 5, 'Base Legal: Este reporte se genera en cumplimiento con la Ley de Transparencia y Acceso a la Información Pública, y las normativas internas de control y auditoría del sistema.', 0, 'J');
    $pdf->Ln(10);
    
    $pdf->Cell(80, 5, '_________________________', 0, 0, 'C');
    $pdf->Cell(30, 5, '', 0, 0, 'C');
    $pdf->Cell(80, 5, '_________________________', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 8);
    $pdf->Cell(80, 4, 'Firma del Administrador', 0, 0, 'C');
    $pdf->Cell(30, 4, '', 0, 0, 'C');
    $pdf->Cell(80, 4, 'Sello Institucional', 0, 1, 'C');
    $pdf->Cell(80, 4, $usuario['nombre'], 0, 0, 'C');
    $pdf->Cell(30, 4, '', 0, 0, 'C');
    $pdf->Cell(80, 4, 'Biblioteca Pública del Estado Zulia', 0, 1, 'C');
    $pdf->Ln(10);
    
    $pdf->SetFont('helvetica', '', 8);
    $pdf->SetTextColor(102, 102, 102);
    $pdf->Cell(0, 4, 'ID de Trazabilidad: ' . uniqid('BPEZ-') . ' | Generado por: ' . $usuario['nombre'] . ' (Cédula: ' . $usuario['cedula'] . ')', 0, 1, 'C');
    $pdf->Cell(0, 4, 'Fecha de emisión: ' . $datos['fecha_generacion'], 0, 1, 'C');
    
    return $pdf;
}

// ===== REGISTRAR EN LOGS =====
function registrarGeneracionPDFEspecifico($pdo, $usuario_id, $usuario_nombre, $usuario_cedula, $usuario_rol, $datos) {
    try {
        $detalle = "Generó reporte específico - Periodo: {$datos['periodo_texto']} - Registros: {$datos['total_registros']}";
        if (!empty($datos['filtros_texto'])) {
            $detalle .= " - Filtros: " . implode(', ', $datos['filtros_texto']);
        }
        
        $sql = "INSERT INTO logs (usuario_id, usuario_nombre, usuario_cedula, usuario_rol, accion, tabla, registro_id, registro_titulo, detalle, fecha) 
                VALUES (?, ?, ?, ?, 'generar_reporte_especifico', 'reportes', 0, 'Reporte Específico', ?, NOW())";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$usuario_id, $usuario_nombre, $usuario_cedula, $usuario_rol, $detalle]);
    } catch (PDOException $e) {
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
    
    $pdf = generarPDFEspecifico($datos, $usuario_pdf);
    registrarGeneracionPDFEspecifico($pdo, $_SESSION['user_id'], $usuario_pdf['nombre'], $usuario_pdf['cedula'], $usuario_pdf['rol'], $datos);
    
    $pdf->Output('reporte_especifico_' . date('Ymd_His') . '.pdf', 'D');
    exit();
}

// ===== INCLUIR LA VISTA =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/reporte_especifico_frontend.php';
exit();
?>