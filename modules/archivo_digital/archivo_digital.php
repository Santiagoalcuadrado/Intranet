<?php
/**
 * archivo_digital.php
 * BACKEND para el módulo de Archivo Digital
 * Ubicación: /modules/aula_digital/aula_digital.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
// Esto protege la página: solo usuarios autenticados pueden acceder
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Aula Virtual";
$descripcion_pagina = "Espacio de formación y capacitación en línea para el personal";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/archivo_digital_frontend.php';
exit();
?>