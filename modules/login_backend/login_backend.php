<?php
/**
 * LÓGICA DE AUTENTICACIÓN Y PROCESAMIENTO - INTRANET BPEZ (VERSIÓN SEGURA)
 * Este archivo valida las credenciales con múltiples capas de seguridad.
 */

// 1. IMPORTAR CONEXIÓN
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexiondb.php';

class LoginBackend {
    private $pdo;
    private const MAX_INTENTOS = 5;           // Máximo de intentos fallidos
    private const TIEMPO_BLOQUEO = 300;        // 5 minutos en segundos (300 = 5 * 60)
    private const MIN_CEDULA_LENGTH = 7;       // Mínimo 7 dígitos
    private const MAX_CEDULA_LENGTH = 8;       // Máximo 8 dígitos
    private const MIN_PASSWORD_LENGTH = 9;      // Mínimo 9 caracteres
    private const MAX_PASSWORD_LENGTH = 50;     // Máximo 50 caracteres

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * VALIDACIÓN 1: SANITIZACIÓN Y FILTRADO DE ENTRADAS
     */
    private function validarEntradas($cedula, $password) {
        $errores = [];

        // Validar cédula: solo números, entre 7 y 8 dígitos
        if (empty($cedula)) {
            $errores[] = 'cedula_vacia';
        } elseif (!preg_match('/^[0-9]{7,8}$/', $cedula)) {
            $errores[] = 'cedula_invalida';
        }

        // Validar contraseña: solo caracteres permitidos y longitud
        if (empty($password)) {
            $errores[] = 'password_vacia';
        } elseif (strlen($password) < self::MIN_PASSWORD_LENGTH || strlen($password) > self::MAX_PASSWORD_LENGTH) {
            $errores[] = 'password_longitud';
        } elseif (!preg_match('/^[a-zA-Z0-9.*#]+$/', $password)) {
            $errores[] = 'password_caracteres';
        }

        return $errores;
    }

