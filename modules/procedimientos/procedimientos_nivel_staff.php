<?php
/**
 * procedimientos_nivel_staff.php
 * BACKEND para Procedimientos - Nivel Staff
 * Ubicación: /modules/procedimientos/procedimientos_nivel_staff.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Procedimientos - Nivel Staff";
$descripcion_pagina = "Procedimientos del nivel staff de la organización";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/procedimientos_nivel_staff_frontend.php';
exit();
?>