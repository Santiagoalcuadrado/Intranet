<?php
// --- CONFIGURACIÓN DE CREDENCIALES ---
$host    = 'localhost';        // Servidor donde reside la base de datos
$db      = 'intranet_db';     // Nombre de la base de datos institucional
$user    = 'root';            // Usuario de acceso (en producción usar uno con privilegios limitados)
$pass    = '';                // Contraseña del usuario
$charset = 'utf8mb4';         // Juego de caracteres que soporta acentos, eñes y emojis

// --- DSN (DATA SOURCE NAME) ---
// Es la cadena de conexión que indica el motor (mysql), la ubicación y el charset
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
    
    // Comando inicial: Asegura que la comunicación PHP <-> DB use la colación 
    // necesaria para búsquedas inteligentes (sin importar acentos o mayúsculas)
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
];

// --- INTENTO DE CONEXIÓN ---
try {
     // Crea la instancia de conexión con los parámetros y opciones definidos
     $pdo = new PDO($dsn, $user, $pass, $options);
     
     // Si llegas aquí, la conexión fue exitosa.
} catch (\PDOException $e) {
     // Si falla (ej: servidor apagado), captura el error y lo lanza de forma controlada
     // impidiendo que se filtren datos sensibles de la ruta del archivo
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}