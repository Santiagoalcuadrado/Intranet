<?php
/**
 * contexto.php
 * BACKEND para el módulo de Contexto
 * Ubicación: /modules/contexto/contexto.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
// Esto protege la página: solo usuarios autenticados pueden acceder
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Contexto Institucional";
$descripcion_pagina = "Marco legal, normativo y lineamientos que rigen la institución";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/contexto_frontend.php';
exit();
?>