<?php
/**
 * backup_import.php
 * Restaura BACKUP COMPLETO: Base de datos + todos los archivos de uploads
 * Ubicación: /modules/admin/backup_import.php
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

// ===== FUNCIÓN PARA ELIMINAR DIRECTORIO RECURSIVAMENTE =====
function eliminarDirectorio($dir) {
    if (!is_dir($dir)) return;
    $files = array_diff(scandir($dir), ['.', '..']);
    foreach ($files as $file) {
        $path = $dir . '/' . $file;
        is_dir($path) ? eliminarDirectorio($path) : unlink($path);
    }
    rmdir($dir);
}

// ===== FUNCIÓN PARA COPIAR DIRECTORIO RECURSIVAMENTE =====
function copiarDirectorio($origen, $destino) {
    if (!is_dir($destino)) {
        mkdir($destino, 0755, true);
    }
    
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($origen, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    
    foreach ($iterator as $item) {
        $ruta_relativa = str_replace($origen, '', $item->getRealPath());
        $destino_archivo = $destino . $ruta_relativa;
        
        if ($item->isDir()) {
            if (!is_dir($destino_archivo)) {
                mkdir($destino_archivo, 0755, true);
            }
        } else {
            copy($item->getRealPath(), $destino_archivo);
        }
    }
}

$mensaje = "";
$tipo_mensaje = "danger";

if (isset($_POST['importar']) && isset($_FILES['archivo_zip'])) {
    $archivo = $_FILES['archivo_zip'];
    
    // Validar archivo
    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        $mensaje = "Error al subir el archivo.";
    } elseif ($archivo['size'] > 200 * 1024 * 1024) {
        $mensaje = "El archivo excede el límite de 200MB.";
    } else {
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        if ($extension !== 'zip') {
            $mensaje = "Solo se permiten archivos .zip";
        } else {
            // Crear directorio temporal para extraer
            $temp_dir = sys_get_temp_dir() . '/restore_' . uniqid();
            mkdir($temp_dir, 0777, true);
            
            $zip = new ZipArchive();
            if ($zip->open($archivo['tmp_name']) !== true) {
                $mensaje = "No se pudo abrir el archivo ZIP";
            } else {
                $zip->extractTo($temp_dir);
                $zip->close();
                
                $errores = 0;
                
                // ===== 1. RESTAURAR BASE DE DATOS =====
                $sql_file = $temp_dir . '/database_backup.sql';
                if (file_exists($sql_file)) {
                    $sql_content = file_get_contents($sql_file);
                    $queries = explode(";", $sql_content);
                    
                    try {
                        $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
                        
                        foreach ($queries as $query) {
                            $query = trim($query);
                            if (!empty($query)) {
                                try {
                                    $pdo->exec($query);
                                } catch (PDOException $e) {
                                    $errores++;
                                    error_log("Error en restauración SQL: " . $e->getMessage());
                                }
                            }
                        }
                        
                        $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
                        
                    } catch (PDOException $e) {
                        $errores++;
                        error_log("Error general en restauración SQL: " . $e->getMessage());
                    }
                } else {
                    $errores++;
                    error_log("No se encontró database_backup.sql en el ZIP");
                }
                
                // ===== 2. RESTAURAR ARCHIVOS DE UPLOADS =====
                $uploads_origen = $temp_dir . '/uploads';
                $uploads_destino = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
                
                if (is_dir($uploads_origen)) {
                    // Limpiar carpeta uploads actual (opcional, con precaución)
                    // eliminarDirectorio($uploads_destino);
                    
                    // Crear directorio si no existe
                    if (!is_dir($uploads_destino)) {
                        mkdir($uploads_destino, 0755, true);
                    }
                    
                    // Copiar archivos
                    copiarDirectorio($uploads_origen, $uploads_destino);
                } else {
                    $errores++;
                    error_log("No se encontró la carpeta uploads en el ZIP");
                }
                
                // ===== 3. REGISTRAR EN LOGS =====
                try {
                    $log_sql = "INSERT INTO logs 
                                (usuario_id, usuario_nombre, usuario_cedula, usuario_rol, accion, tabla, registro_id, registro_titulo, detalle, fecha) 
                                VALUES (?, ?, ?, ?, 'importar_backup_completo', 'backup', 0, 'Restauración Completa', ?, NOW())";
                    $stmt = $pdo->prepare($log_sql);
                    $stmt->execute([
                        $_SESSION['user_id'],
                        $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido'],
                        $_SESSION['cedula'] ?? '',
                        $_SESSION['rol'],
                        "Restauró backup completo (BD + archivos). Motivo: {$motivo}. Archivo: {$archivo['name']}. Errores: {$errores}"
                    ]);
                } catch (PDOException $e) {
                    error_log("Error al registrar log: " . $e->getMessage());
                }
                
                // Limpiar directorio temporal
                eliminarDirectorio($temp_dir);
                
                if ($errores == 0) {
                    $mensaje = "Backup restaurado correctamente. Base de datos y archivos recuperados.";
                    $tipo_mensaje = "success";
                } else {
                    $mensaje = "Restauración completada con {$errores} errores. Verificar logs.";
                    $tipo_mensaje = "warning";
                }
            }
        }
    }
}

// Redirigir de vuelta al panel con mensaje
$_SESSION['backup_mensaje'] = $mensaje;
$_SESSION['backup_tipo'] = $tipo_mensaje;
header("Location: /modules/admin/panel_admin.php");
exit;
?>