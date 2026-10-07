<?php
/**
 * aula_virtual.php
 * BACKEND para el módulo de Aula Virtual
 * Ubicación: /modules/aula_virtual/aula_virtual.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
// Esto protege la página: solo usuarios autenticados pueden acceder
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Aula Virtual";
$descripcion_pagina = "Espacio de formación y capacitación en línea para el personal";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/aula_virtual_frontend.php';
exit();
?>