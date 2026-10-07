<?php
/**
 * institucion.php
 * BACKEND para el módulo de Institución
 * Ubicación: /modules/institucion/institucion.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Institución";
$descripcion_pagina = "Documentación institucional y lineamientos de funcionamiento";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/institucion_frontend.php';
exit();
?>