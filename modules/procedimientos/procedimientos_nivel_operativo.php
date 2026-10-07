<?php
/**
 * procedimientos_nivel_operativo.php
 * BACKEND para Procedimientos - Nivel Operativo
 * Ubicación: /modules/procedimientos/procedimientos_nivel_operativo.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Procedimientos - Nivel Operativo";
$descripcion_pagina = "Procedimientos del nivel operativo de la organización";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/procedimientos_nivel_operativo_frontend.php';
exit();
?>