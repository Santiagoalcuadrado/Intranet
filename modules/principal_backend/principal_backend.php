<?php
/**
 * principal_backend.php
 * BACKEND: Verifica sesión y muestra la vista principal
 * Ubicación: /modules/principal_backend/principal_backend.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== PREPARAR DATOS PARA LA VISTA =====
$primer_nombre = $_SESSION['primer_nombre'] ?? '';
$primer_apellido = $_SESSION['primer_apellido'] ?? '';
$nombre_completo = $_SESSION['nombre_completo'] ?? trim($primer_nombre . ' ' . $primer_apellido);

// ===== INCLUIR LA VISTA =====
// Ruta relativa desde modules/principal_backend/ a assets/frontend/
include '../../assets/frontend/principal_frontend.php';
exit();
?>