<?php
/**
 * gestion.php
 * BACKEND para el módulo de Gestión
 * Ubicación: /modules/gestion/gestion.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
// Esto protege la página: solo usuarios autenticados pueden acceder
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Gestión";
$descripcion_pagina = "Planificación, proyectos y control de gestión de la institución";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/gestion_frontend.php';
exit();
?>