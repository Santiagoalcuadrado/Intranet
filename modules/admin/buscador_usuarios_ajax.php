<?php
/**
 * buscador_usuarios_ajax.php
 * API para búsqueda en tiempo real de usuarios
 * Ubicación: /modules/admin/buscador_usuarios_ajax.php
 */

// ===== ACTIVAR DEPURACIÓN =====
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    
    // ===== CONSULTA SIMPLIFICADA (SIN CASE COMPLEJO) =====
    $sql = "
        SELECT 
            id,
            primer_nombre,
            segundo_nombre,
            primer_apellido,
            segundo_apellido,
            cedula,
            email,
            estado,
            id_rol
        FROM usuarios 
        WHERE 
            cedula LIKE ?
            OR primer_nombre LIKE ?
            OR primer_apellido LIKE ?
            OR CONCAT(primer_nombre, ' ', primer_apellido) LIKE ?
        ORDER BY primer_nombre ASC
        LIMIT ?
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $termino_like,
        $termino_like,
        $termino_like,
        $termino_like,
        $limit
    ]);
    
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== PROCESAR RESULTADOS =====
    $resultados = [];
    foreach ($usuarios as $usuario) {
        // Nombre completo
        $nombre_completo = trim(
            $usuario['primer_nombre'] . ' ' . 
            ($usuario['segundo_nombre'] ? $usuario['segundo_nombre'] . ' ' : '') . 
            $usuario['primer_apellido'] . ' ' . 
            ($usuario['segundo_apellido'] ?? '')
        );
        $nombre_completo = preg_replace('/\s+/', ' ', $nombre_completo);
        
        // Estado
        switch ($usuario['estado']) {
            case 'Activo':
                $estado_class = 'estado-activo';
                $estado_icono = '✓';
                break;
            case 'Inactivo':
                $estado_class = 'estado-inactivo';
                $estado_icono = '○';
                break;
            case 'Suspendido':
                $estado_class = 'estado-suspendido';
                $estado_icono = '⚠';
                break;
            default:
                $estado_class = 'estado-default';
                $estado_icono = '?';
        }
        
        // Rol
        $rol_nombre = ($usuario['id_rol'] == 1) ? 'Administrador' : 'Usuario';
        $rol_class = ($usuario['id_rol'] == 1) ? 'rol-admin' : 'rol-user';
        
        $resultados[] = [
            'id' => $usuario['id'],
            'nombre_completo' => $nombre_completo,
            'cedula' => $usuario['cedula'],
            'email' => $usuario['email'],
            'estado' => $usuario['estado'],
            'estado_class' => $estado_class,
            'estado_icono' => $estado_icono,
            'rol_nombre' => $rol_nombre,
            'rol_class' => $rol_class
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
    error_log("Error en búsqueda: " . $e->getMessage());
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => 'Error al buscar usuarios',
        'debug' => $e->getMessage()
    ]);
}
?>