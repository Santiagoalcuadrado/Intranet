<?php
/**
 * nivel_staff.php
 * BACKEND para Cargos - Nivel Staff
 * Ubicación: /modules/cargos/cargos_nivel_staff.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Cargos - Nivel Staff";
$descripcion_pagina = "Estructura de cargos del nivel staff de la organización";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/cargos_nivel_staff_frontend.php';
exit();
?>