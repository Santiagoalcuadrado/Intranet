<?php
/**
 * procedimientos.php
 * BACKEND para el módulo de Procedimientos
 * Ubicación: /modules/procedimientos/procedimientos.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Procedimientos";
$descripcion_pagina = "Manuales, procesos y procedimientos institucionales";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/procedimientos_frontend.php';
exit();
?>