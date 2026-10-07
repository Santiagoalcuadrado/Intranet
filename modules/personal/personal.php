<?php
/**
 * personal.php
 * BACKEND para el módulo de Personal
 * Ubicación: /modules/personal/personal.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
// Esto protege la página: solo usuarios autenticados pueden acceder
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Personal";
$descripcion_pagina = "Gestión de talento humano, expedientes, nómina y desarrollo del personal";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/personal_frontend.php';
exit();
?>