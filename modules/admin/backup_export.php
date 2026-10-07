<?php
/**
 * backup_export.php
 * Exporta BACKUP COMPLETO: Base de datos + todos los archivos de uploads
 * Ubicación: /modules/admin/backup_export.php
 */

// ===== SOLO PERMITIR MÉTODO POST =====
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die("Método no permitido");
}

// ===== VERIFICAR SESIÓN Y ROL =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VERIFICAR QUE SEA ADMINISTRADOR =====
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: /assets/frontend/principal_frontend.php?error=acceso_denegado");
    exit();
}

// ===== VALIDAR MOTIVO (mínimo 9 letras) =====
$motivo = trim($_POST['motivo'] ?? '');
function contarLetrasPhp($texto) {
    $soloLetras = preg_replace('/\s+/', '', $texto);
    return strlen($soloLetras);
}

if (contarLetrasPhp($motivo) < 9) {
    $_SESSION['backup_mensaje'] = "El motivo debe tener al menos 9 letras (sin contar espacios)";
    $_SESSION['backup_tipo'] = "danger";
    header("Location: /modules/admin/panel_admin.php");
    exit();
}

// ===== INCLUIR CONEXIÓN A BD =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexiondb.php';

// ===== FUNCIÓN PARA ESCAPAR SQL =====
function escapeSql($texto) {
    return str_replace(
        ['\\', "\0", "\n", "\r", "'", '"', "\x1a"],
        ['\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'],
        $texto
    );
}

// ===== FUNCIÓN PARA AGREGAR DIRECTORIO COMPLETO AL ZIP =====
function agregarDirectorioAZip($zip, $directorio, $rutaBaseEnZip) {
    if (!is_dir($directorio)) return;
    
    $archivos = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directorio, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY
    );
    
    foreach ($archivos as $archivo) {
        $rutaReal = $archivo->getRealPath();
        $rutaRelativa = $rutaBaseEnZip . '/' . str_replace($directorio, '', $rutaReal);
        $zip->addFile($rutaReal, $rutaRelativa);
    }
}

// ===== CREAR ZIP TEMPORAL =====
$fecha = date('Y-m-d_H-i-s');
$nombre_archivo = "backup_bpez_completo_{$fecha}.zip";
$ruta_temporal = sys_get_temp_dir() . '/' . $nombre_archivo;

$zip = new ZipArchive();
if ($zip->open($ruta_temporal, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    die("No se pudo crear el archivo ZIP");
}

// ===== 1. EXPORTAR BASE DE DATOS =====
$nombre_bd = 'intranetdb_bpez';
$sql_content = "-- =====================================================\n";
$sql_content .= "-- BACKUP COMPLETO - INTRANET BPEZ\n";
$sql_content .= "-- Base de datos: {$nombre_bd}\n";
$sql_content .= "-- Fecha: " . date('Y-m-d H:i:s') . "\n";
$sql_content .= "-- Generado por: {$_SESSION['primer_nombre']} {$_SESSION['primer_apellido']}\n";
$sql_content .= "-- Cédula: {$_SESSION['cedula']}\n";
$sql_content .= "-- Rol: {$_SESSION['rol']}\n";
$sql_content .= "-- Motivo: " . escapeSql($motivo) . "\n";
$sql_content .= "-- =====================================================\n\n";
$sql_content .= "SET FOREIGN_KEY_CHECKS = 0;\n\n";

// Obtener todas las tablas
$stmt = $pdo->query("SHOW TABLES");
$tablas = $stmt->fetchAll(PDO::FETCH_COLUMN);

foreach ($tablas as $tabla) {
    // Estructura de la tabla
    $stmt = $pdo->query("SHOW CREATE TABLE `{$tabla}`");
    $crear = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $sql_content .= "DROP TABLE IF EXISTS `{$tabla}`;\n";
    $sql_content .= $crear['Create Table'] . ";\n\n";
    
    // Datos de la tabla
    $stmt = $pdo->query("SELECT * FROM `{$tabla}`");
    $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($registros)) {
        $columnas = array_keys($registros[0]);
        $columnas_escaped = array_map(function($col) {
            return "`{$col}`";
        }, $columnas);
        
        $sql_content .= "INSERT INTO `{$tabla}` (" . implode(", ", $columnas_escaped) . ") VALUES\n";
        
        $valores_fila = [];
        foreach ($registros as $fila) {
            $valores = [];
            foreach ($fila as $valor) {
                if ($valor === null) {
                    $valores[] = "NULL";
                } else {
                    $valores[] = "'" . escapeSql($valor) . "'";
                }
            }
            $valores_fila[] = "(" . implode(", ", $valores) . ")";
        }
        
        $sql_content .= implode(",\n", $valores_fila) . ";\n\n";
    }
}

