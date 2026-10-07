<?php
/**
 * desempeno.php
 * BACKEND para el módulo de Desempeño
 * Ubicación: /modules/desempeno/desempeno.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
// Esto protege la página: solo usuarios autenticados pueden acceder
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Desempeño";
$descripcion_pagina = "Evaluación, métricas y control de desempeño institucional";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/desempeno_frontend.php';
exit();
?>