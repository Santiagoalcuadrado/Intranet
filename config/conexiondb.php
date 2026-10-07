<?php
// --- CONFIGURACIÓN DE ZONA HORARIA ---
// Setea la hora oficial de Venezuela para todas las funciones de fecha en PHP
date_default_timezone_set('America/Caracas');

// --- CONFIGURACIÓN DE CREDENCIALES ---
$host    = 'localhost';         // Servidor donde reside la base de datos
$db      = 'intranetdb_bpez';     // Nombre de la base de datos institucional
$user    = 'root';            // Usuario de acceso (en producción usar uno con privilegios limitados)
$pass    = '';                // Contraseña del usuario
$charset = 'utf8mb4';         // Juego de caracteres que soporta acentos, eñes y emojis

// --- DSN (DATA SOURCE NAME) ---
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// --- OPCIONES DE CONFIGURACIÓN DE PDO ---
$options = [
    // Lanza excepciones cuando ocurre un error (permite usar el bloque try-catch)
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, 
    
    // Devuelve los resultados como arreglos asociativos (ej: $usuario['nombre'])
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
    
    // Seguridad: Desactiva la emulación de sentencias preparadas. 
    // Fuerza a MySQL a usar el filtrado real, previniendo Inyección SQL.
    PDO::ATTR_EMULATE_PREPARES   => false,                  
    
    // COMANDOS INICIALES:
    // 1. Asegura el charset y colación española.
    // 2. Setea la zona horaria de la conexión a UTC-4 (Caracas) para que los 
    //    campos TIMESTAMP y NOW() de SQL funcionen con la hora local.
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_spanish_ci, time_zone = '-04:00'"
];

// --- INTENTO DE CONEXIÓN ---
try {
     // Crea la instancia de conexión con los parámetros y opciones definidos
     $pdo = new PDO($dsn, $user, $pass, $options);
     
     // Si llegas aquí, la conexión fue exitosa.
} catch (\PDOException $e) {
     // Registra el error internamente para el administrador (log)
     error_log("Error de conexión: " . $e->getMessage());

     // Si falla, captura el error y lo lanza de forma controlada
     // impidiendo que se filtren datos sensibles como rutas o contraseñas en pantalla
     exit("Error crítico: No se pudo establecer la conexión con la base de datos institucional.");
}