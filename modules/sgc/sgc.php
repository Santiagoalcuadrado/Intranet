<?php
/**
 * sgc.php
 * BACKEND para el módulo de Sistema de Gestión de Calidad (SGC)
 * Ubicación: /modules/sgc/sgc.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
// Esto protege la página: solo usuarios autenticados pueden acceder
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Sistema de Gestión de la Calidad";
$descripcion_pagina = "Gestión documental, procedimientos, indicadores y control de calidad institucional";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/sgc_frontend.php';
exit();
?>