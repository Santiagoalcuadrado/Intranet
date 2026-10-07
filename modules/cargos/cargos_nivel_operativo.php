<?php
/**
 * nivel_operativo.php
 * BACKEND para Cargos - Nivel Operativo
 * Ubicación: /modules/cargos/cargos_nivel_operativo.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Cargos - Nivel Operativo";
$descripcion_pagina = "Estructura de cargos del nivel operativo de la organización";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/cargos_nivel_operativo_frontend.php';
exit();
?>