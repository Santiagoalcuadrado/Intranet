<?php
/**
 * ingresar_backend.php
 * PROCESADOR: Verifica sesión y muestra la vista
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== CONSTRUIR NOMBRE PARA MOSTRAR =====
$primer_nombre = $_SESSION['primer_nombre'] ?? '';
$primer_apellido = $_SESSION['primer_apellido'] ?? '';

$_SESSION['nombre_para_mostrar'] = trim($primer_nombre . ' ' . $primer_apellido);

if (empty($_SESSION['nombre_para_mostrar'])) {
    $_SESSION['nombre_para_mostrar'] = 'Bienvenido(a)';
}

error_log("nombre_para_mostrar: " . $_SESSION['nombre_para_mostrar']);

// ===== INCLUIR LA VISTA =====
include 'ingresar_frontend.php';
exit();
?>