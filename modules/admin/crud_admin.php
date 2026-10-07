<?php
/**
 * crud_admin.php
 * BACKEND para el módulo de Administración de Usuarios (CRUD)
 * Ubicación: /modules/admin/crud_admin.php
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

// ===== OBTENER ROLES PARA EL SELECT =====
$roles = [];
try {
    $stmt = $pdo->query("SELECT id, nombre_rol FROM roles ORDER BY id");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error al obtener roles: " . $e->getMessage());
}

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Administración de Usuarios";
$descripcion_pagina = "Gestión completa de usuarios: crear, editar, suspender y activar cuentas";

// ===== INCLUIR LA VISTA =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/crud_admin_frontend.php';
exit();
?>