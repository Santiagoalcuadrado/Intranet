<?php
/**
 * olvido_contrasena_ajax.php
 * Backend para recuperación de contraseña por preguntas de seguridad
 * Ubicación: /auth/olvido_contrasena_ajax.php
 */

// NO requiere session_check porque es acceso público
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexiondb.php';

header('Content-Type: application/json');

// =====================================================
// FUNCIÓN DE NORMALIZACIÓN (misma que en registro)
// =====================================================
function normalizarRespuesta($texto) {
    if (empty($texto)) return '';
    
    // Convertir a minúsculas
    $texto = mb_strtolower(trim($texto), 'UTF-8');
    
    // Eliminar tildes y diacríticos
    $acentos = [
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
        'ü' => 'u', 'ñ' => 'n',
        'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
    ];
    $texto = strtr($texto, $acentos);
    
    // Eliminar caracteres especiales y espacios múltiples
    $texto = preg_replace('/[^a-z0-9\s]/', '', $texto);
    $texto = preg_replace('/\s+/', ' ', $texto);
    
    return trim($texto);
}

// =====================================================
// FUNCIÓN PARA REGISTRAR INTENTOS
// =====================================================
function registrarIntento($pdo, $cedula, $usuario_id, $exito, $preguntas_acertadas = null, $detalle = null) {
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? null;
    
    $stmt = $pdo->prepare("
        INSERT INTO intentos_recuperacion 
        (cedula, usuario_id, user_agent, exito, preguntas_acertadas, detalle) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    return $stmt->execute([$cedula, $usuario_id, $user_agent, $exito, $preguntas_acertadas, $detalle]);
}

// =====================================================
// FUNCIÓN PARA VERIFICAR BLOQUEO
// =====================================================
function verificarBloqueo($pdo, $cedula) {
    // Limpiar bloqueos expirados
    $stmt = $pdo->prepare("
        UPDATE bloqueos_recuperacion 
        SET bloqueo_hasta = NULL 
        WHERE cedula = ? AND bloqueo_hasta < NOW()
    ");
    $stmt->execute([$cedula]);
    
    // Verificar si hay bloqueo activo
    $stmt = $pdo->prepare("
        SELECT bloqueo_hasta FROM bloqueos_recuperacion 
        WHERE cedula = ? AND bloqueo_hasta > NOW()
    ");
    $stmt->execute([$cedula]);
    $bloqueo = $stmt->fetchColumn();
    
    if ($bloqueo) {
        return ['bloqueado' => true, 'hasta' => $bloqueo];
    }
    
    return ['bloqueado' => false];
}

// =====================================================
// FUNCIÓN PARA REGISTRAR BLOQUEO
// =====================================================
function registrarIntentoFallido($pdo, $cedula, $usuario_id = null) {
    // Registrar intento fallido
    registrarIntento($pdo, $cedula, $usuario_id, 0, null, 'Intento fallido');
    
    // Actualizar o insertar en bloqueos
    $stmt = $pdo->prepare("
        INSERT INTO bloqueos_recuperacion (cedula, intentos_fallidos, primer_intento, ultimo_intento)
        VALUES (?, 1, NOW(), NOW())
        ON DUPLICATE KEY UPDATE
        intentos_fallidos = intentos_fallidos + 1,
        ultimo_intento = NOW(),
        bloqueo_hasta = IF(intentos_fallidos >= 3, DATE_ADD(NOW(), INTERVAL 15 MINUTE), NULL)
    ");
    $stmt->execute([$cedula]);
}

// =====================================================
// FUNCIÓN PARA VALIDAR CONTRASEÑA (SIN VALIDACIÓN DE LETRA)
// =====================================================
function validarContrasena($password) {
    $errores = [];
    
    if (strlen($password) < 9) {
        $errores[] = "La contraseña debe tener al menos 9 caracteres";
    }
    
    if (strlen($password) > 50) {
        $errores[] = "La contraseña no puede tener más de 50 caracteres";
    }
    
    if (!preg_match('/^[a-zA-Z0-9.*#]+$/', $password)) {
        $errores[] = "La contraseña solo puede contener letras, números y .*#";
    }
    
    // Verificar que tenga al menos un número (OPCIONAL - puedes quitarla también si quieres)
    if (!preg_match('/[0-9]/', $password)) {
        $errores[] = "La contraseña debe contener al menos un número";
    }
    
    return $errores;
}

// =====================================================
// PROCESAR ACCIONES
// =====================================================
$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

try {
    switch ($accion) {
        
        // =============================================
        // CASO 1: VERIFICAR CÉDULA Y OBTENER PREGUNTAS
        // =============================================
        case 'verificar_cedula':
            $cedula = $_POST['cedula'] ?? '';
            
            if (empty($cedula)) {
                echo json_encode(['success' => false, 'error' => 'La cédula es obligatoria']);
                exit();
            }
            
            // Verificar bloqueo
            $bloqueo = verificarBloqueo($pdo, $cedula);
            if ($bloqueo['bloqueado']) {
                echo json_encode([
                    'success' => false, 
                    'error' => 'Demasiados intentos fallidos. Intente después de 15 minutos.',
                    'bloqueado' => true
                ]);
                exit();
            }
            
            // Buscar usuario por cédula
            $stmt = $pdo->prepare("
                SELECT id, primer_nombre, primer_apellido, estado, bloqueo_recuperacion_hasta 
                FROM usuarios WHERE cedula = ? AND estado = 'Activo'
            ");
            $stmt->execute([$cedula]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$usuario) {
                // Registrar intento con cédula inexistente
                registrarIntentoFallido($pdo, $cedula, null);
                echo json_encode(['success' => false, 'error' => 'Cédula no registrada o usuario inactivo']);
                exit();
            }
            
            // Obtener las 3 preguntas de seguridad del usuario
            $stmt = $pdo->prepare("
                SELECT rs.pregunta_id, ps.pregunta 
                FROM respuestas_seguridad rs
                JOIN preguntas_seguridad ps ON ps.id = rs.pregunta_id
                WHERE rs.usuario_id = ?
                ORDER BY rs.id
                LIMIT 3
            ");
            $stmt->execute([$usuario['id']]);
            $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (count($preguntas) < 3) {
                echo json_encode([
                    'success' => false, 
                    'error' => 'El usuario no tiene preguntas de seguridad configuradas. Contacte al administrador.'
                ]);
                exit();
            }
            
            echo json_encode([
                'success' => true,
                'usuario_id' => $usuario['id'],
                'nombre' => $usuario['primer_nombre'] . ' ' . $usuario['primer_apellido'],
                'preguntas' => $preguntas
            ]);
            break;
        
        // =============================================
        // CASO 2: VERIFICAR RESPUESTAS
        // =============================================
        case 'verificar_respuestas':
            $usuario_id = $_POST['usuario_id'] ?? 0;
            
            // Recibir respuestas individuales
            $respuesta1 = $_POST['respuesta1'] ?? '';
            $respuesta2 = $_POST['respuesta2'] ?? '';
            $respuesta3 = $_POST['respuesta3'] ?? '';
            
            $pregunta_id1 = $_POST['pregunta_id1'] ?? 0;
            $pregunta_id2 = $_POST['pregunta_id2'] ?? 0;
            $pregunta_id3 = $_POST['pregunta_id3'] ?? 0;
            
            if (!$usuario_id || empty($respuesta1) || empty($respuesta2) || empty($respuesta3)) {
                echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
                exit();
            }
            
            // Obtener cédula del usuario
            $stmt = $pdo->prepare("SELECT cedula FROM usuarios WHERE id = ?");
            $stmt->execute([$usuario_id]);
            $cedula = $stmt->fetchColumn();
            
            // Verificar bloqueo
            $bloqueo = verificarBloqueo($pdo, $cedula);
            if ($bloqueo['bloqueado']) {
                echo json_encode([
                    'success' => false, 
                    'error' => 'Demasiados intentos fallidos. Intente después de 15 minutos.'
                ]);
                exit();
            }
            
            // Obtener los 3 hashes de respuestas del usuario
            $stmt = $pdo->prepare("
                SELECT pregunta_id, respuesta_hash 
                FROM respuestas_seguridad 
                WHERE usuario_id = ? AND pregunta_id IN (?, ?, ?)
            ");
            $stmt->execute([$usuario_id, $pregunta_id1, $pregunta_id2, $pregunta_id3]);
            $hashes = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
            
            $aciertos = 0;
            
            // Verificar respuesta 1
            if (isset($hashes[$pregunta_id1])) {
                $respuesta_normalizada = normalizarRespuesta($respuesta1);
                if (password_verify($respuesta_normalizada, $hashes[$pregunta_id1])) {
                    $aciertos++;
                }
            }
            
            // Verificar respuesta 2
            if (isset($hashes[$pregunta_id2])) {
                $respuesta_normalizada = normalizarRespuesta($respuesta2);
                if (password_verify($respuesta_normalizada, $hashes[$pregunta_id2])) {
                    $aciertos++;
                }
            }
            
            // Verificar respuesta 3
            if (isset($hashes[$pregunta_id3])) {
                $respuesta_normalizada = normalizarRespuesta($respuesta3);
                if (password_verify($respuesta_normalizada, $hashes[$pregunta_id3])) {
                    $aciertos++;
                }
            }
            
            if ($aciertos === 3) {
                // Todas correctas
                registrarIntento($pdo, $cedula, $usuario_id, 1, 3, 'Respuestas correctas');
                
                // Generar token temporal
                $token = bin2hex(random_bytes(32));
                $expiracion = date('Y-m-d H:i:s', strtotime('+15 minutes'));
                
                $stmt = $pdo->prepare("
                    UPDATE usuarios 
                    SET token_recuperacion = ?, token_expiracion = ? 
                    WHERE id = ?
                ");
                $stmt->execute([$token, $expiracion, $usuario_id]);
                
                echo json_encode([
                    'success' => true,
                    'mensaje' => 'Respuestas correctas',
                    'token' => $token
                ]);
            } else {
                // Al menos una incorrecta
                registrarIntentoFallido($pdo, $cedula, $usuario_id);
                echo json_encode([
                    'success' => false, 
                    'error' => 'Respuestas incorrectas. Le quedan ' . (3 - ($aciertos)) . ' intentos.'
                ]);
            }
            break;
        
        // =============================================
        // CASO 3: CAMBIAR CONTRASEÑA (SIN VALIDACIÓN DE LETRA)
        // =============================================
        case 'cambiar_contrasena':
            $usuario_id = $_POST['usuario_id'] ?? 0;
            $token = $_POST['token'] ?? '';
            $nueva_contrasena = $_POST['nueva_contrasena'] ?? '';
            $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';
            
            if (!$usuario_id || empty($token) || empty($nueva_contrasena) || empty($confirmar_contrasena)) {
                echo json_encode(['success' => false, 'error' => 'Todos los campos son obligatorios']);
                exit();
            }
            
            // ===== VALIDACIONES DE CONTRASEÑA (SIN VALIDACIÓN DE LETRA) =====
            $errores_password = [];
            
            // 1. Verificar que coincidan
            if ($nueva_contrasena !== $confirmar_contrasena) {
                $errores_password[] = "Las contraseñas no coinciden";
            }
            
            // 2. Verificar longitud mínima
            if (strlen($nueva_contrasena) < 9) {
                $errores_password[] = "La contraseña debe tener al menos 9 caracteres";
            }
            
            // 3. Verificar longitud máxima
            if (strlen($nueva_contrasena) > 50) {
                $errores_password[] = "La contraseña no puede tener más de 50 caracteres";
            }
            
            // 4. Verificar caracteres permitidos
            if (!preg_match('/^[a-zA-Z0-9.*#]+$/', $nueva_contrasena)) {
                $errores_password[] = "La contraseña solo puede contener letras, números y .*#";
            }
            
            // 5. Verificar que tenga al menos un número
            if (!preg_match('/[0-9]/', $nueva_contrasena)) {
                $errores_password[] = "La contraseña debe contener al menos un número";
            }
            
            // ❌ ELIMINADA la validación de "al menos una letra"
            
            // Si hay errores, devolver el primero
            if (!empty($errores_password)) {
                echo json_encode(['success' => false, 'error' => $errores_password[0]]);
                exit();
            }
            
            // Verificar token
            $stmt = $pdo->prepare("
                SELECT cedula, primer_nombre, primer_apellido, id_rol 
                FROM usuarios 
                WHERE id = ? AND token_recuperacion = ? AND token_expiracion > NOW()
            ");
            $stmt->execute([$usuario_id, $token]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$usuario) {
                echo json_encode(['success' => false, 'error' => 'Token inválido o expirado']);
                exit();
            }
            
            // Hashear nueva contraseña
            $password_hash = password_hash($nueva_contrasena, PASSWORD_BCRYPT);
            
            // Actualizar contraseña y limpiar token
            $pdo->beginTransaction();
            
            $stmt = $pdo->prepare("
                UPDATE usuarios 
                SET password_hash = ?, 
                    contrasena_modificacion = NOW(),
                    token_recuperacion = NULL,
                    token_expiracion = NULL,
                    ultima_recuperacion_exitosa = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$password_hash, $usuario_id]);
            
            // Registrar en logs
            $nombre_completo = $usuario['primer_nombre'] . ' ' . $usuario['primer_apellido'];
            $rol = ($usuario['id_rol'] == 1) ? 'Administrador' : 'Usuario';
            
            $stmt = $pdo->prepare("
                INSERT INTO logs 
                (usuario_id, usuario_nombre, usuario_cedula, usuario_rol, accion, tabla, registro_id, registro_titulo, detalle) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $usuario_id,
                $nombre_completo,
                $usuario['cedula'],
                $rol,
                'recuperar_contrasena',
                'usuarios',
                $usuario_id,
                $nombre_completo,
                'Usuario recuperó contraseña mediante preguntas de seguridad'
            ]);
            
            // Registrar en historial de cambios de preguntas (auditoría específica)
            $stmt = $pdo->prepare("
                INSERT INTO historial_cambios_preguntas
                (usuario_afectado_id, usuario_afectado_nombre, usuario_afectado_cedula,
                 accion, realizado_por_id, realizado_por_nombre, realizado_por_cedula, realizado_por_rol,
                 detalle)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $usuario_id,
                $nombre_completo,
                $usuario['cedula'],
                'recuperacion_contrasena',
                $usuario_id,
                $nombre_completo,
                $usuario['cedula'],
                $rol,
                'Cambio de contraseña por recuperación exitosa'
            ]);
            
            $pdo->commit();
            
            echo json_encode([
                'success' => true,
                'mensaje' => 'Contraseña actualizada correctamente. Ya puede iniciar sesión.'
            ]);
            break;
        
        default:
            echo json_encode(['success' => false, 'error' => 'Acción no válida']);
    }
    
} catch (PDOException $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['success' => false, 'error' => 'Error en el servidor: ' . $e->getMessage()]);
}
?>