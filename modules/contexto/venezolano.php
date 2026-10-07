<?php
/**
 * venezolano.php
 * BACKEND para el módulo de venezolano
 * Ubicación: /modules/contexto/venezolano.php
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// Variables para la vista
$titulo_pagina = "Contexto Venezolano";
$descripcion_pagina = "Marco legal y normativo de Venezuela";

include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/contexto_venezolano_frontend.php';
exit();
?>