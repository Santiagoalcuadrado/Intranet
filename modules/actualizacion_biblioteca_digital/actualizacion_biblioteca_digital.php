<?php
/**
 * actualizacion_biblioteca_digital.php
 * BACKEND para el módulo de Actualización Biblioteca Digital
 * Ubicación: /modules/actualizacion_biblioteca_digital/actualizacion_biblioteca_digital.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Actualización Biblioteca Digital";
$descripcion_pagina = "Gestión de contenidos, recursos y materiales de la biblioteca digital institucional";

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/actualizacion_biblioteca_digital_frontend.php';
exit();
?>