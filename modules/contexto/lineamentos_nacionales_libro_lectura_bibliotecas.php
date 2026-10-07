<?php
/**
 * lineamentos_nacionales_libro_lectura_bibliotecas.php
 * BACKEND para Lineamientos Nacionales sobre Libro, Lectura y Bibliotecas
 * Actualizado a febrero 2026
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Lineamientos Nacionales: Libro, Lectura y Bibliotecas";
$descripcion_pagina = "Marco estratégico de las 7 Transformaciones (7T), la Ley de Comunas y los Lineamientos Nacionales en materia de libros y bibliotecas";

// ===== INCLUIR LA VISTA =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/contexto_lineamentos_nacionales_libro_lectura_bibliotecas_frontend.php';
exit();
?>