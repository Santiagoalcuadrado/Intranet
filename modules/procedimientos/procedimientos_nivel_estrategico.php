<?php
/**
 * procedimientos_nivel_estrategico.php
 * BACKEND para Procedimientos - Nivel Estratégico
 * Ubicación: /modules/procedimientos/procedimientos_nivel_estrategico.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Procedimientos - Nivel Estratégico";
$descripcion_pagina = "Procedimientos del nivel estratégico de la organización";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/procedimientos_nivel_estrategico_frontend.php';
exit();
?>