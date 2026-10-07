<?php
/**
 * reportes.php
 * BACKEND para el módulo de Reportes del Sistema
 * Ubicación: /modules/admin/reportes.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== VERIFICAR QUE SEA ADMINISTRADOR =====
if (!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 1) {
    header("Location: /assets/frontend/principal_frontend.php?error=acceso_denegado");
    exit();
}

// ===== INCLUIR CONEXIÓN A LA BASE DE DATOS =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexiondb.php';

// ===== INICIALIZAR VARIABLES =====
$titulo_pagina = "Reportes del Sistema";
$descripcion_pagina = "Generación de reportes para análisis, seguimiento y toma de decisiones institucionales";

// ===== DATOS DE EJEMPLO PARA REPORTES (OPCIONAL) =====
// Puedes preparar datos de ejemplo que se mostrarán en la página
$reportes_info = [
    'general' => [
        'icono' => 'fas fa-file-alt',
        'descripcion' => 'Reporte consolidado de todas las actividades del sistema, incluyendo usuarios, documentos y acciones registradas.'
    ],
    'detallado' => [
        'icono' => 'fas fa-list-ul',
        'descripcion' => 'Reporte con información pormenorizada de cada módulo, permitiendo filtrar por fechas, usuarios y tipos de acciones.'
    ],
    'especifico' => [
        'icono' => 'fas fa-filter',
        'descripcion' => 'Reporte personalizable que permite seleccionar módulos específicos, rangos de fechas y tipos de datos a visualizar.'
    ]
];

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/reportes_frontend.php';
exit();
?>