<?php
/**
 * internacional.php
 * BACKEND para la sección de Contexto Internacional
 * Ubicación: /modules/contexto/internacional.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
// Esto protege la página: solo usuarios autenticados pueden acceder
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== TÍTULO DE LA PÁGINA (para usar en la vista) =====
$titulo_pagina = "Contexto Internacional";

// ===== OPCIONAL: Datos adicionales que quieras pasar a la vista =====
$descripcion = "Marco legal y normativo internacional que rige las bibliotecas";
$fecha_actualizacion = "2026";

// ===== INCLUIR LA VISTA =====
// La vista tendrá acceso a todas las variables definidas aquí ($titulo_pagina, $descripcion, etc.)
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/contexto_internacional_frontend.php';
exit();
?>