$sql_content .= "SET FOREIGN_KEY_CHECKS = 1;\n";

// Agregar archivo SQL al ZIP
$zip->addFromString("database_backup.sql", $sql_content);

// ===== 2. AGREGAR ARCHIVOS DE UPLOADS =====
$ruta_uploads = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
if (is_dir($ruta_uploads)) {
    agregarDirectorioAZip($zip, $ruta_uploads, 'uploads');
}

// ===== 3. AGREGAR ARCHIVO README CON INFORMACIÓN =====
$readme_content = "=====================================================\n";
$readme_content .= "BACKUP COMPLETO - INTRANET BPEZ\n";
$readme_content .= "=====================================================\n\n";
$readme_content .= "Fecha de backup: " . date('Y-m-d H:i:s') . "\n";
$readme_content .= "Generado por: {$_SESSION['primer_nombre']} {$_SESSION['primer_apellido']}\n";
$readme_content .= "Cédula: {$_SESSION['cedula']}\n";
$readme_content .= "Rol: {$_SESSION['rol']}\n";
$readme_content .= "Motivo: {$motivo}\n\n";
$readme_content .= "=====================================================\n";
$readme_content .= "CONTENIDO DEL BACKUP:\n";
$readme_content .= "=====================================================\n";
$readme_content .= "- database_backup.sql: Estructura y datos de la base de datos\n";
$readme_content .= "- uploads/: Todos los archivos subidos (PDFs, imágenes, etc.)\n\n";
$readme_content .= "=====================================================\n";
$readme_content .= "PARA RESTAURAR:\n";
$readme_content .= "=====================================================\n";
$readme_content .= "1. Usar el módulo de Importación en el Panel Administrativo\n";
$readme_content .= "2. Seleccionar este archivo ZIP\n";
$readme_content .= "3. El sistema restaurará automáticamente la BD y los archivos\n";

$zip->addFromString("README.txt", $readme_content);

// ===== CERRAR ZIP =====
$zip->close();

// ===== REGISTRAR EN LOGS =====
try {
    $log_sql = "INSERT INTO logs 
                (usuario_id, usuario_nombre, usuario_cedula, usuario_rol, accion, tabla, registro_id, registro_titulo, detalle, fecha) 
                VALUES (?, ?, ?, ?, 'exportar_backup_completo', 'backup', 0, 'Backup Completo', ?, NOW())";
    $stmt = $pdo->prepare($log_sql);
    $stmt->execute([
        $_SESSION['user_id'],
        $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido'],
        $_SESSION['cedula'] ?? '',
        $_SESSION['rol'],
        "Exportó backup completo (BD + archivos). Motivo: {$motivo}. Archivo: {$nombre_archivo}"
    ]);
} catch (PDOException $e) {
    error_log("Error al registrar log: " . $e->getMessage());
}

// ===== DESCARGAR ARCHIVO =====
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $nombre_archivo . '"');
header('Content-Length: ' . filesize($ruta_temporal));
readfile($ruta_temporal);

// Eliminar archivo temporal
unlink($ruta_temporal);
exit;
?>