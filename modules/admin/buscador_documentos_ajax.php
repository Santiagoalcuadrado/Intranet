<?php
/**
 * buscador_documentos_ajax.php
 * API para búsqueda en tiempo real de documentos
 * Busca por: título, tipo, descripción, gaceta, creador
 * Ubicación: /modules/admin/buscador_documentos_ajax.php
 */

// ===== ACTIVAR DEPURACIÓN (OPCIONAL) =====
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VERIFICAR QUE SEA ADMINISTRADOR =====
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    http_response_code(403);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Acceso denegado']);
    exit();
}

// ===== INCLUIR CONEXIÓN A BD =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexiondb.php';

// ===== OBTENER PARÁMETROS =====
$termino = isset($_GET['q']) ? trim($_GET['q']) : '';
$limit = isset($_GET['limit']) ? min((int)$_GET['limit'], 15) : 10;

// ===== VALIDAR TÉRMINO MÍNIMO =====
if (strlen($termino) < 2) {
    header('Content-Type: application/json');
    echo json_encode(['data' => [], 'total' => 0]);
    exit();
}

try {
    $termino_like = "%$termino%";
    
    // ===== CONSULTA - BUSCA EN MÚLTIPLES CAMPOS =====
    $sql = "
        SELECT 
            id,
            titulo,
            tipo_documento,
            descripcion,
            gaceta,
            estado,
            archivo_nombre,
            creado_por_nombre,
            creado_por_cedula,
            DATE_FORMAT(fecha_creacion, '%d/%m/%Y') as fecha_formateada
        FROM documentos 
        WHERE 
            eliminado = 0
            AND (
                titulo LIKE ?
                OR tipo_documento LIKE ?
                OR descripcion LIKE ?
                OR gaceta LIKE ?
                OR creado_por_nombre LIKE ?
                OR archivo_nombre LIKE ?
            )
        ORDER BY 
            CASE 
                WHEN titulo = ? THEN 1
                WHEN titulo LIKE ? THEN 2
                ELSE 3
            END,
            fecha_creacion DESC
        LIMIT ?
    ";
    
    $termino_inicio = "$termino%";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $termino_like,   // titulo LIKE
        $termino_like,   // tipo_documento LIKE
        $termino_like,   // descripcion LIKE
        $termino_like,   // gaceta LIKE
        $termino_like,   // creado_por_nombre LIKE
        $termino_like,   // archivo_nombre LIKE
        $termino,        // titulo exacto para ORDER BY
        $termino_inicio, // titulo que empiece con el término
        $limit
    ]);
    
    $documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== PROCESAR RESULTADOS =====
    $resultados = [];
    foreach ($documentos as $doc) {
        // Estado para CSS
        switch ($doc['estado']) {
            case 'aprobado':
                $estado_class = 'estado-aprobado';
                $estado_icono = '✓';
                $estado_texto = 'Aprobado';
                break;
            case 'pendiente':
                $estado_class = 'estado-pendiente';
                $estado_icono = '⏳';
                $estado_texto = 'En revisión';
                break;
            case 'rechazado':
                $estado_class = 'estado-rechazado';
                $estado_icono = '✗';
                $estado_texto = 'Rechazado';
                break;
            default:
                $estado_class = 'estado-default';
                $estado_icono = '?';
                $estado_texto = $doc['estado'] ?? 'Desconocido';
        }
        
        // Tipo de documento con icono
        $tipo_iconos = [
            'ley' => '⚖️',
            'manual' => '📘',
            'procedimiento' => '📋',
            'circular' => '📢',
            'norma' => '📜',
            'informe' => '📊',
            'resolución' => '📄',
            'oficio' => '📨',
            'otro' => '📄'
        ];
        $tipo_icono = $tipo_iconos[strtolower($doc['tipo_documento'])] ?? '📄';
        
        // Acortar descripción si es muy larga
        $descripcion_corta = $doc['descripcion'] ? (strlen($doc['descripcion']) > 80 ? substr($doc['descripcion'], 0, 77) . '...' : $doc['descripcion']) : '';
        
        $resultados[] = [
            'id' => $doc['id'],
            'titulo' => $doc['titulo'],
            'tipo_documento' => $doc['tipo_documento'],
            'tipo_icono' => $tipo_icono,
            'descripcion' => $descripcion_corta,
            'descripcion_completa' => $doc['descripcion'],
            'gaceta' => $doc['gaceta'],
            'estado' => $doc['estado'],
            'estado_class' => $estado_class,
            'estado_icono' => $estado_icono,
            'estado_texto' => $estado_texto,
            'archivo_nombre' => $doc['archivo_nombre'],
            'creado_por_nombre' => $doc['creado_por_nombre'],
            'creado_por_cedula' => $doc['creado_por_cedula'],
            'fecha_formateada' => $doc['fecha_formateada']
        ];
    }
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'data' => $resultados,
        'total' => count($resultados),
        'query' => $termino
    ]);
    
} catch (PDOException $e) {
    error_log("Error en búsqueda de documentos: " . $e->getMessage());
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => 'Error al buscar documentos',
        'debug' => $e->getMessage()
    ]);
}
?>