    /**
     * VALIDACIÓN 2: CONTROL DE INTENTOS FALLIDOS (PREVENCIÓN DE FUERZA BRUTA)
     * MODIFICADO: Ahora devuelve el tiempo restante si está bloqueado
     */
    private function verificarIntentosFallidos($cedula) {
        $sql = "SELECT intentos_fallidos, ultimo_intento 
                FROM intentos_login 
                WHERE cedula = :cedula AND ultimo_intento > DATE_SUB(NOW(), INTERVAL :tiempo SECOND)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':cedula' => $cedula,
            ':tiempo' => self::TIEMPO_BLOQUEO
        ]);
        $intento = $stmt->fetch();

        if ($intento && $intento['intentos_fallidos'] >= self::MAX_INTENTOS) {
            // Calcular tiempo restante de bloqueo
            $ultimo_intento = strtotime($intento['ultimo_intento']);
            $tiempo_transcurrido = time() - $ultimo_intento;
            $tiempo_restante = self::TIEMPO_BLOQUEO - $tiempo_transcurrido;
            
            if ($tiempo_restante > 0) {
                return ['bloqueado' => true, 'tiempo_restante' => $tiempo_restante];
            }
        }
        return ['bloqueado' => false];
    }

    /**
     * VALIDACIÓN 3: REGISTRAR INTENTO FALLIDO
     */
    private function registrarIntentoFallido($cedula) {
        // Verificar si ya existe un registro para esta cédula
        $sql = "SELECT id FROM intentos_login WHERE cedula = :cedula";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':cedula' => $cedula]);
        $existe = $stmt->fetch();

        if ($existe) {
            // Actualizar intentos
            $sql = "UPDATE intentos_login 
                    SET intentos_fallidos = intentos_fallidos + 1, 
                        ultimo_intento = NOW() 
                    WHERE cedula = :cedula";
        } else {
            // Crear nuevo registro
            $sql = "INSERT INTO intentos_login (cedula, intentos_fallidos, ultimo_intento) 
                    VALUES (:cedula, 1, NOW())";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':cedula' => $cedula]);
    }

    /**
     * VALIDACIÓN 4: LIMPIAR INTENTOS FALLIDOS (AL INGRESAR CORRECTAMENTE)
     */
    private function limpiarIntentosFallidos($cedula) {
        $sql = "DELETE FROM intentos_login WHERE cedula = :cedula";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':cedula' => $cedula]);
    }

    /**
     * VALIDACIÓN 5: TIEMPO DE EJECUCIÓN CONSTANTE (EVITA ATAQUES DE TIMING)
     */
    private function hashEquals($known, $user) {
        if (function_exists('hash_equals')) {
            return hash_equals($known, $user);
        }
        // Fallback seguro si no existe hash_equals
        if (strlen($known) !== strlen($user)) {
            return false;
        }
        $result = 0;
        for ($i = 0; $i < strlen($known); $i++) {
            $result |= (ord($known[$i]) ^ ord($user[$i]));
        }
        return $result === 0;
    }

    /**
     * MÉTODO PRINCIPAL DE AUTENTICACIÓN
     * MODIFICADO: Ahora incluye tiempo restante en error de demasiados intentos
     */
    public function autenticar($cedula, $password) {
        try {
            // === VALIDACIÓN 1: Sanitización inicial ===
            $cedula = trim($cedula);
            $password = trim($password);

            // === VALIDACIÓN 2: Validación de formato ===
            $errores = $this->validarEntradas($cedula, $password);
            if (!empty($errores)) {
                // Por seguridad, devolvemos error genérico aunque sepamos cuál es
                return ['success' => false, 'error' => 'credenciales_invalidas'];
            }

            // === VALIDACIÓN 3: Control de intentos fallidos ===
            $verificacion = $this->verificarIntentosFallidos($cedula);
            if ($verificacion['bloqueado']) {
                return [
                    'success' => false, 
                    'error' => 'demasiados_intentos',
                    'tiempo' => $verificacion['tiempo_restante']
                ];
            }

            // === VALIDACIÓN 4: Consulta a la base de datos ===
            // MODIFICADO: Agregar más campos de la base de datos
            $sql = "SELECT id, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, 
                           cedula, fecha_nacimiento, genero, telefono, email, direccion, 
                           id_rol, password_hash, estado, fecha_registro, ultimo_login
                    FROM usuarios 
                    WHERE cedula = :cedula LIMIT 1";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([':cedula' => $cedula]);
            $usuario = $stmt->fetch();

            // === VALIDACIÓN 5: Verificación de existencia (tiempo constante) ===
            if (!$usuario) {
                // Registramos intento fallido para prevenir fuerza bruta
                $this->registrarIntentoFallido($cedula);
                return ['success' => false, 'error' => 'credenciales_invalidas'];
            }

            // === VALIDACIÓN 6: Verificación de estado de la cuenta ===
            if ($usuario['estado'] !== 'Activo') {
                return ['success' => false, 'error' => 'acceso_denegado'];
            }

            // === VALIDACIÓN 7: Verificación de contraseña (tiempo constante) ===
            $passwordValida = password_verify($password, $usuario['password_hash']);
            
            // Pequeña pausa artificial para evitar ataques de timing
            usleep(rand(100000, 300000)); // 0.1 a 0.3 segundos

            if ($passwordValida) {
                // === VALIDACIÓN 8: Limpiar intentos fallidos ===
                $this->limpiarIntentosFallidos($cedula);
                
                // === VALIDACIÓN 9: Registrar actividad ===
                $this->registrarActividad($usuario['id']);
                
                // Eliminar hash antes de devolver
                unset($usuario['password_hash']);
                return ['success' => true, 'usuario' => $usuario];
            } else {
                // === VALIDACIÓN 10: Registrar intento fallido ===
                $this->registrarIntentoFallido($cedula);
                return ['success' => false, 'error' => 'credenciales_invalidas'];
            }

        } catch (PDOException $e) {
            // Log interno para administradores
            error_log("Error en autenticación: " . $e->getMessage());
            return ['success' => false, 'error' => 'error_tecnico'];
        }
    }

    private function registrarActividad($id) {
        $sql = "UPDATE usuarios SET ultimo_login = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}

// --- 2. DISPARADOR DE ACCIÓN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new LoginBackend($pdo);
    $resultado = $auth->autenticar($_POST['cedula'], $_POST['password']);

    if ($resultado['success']) {
        // Iniciar sesión y guardar datos
        if (session_status() === PHP_SESSION_NONE) { 
            session_start(); 
        }
        
        // Regenerar ID de sesión para prevenir fijación de sesión
        session_regenerate_id(true);
        
        // ===== TODOS LOS CAMPOS DE LA BASE DE DATOS AGREGADOS A LA SESIÓN =====
        $_SESSION['user_id']           = $resultado['usuario']['id'];
        $_SESSION['primer_nombre']     = $resultado['usuario']['primer_nombre'];
        $_SESSION['segundo_nombre']    = $resultado['usuario']['segundo_nombre'] ?? ''; // Puede ser null
        $_SESSION['primer_apellido']   = $resultado['usuario']['primer_apellido'];
        $_SESSION['segundo_apellido']  = $resultado['usuario']['segundo_apellido'] ?? ''; // Puede ser null
        $_SESSION['cedula']            = $resultado['usuario']['cedula'];
        $_SESSION['fecha_nacimiento']  = $resultado['usuario']['fecha_nacimiento'];
        $_SESSION['genero']            = $resultado['usuario']['genero'];
        $_SESSION['telefono']          = $resultado['usuario']['telefono'];
        $_SESSION['email']             = $resultado['usuario']['email'];
        $_SESSION['direccion']         = $resultado['usuario']['direccion'];
        $_SESSION['id_rol']            = $resultado['usuario']['id_rol'];
        $_SESSION['estado']            = $resultado['usuario']['estado'];
        $_SESSION['fecha_registro']    = $resultado['usuario']['fecha_registro'];
        $_SESSION['ultimo_login']      = $resultado['usuario']['ultimo_login'];
        
        // Variables adicionales útiles
        $_SESSION['nombre_completo']   = $resultado['usuario']['primer_nombre'] . ' ' . 
                                          $resultado['usuario']['primer_apellido'];
        $_SESSION['logueado']          = true;
        $_SESSION['ultimo_acceso']     = time();
        $_SESSION['user_agent']        = $_SERVER['HTTP_USER_AGENT']; // Para fingerprinting

        // Redirigir al éxito
        header("Location: ../../auth/ingresar_backend.php");
        exit();
    } else {
        // === MODIFICADO: Redirigir con tiempo si existe ===
        $url = "/assets/frontend/login_frontend.php?error=" . $resultado['error'];
        if (isset($resultado['tiempo'])) {
            $url .= "&tiempo=" . $resultado['tiempo'];
        }
        header("Location: " . $url);
        exit();
    }
}

// --- 3. TABLA NECESARIA PARA CONTROL DE INTENTOS ---
/**
 *`intentos_login` 
 */
?>