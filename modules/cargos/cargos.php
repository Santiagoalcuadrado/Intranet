<?php
/**
 * cargos.php
 * BACKEND para el módulo de Cargos
 * Ubicación: /modules/cargos/cargos.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Cargos";
$descripcion_pagina = "Estructura y descripción de cargos de la institución";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/cargos_frontend.php';
exit();
?>