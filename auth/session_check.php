<?php
/**
 * ARCHIVO DE VERIFICACIÓN DE SESIÓN - INTRANET BPEZ
 * Ubicación: /auth/session_check.php
 */

// 1. Incluir la conexión a la base de datos
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexiondb.php';

// 2. Iniciamos la sesión si no se ha iniciado antes
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_lifetime' => 0,
        'cookie_httponly' => true,
        'cookie_samesite' => 'Strict',
    ]);
}

// 3. Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id']) || !isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    session_unset();
    session_destroy();
    header("Location: /assets/frontend/login_frontend.php?error=acceso_denegado");
    exit();
}

// 4. VALIDACIÓN EN TIEMPO REAL: ¿El usuario sigue activo?
try {
    $stmt_check = $pdo->prepare("SELECT estado FROM usuarios WHERE id = :id LIMIT 1");
    $stmt_check->execute([':id' => $_SESSION['user_id']]);
    $user_db = $stmt_check->fetch();

    if (!$user_db || $user_db['estado'] !== 'Activo') {
        session_unset();
        session_destroy();
        header("Location: /assets/frontend/login_frontend.php?error=cuenta_inactiva");
        exit();
    }
} catch (PDOException $e) {
    die("Error de validación de seguridad.");
}

// ===== NUEVO: CARGAR EL ROL DEL USUARIO EN LA SESIÓN (ID y NOMBRE) =====
if ((!isset($_SESSION['rol']) || !isset($_SESSION['id_rol'])) && isset($_SESSION['user_id'])) {
    try {
        $stmt_rol = $pdo->prepare("
            SELECT r.id as rol_id, r.nombre_rol as rol_nombre 
            FROM usuarios u 
            JOIN roles r ON u.id_rol = r.id 
            WHERE u.id = :id
        ");
        $stmt_rol->execute([':id' => $_SESSION['user_id']]);
        $rol = $stmt_rol->fetch();
        
        if ($rol) {
            $_SESSION['rol'] = $rol['rol_nombre'];      // "Administrador" o "Usuario"
            $_SESSION['id_rol'] = $rol['rol_id'];       // 1 o 2
        } else {
            $_SESSION['rol'] = 'Usuario';
            $_SESSION['id_rol'] = 2; // ID por defecto para usuarios
        }
    } catch (PDOException $e) {
        error_log("Error al cargar rol: " . $e->getMessage());
        $_SESSION['rol'] = 'Usuario';
        $_SESSION['id_rol'] = 2;
    }
}

// 5. Validación de Seguridad: Fingerprinting
if (isset($_SESSION['user_agent'])) {
    if ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        session_unset();
        session_destroy();
        header("Location: /assets/frontend/login_frontend.php?error=sesion_invalida");
        exit();
    }
} else {
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
}

// 6. Control de Inactividad (15 minutos) - ultima modificacion del archivo 26/3/2026
$tiempo_maximo = 900; 
if (isset($_SESSION['ultimo_acceso'])) {
    $vida_sesion = time() - $_SESSION['ultimo_acceso'];
    if ($vida_sesion > $tiempo_maximo) {
        session_unset();
        session_destroy();
        header("Location: /assets/frontend/login_frontend.php?error=sesion_expirada");
        exit();
    }
}
$_SESSION['ultimo_acceso'] = time();
?>