<?php
/**
 * nivel_estrategico.php
 * BACKEND para Cargos - Nivel Estratégico
 * Ubicación: /modules/cargos/cargos_nivel_estrategico.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Cargos - Nivel Estratégico";
$descripcion_pagina = "Estructura de cargos del nivel estratégico de la organización";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/cargos_nivel_estrategico_frontend.php';
exit();
?>