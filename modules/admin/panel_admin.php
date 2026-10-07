<?php
/**
 * panel_admin.php
 * BACKEND para el Panel Administrativo
 * Ubicación: /modules/admin/panel_admin.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VERIFICAR QUE SEA ADMINISTRADOR =====
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: /assets/frontend/principal_frontend.php?error=acceso_denegado");
    exit();
}

// ===== INCLUIR CONEXIÓN A LA BASE DE DATOS =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexiondb.php';

// ===== MOSTRAR MENSAJE DE BACKUP =====
$backup_mensaje = $_SESSION['backup_mensaje'] ?? null;
$backup_tipo = $_SESSION['backup_tipo'] ?? 'danger';
unset($_SESSION['backup_mensaje']);
unset($_SESSION['backup_tipo']);

// ===== INICIALIZAR VARIABLES DE ESTADÍSTICAS =====
$stats = [];

try {
    // ==================== 1. ESTADÍSTICAS DE USUARIOS ====================
    
    // Total de usuarios
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios");
    $stats['total_usuarios'] = $stmt->fetch()['total'];
    
    // Usuarios activos
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE estado = 'Activo'");
    $stats['usuarios_activos'] = $stmt->fetch()['total'];
    
    // Usuarios inactivos
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE estado = 'Inactivo'");
    $stats['usuarios_inactivos'] = $stmt->fetch()['total'];
    
    // Usuarios suspendidos
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE estado = 'Suspendido'");
    $stats['usuarios_suspendidos'] = $stmt->fetch()['total'];
    
    // Administradores
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE id_rol = 1");
    $stats['total_administradores'] = $stmt->fetch()['total'];
    
    // Usuarios regulares
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE id_rol = 2");
    $stats['usuarios_regulares'] = $stmt->fetch()['total'];
    
    // Usuarios nuevos últimos 30 días
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE fecha_registro >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $stats['nuevos_30_dias'] = $stmt->fetch()['total'];
    
    // Usuarios nuevos últimos 7 días
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE fecha_registro >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $stats['nuevos_7_dias'] = $stmt->fetch()['total'];
    
    // Usuarios activos hoy
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE DATE(ultimo_login) = CURDATE()");
    $stats['activos_hoy'] = $stmt->fetch()['total'];
    
    // Usuarios activos última semana
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE ultimo_login >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $stats['activos_semana'] = $stmt->fetch()['total'];
    
    // Usuarios activos último mes
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM usuarios WHERE ultimo_login >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $stats['activos_mes'] = $stmt->fetch()['total'];
    
    // ==================== 2. ESTADÍSTICAS DE DOCUMENTOS ====================
    
    // Total de documentos
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM documentos WHERE eliminado = 0");
    $stats['total_documentos'] = $stmt->fetch()['total'];
    
    // Documentos por tipo
    $stmt = $pdo->query("SELECT tipo_documento, COUNT(*) as total FROM documentos WHERE eliminado = 0 GROUP BY tipo_documento");
    $stats['documentos_por_tipo'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Documentos por estado
    $stmt = $pdo->query("SELECT estado, COUNT(*) as total FROM documentos WHERE eliminado = 0 GROUP BY estado");
    $stats['documentos_por_estado'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Documentos subidos último mes
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM documentos WHERE fecha_creacion >= DATE_SUB(NOW(), INTERVAL 30 DAY) AND eliminado = 0");
    $stats['documentos_ultimo_mes'] = $stmt->fetch()['total'];
    
    // Documentos subidos hoy
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM documentos WHERE DATE(fecha_creacion) = CURDATE() AND eliminado = 0");
    $stats['documentos_hoy'] = $stmt->fetch()['total'];
    
    // Tamaño uploads
    $ruta_uploads = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
    $stats['tamano_uploads'] = 0;
    if (is_dir($ruta_uploads)) {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($ruta_uploads, FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $stats['tamano_uploads'] += $file->getSize();
            }
        }
    }
    
    // ==================== 3. ESTADÍSTICAS DE LOGS Y ACTIVIDAD ====================
    
    // Total acciones
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM logs");
    $stats['total_logs'] = $stmt->fetch()['total'];
    
    // Acciones hoy
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM logs WHERE DATE(fecha) = CURDATE()");
    $stats['logs_hoy'] = $stmt->fetch()['total'];
    
    // Acciones última semana
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM logs WHERE fecha >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $stats['logs_semana'] = $stmt->fetch()['total'];
    
    // Acciones último mes
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM logs WHERE fecha >= DATE_SUB(NOW(), INTERVAL 30 DAY)");
    $stats['logs_mes'] = $stmt->fetch()['total'];
    
    // Acciones más frecuentes
    $stmt = $pdo->query("SELECT accion, COUNT(*) as total FROM logs GROUP BY accion ORDER BY total DESC LIMIT 10");
    $stats['acciones_frecuentes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== TOP 10 USUARIOS MÁS ACTIVOS =====
    $stmt = $pdo->query("
        SELECT 
            usuario_nombre, 
            usuario_cedula, 
            COUNT(*) as acciones 
        FROM logs 
        GROUP BY usuario_id, usuario_nombre, usuario_cedula 
        ORDER BY acciones DESC 
        LIMIT 10
    ");
    $stats['usuarios_mas_activos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ===== TOP 10 USUARIOS CON MÁS DOCUMENTOS SUBIDOS =====
    $stmt = $pdo->query("
        SELECT 
            creado_por_nombre as usuario_nombre,
            creado_por_cedula as usuario_cedula,
            COUNT(*) as total_documentos,
            MAX(fecha_creacion) as ultimo_documento
        FROM documentos 
        WHERE eliminado = 0
        GROUP BY creado_por_id, creado_por_nombre, creado_por_cedula 
        ORDER BY total_documentos DESC 
        LIMIT 10
    ");
    $stats['usuarios_mas_documentos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // ==================== 4. ESTADÍSTICAS DE INTENTOS DE LOGIN ====================
    
    // Intentos fallidos totales
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM intentos_login");
    $stats['intentos_fallidos_totales'] = $stmt->fetch()['total'];
    
    // Intentos fallidos en los últimos 7 días
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM intentos_login WHERE ultimo_intento >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $stats['intentos_fallidos_semana'] = $stmt->fetch()['total'];
    
    // ==================== 5. ESTADÍSTICAS DE RECUPERACIÓN ====================
    
    // Intentos de recuperación totales
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM intentos_recuperacion");
    $stats['intentos_recuperacion_totales'] = $stmt->fetch()['total'];
    
    // Recuperaciones exitosas
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM intentos_recuperacion WHERE exito = 1");
    $stats['recuperaciones_exitosas'] = $stmt->fetch()['total'];
    
    // ==================== 6. FECHAS IMPORTANTES ====================
    
    // Primer usuario
    $stmt = $pdo->query("SELECT fecha_registro FROM usuarios ORDER BY fecha_registro ASC LIMIT 1");
    $stats['primer_usuario'] = $stmt->fetch()['fecha_registro'] ?? 'N/A';
    
    // Último usuario
    $stmt = $pdo->query("SELECT fecha_registro FROM usuarios ORDER BY fecha_registro DESC LIMIT 1");
    $stats['ultimo_usuario'] = $stmt->fetch()['fecha_registro'] ?? 'N/A';
    
    // Primer documento
    $stmt = $pdo->query("SELECT fecha_creacion FROM documentos ORDER BY fecha_creacion ASC LIMIT 1");
    $stats['primer_documento'] = $stmt->fetch()['fecha_creacion'] ?? 'N/A';
    
    // Último documento
    $stmt = $pdo->query("SELECT fecha_creacion FROM documentos ORDER BY fecha_creacion DESC LIMIT 1");
    $stats['ultimo_documento'] = $stmt->fetch()['fecha_creacion'] ?? 'N/A';
    
    // Último backup
    $stmt = $pdo->query("SELECT fecha FROM logs WHERE accion IN ('exportar_bd', 'exportar_backup_completo') ORDER BY fecha DESC LIMIT 1");
    $stats['ultimo_backup'] = $stmt->fetch()['fecha'] ?? 'Nunca';
    
    // ==================== 7. ACTIVIDAD DIARIA ====================
    
    // Actividad por hora
    $stmt = $pdo->query("
        SELECT HOUR(fecha) as hora, COUNT(*) as total 
        FROM logs 
        WHERE fecha >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        GROUP BY HOUR(fecha)
        ORDER BY hora ASC
    ");
    $stats['actividad_por_hora'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Actividad por día
    $stmt = $pdo->query("
        SELECT DAYOFWEEK(fecha) as dia, COUNT(*) as total 
        FROM logs 
        WHERE fecha >= DATE_SUB(NOW(), INTERVAL 30 DAY)
        GROUP BY DAYOFWEEK(fecha)
        ORDER BY dia ASC
    ");
    $stats['actividad_por_dia'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    error_log("Error al obtener estadísticas: " . $e->getMessage());
    $stats = [];
}

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Panel Administrativo";
$descripcion_pagina = "Gestión y administración de la Intranet BPEZ";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/panel_admin_frontend.php';
exit();
?>