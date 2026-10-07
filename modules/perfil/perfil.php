<?php
/**
 * perfil.php
 * BACKEND para la página de perfil de usuario
 * Ubicación: /modules/perfil/perfil.php
 */

// ===== INCLUIR VERIFICADOR DE SESIÓN =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== INCLUIR CONEXIÓN A LA BASE DE DATOS =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexiondb.php';

// ===== INICIAR SESIÓN PARA MENSAJES =====
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ===== FUNCIÓN PARA NORMALIZAR RESPUESTAS (misma que en recuperación) =====
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

// ===== FUNCIÓN PARA REGISTRAR EN LOGS =====
function registrarLog($pdo, $accion, $tabla, $registro_id, $registro_titulo, $detalle = null) {
    // Obtener datos del usuario actual
    $usuario_id = $_SESSION['user_id'];
    
    // Obtener nombre completo y cédula del usuario
    $stmt = $pdo->prepare("SELECT primer_nombre, primer_apellido, cedula, id_rol FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch();
    
    if (!$usuario) {
        return false;
    }
    
    $usuario_nombre = $usuario['primer_nombre'] . ' ' . $usuario['primer_apellido'];
    $usuario_cedula = $usuario['cedula'];
    
    // Obtener rol del usuario
    $stmt = $pdo->prepare("SELECT nombre_rol FROM roles WHERE id = ?");
    $stmt->execute([$usuario['id_rol']]);
    $rol = $stmt->fetchColumn();
    
    $sql = "INSERT INTO logs 
            (usuario_id, usuario_nombre, usuario_cedula, usuario_rol, accion, tabla, registro_id, registro_titulo, detalle) 
            VALUES 
            (:usuario_id, :usuario_nombre, :usuario_cedula, :usuario_rol, :accion, :tabla, :registro_id, :registro_titulo, :detalle)";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':usuario_nombre' => $usuario_nombre,
        ':usuario_cedula' => $usuario_cedula,
        ':usuario_rol' => $rol,
        ':accion' => $accion,
        ':tabla' => $tabla,
        ':registro_id' => $registro_id,
        ':registro_titulo' => $registro_titulo,
        ':detalle' => $detalle
    ]);
}

// ===== VARIABLES PARA LA VISTA =====
$titulo_pagina = "Mi Perfil";
$usuario = null;
$error = null;
$success = null;

try {
    // ===== OBTENER DATOS DEL USUARIO DESDE LA BASE DE DATOS =====
    $sql = "SELECT 
                u.primer_nombre, 
                u.segundo_nombre, 
                u.primer_apellido, 
                u.segundo_apellido, 
                u.cedula, 
                u.fecha_nacimiento, 
                u.genero, 
                u.telefono, 
                u.email, 
                u.direccion,
                u.id_rol,
                u.estado,
                u.fecha_registro,
                u.ultima_modificacion,
                u.ultimo_login,
                u.fecha_ingreso,
                u.telefono_modificacion,
                u.email_modificacion,
                u.direccion_modificacion,
                u.contrasena_modificacion,
                u.rol_modificacion,
                r.nombre_rol
            FROM usuarios u
            LEFT JOIN roles r ON u.id_rol = r.id
            WHERE u.id = :id LIMIT 1";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        header("Location: /assets/frontend/login_frontend.php?error=acceso_denegado");
        exit();
    }

    // ===== OBTENER PREGUNTAS DE SEGURIDAD DEL USUARIO =====
    $stmt_preguntas = $pdo->prepare("
        SELECT rs.pregunta_id, ps.pregunta, rs.respuesta_hash, 
            rs.fecha_modificacion
        FROM respuestas_seguridad rs
        JOIN preguntas_seguridad ps ON ps.id = rs.pregunta_id
        WHERE rs.usuario_id = ?
        ORDER BY rs.id
        LIMIT 3
    ");
    $stmt_preguntas->execute([$_SESSION['user_id']]);
    $preguntas_usuario = $stmt_preguntas->fetchAll(PDO::FETCH_ASSOC);

    // ===== OBTENER TODAS LAS PREGUNTAS DISPONIBLES PARA EL SELECT =====
    $stmt_todas = $pdo->prepare("SELECT id, pregunta FROM preguntas_seguridad WHERE activa = 1 ORDER BY orden");
    $stmt_todas->execute();
    $todas_preguntas = $stmt_todas->fetchAll(PDO::FETCH_ASSOC);

    // ===== CALCULAR EDAD =====
    $fecha_nacimiento = new DateTime($usuario['fecha_nacimiento']);
    $hoy = new DateTime();
    $edad = $hoy->diff($fecha_nacimiento)->y;

    // ===== FORMATEAR FECHAS PARA LA VISTA =====
    $fecha_registro = date('d/m/Y', strtotime($usuario['fecha_registro']));
    $ultima_modificacion = $usuario['ultima_modificacion'] ? date('d/m/Y H:i', strtotime($usuario['ultima_modificacion'])) : 'N/A';
    $ultimo_login = $usuario['ultimo_login'] ? date('d/m/Y H:i', strtotime($usuario['ultimo_login'])) : 'Nunca';
    $fecha_ingreso = $usuario['fecha_ingreso'] ? date('d/m/Y', strtotime($usuario['fecha_ingreso'])) : 'No registrada';

    // ===== NOMBRE COMPLETO =====
    $nombre_completo = trim($usuario['primer_nombre'] . ' ' . $usuario['segundo_nombre']);
    $apellido_completo = trim($usuario['primer_apellido'] . ' ' . $usuario['segundo_apellido']);

    // ===== NOMBRE DEL ROL =====
    $nombre_rol = $usuario['nombre_rol'] ?? 'Usuario';

} catch (PDOException $e) {
    error_log("Error al obtener perfil: " . $e->getMessage());
    $error = "error_tecnico";
}

// ===== PROCESAR ACTUALIZACIÓN DEL PERFIL (SI ES POST) =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'actualizar_perfil') {
    
    try {
        // ===== RECOGER DATOS ACTUALES =====
        $telefono_actual = $usuario['telefono'];
        $email_actual = $usuario['email'];
        $direccion_actual = $usuario['direccion'];
        
        // ===== RECOGER NUEVOS DATOS =====
        $telefono_nuevo = trim($_POST['telefono'] ?? '');
        $email_nuevo = trim($_POST['email'] ?? '');
        $direccion_nuevo = trim($_POST['direccion'] ?? '');
        $nueva_password = $_POST['nueva_password'] ?? '';
        $confirmar_password = $_POST['confirmar_password'] ?? '';
        
        // ===== RECOGER PREGUNTAS DE SEGURIDAD =====
        $pregunta_ids = $_POST['pregunta_id'] ?? [];
        $respuestas = $_POST['respuesta'] ?? [];
        
        // ===== ARRAYS PARA CONSTRUIR LA CONSULTA =====
        $errores = [];
        $campos_actualizar = [];
        $params = [':id' => $_SESSION['user_id']];
        $fecha_actual = date('Y-m-d H:i:s');
        
        // ===== VALIDAR Y PREPARAR TELÉFONO (SOLO SI CAMBIÓ) =====
        if ($telefono_nuevo !== $telefono_actual) {
            if (empty($telefono_nuevo)) {
                $errores[] = "El teléfono es obligatorio";
            } elseif (!preg_match('/^[0-9]{10,11}$/', $telefono_nuevo)) {
                $errores[] = "El teléfono debe tener entre 10 y 11 dígitos numéricos";
            } else {
                // Verificar duplicado
                $check = $pdo->prepare("SELECT id FROM usuarios WHERE telefono = :tel AND id != :id");
                $check->execute([':tel' => $telefono_nuevo, ':id' => $_SESSION['user_id']]);
                if ($check->fetch()) {
                    $errores[] = "El teléfono ya está registrado por otro usuario";
                } else {
                    $campos_actualizar[] = "telefono = :telefono";
                    $campos_actualizar[] = "telefono_modificacion = :tel_fecha";
                    $params[':telefono'] = $telefono_nuevo;
                    $params[':tel_fecha'] = $fecha_actual;
                }
            }
        }
        
        // ===== VALIDAR Y PREPARAR EMAIL (SOLO SI CAMBIÓ) =====
        if ($email_nuevo !== $email_actual) {
            if (empty($email_nuevo)) {
                $errores[] = "El email es obligatorio";
            } elseif (strlen($email_nuevo) < 5) {
                $errores[] = "El email debe tener al menos 5 caracteres";
            } elseif (!filter_var($email_nuevo, FILTER_VALIDATE_EMAIL)) {
                $errores[] = "El formato del email no es válido";
            } else {
                // Verificar duplicado
                $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email AND id != :id");
                $check->execute([':email' => $email_nuevo, ':id' => $_SESSION['user_id']]);
                if ($check->fetch()) {
                    $errores[] = "El email ya está registrado por otro usuario";
                } else {
                    $campos_actualizar[] = "email = :email";
                    $campos_actualizar[] = "email_modificacion = :email_fecha";
                    $params[':email'] = $email_nuevo;
                    $params[':email_fecha'] = $fecha_actual;
                }
            }
        }
        
        // ===== VALIDAR Y PREPARAR DIRECCIÓN (SOLO SI CAMBIÓ) =====
        if ($direccion_nuevo !== $direccion_actual) {
            if (empty($direccion_nuevo)) {
                $errores[] = "La dirección es obligatoria";
            } elseif (strlen($direccion_nuevo) < 10) {
                $errores[] = "La dirección debe tener al menos 10 caracteres";
            } elseif (!preg_match('/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.,\*#\?\-\(\)]+$/', $direccion_nuevo)) {
                $errores[] = "La dirección contiene caracteres no permitidos";
            } else {
                $campos_actualizar[] = "direccion = :direccion";
                $campos_actualizar[] = "direccion_modificacion = :dir_fecha";
                $params[':direccion'] = $direccion_nuevo;
                $params[':dir_fecha'] = $fecha_actual;
            }
        }
        
        // ===== VALIDAR CONTRASEÑA (SOLO SI SE INGRESÓ) =====
        if (!empty($nueva_password) || !empty($confirmar_password)) {
            
            if (empty($nueva_password)) {
                $errores[] = "Debe ingresar una nueva contraseña";
            } elseif (strlen($nueva_password) < 9) {
                $errores[] = "La contraseña debe tener al menos 9 caracteres";
            } elseif (strlen($nueva_password) > 50) {
                $errores[] = "La contraseña no puede tener más de 50 caracteres";
            } elseif (!preg_match('/^[a-zA-Z0-9.*#]+$/', $nueva_password)) {
                $errores[] = "La contraseña solo puede contener letras, números y .*#";
            } elseif (empty($confirmar_password)) {
                $errores[] = "Debe confirmar la nueva contraseña";
            } elseif ($nueva_password !== $confirmar_password) {
                $errores[] = "Las contraseñas no coinciden";
            } else {
                $campos_actualizar[] = "password_hash = :password_hash";
                $campos_actualizar[] = "contrasena_modificacion = :pass_fecha";
                $params[':password_hash'] = password_hash($nueva_password, PASSWORD_BCRYPT);
                $params[':pass_fecha'] = $fecha_actual;
            }
        }
        
        // ===== VALIDAR PREGUNTAS DE SEGURIDAD =====
        // Verificar si hay al menos una pregunta seleccionada o respuesta llena
        $hayPreguntasSeleccionadas = false;
        $hayRespuestasLlenas = false;
        
        foreach ($pregunta_ids as $id) {
            if (!empty($id)) {
                $hayPreguntasSeleccionadas = true;
                break;
            }
        }
        
        foreach ($respuestas as $resp) {
            if (!empty(trim($resp))) {
                $hayRespuestasLlenas = true;
                break;
            }
        }
        
        // Solo validar si hay intención de cambiar (como en el frontend con el checkbox)
        if ($hayPreguntasSeleccionadas || $hayRespuestasLlenas) {
            // Validar que sean exactamente 3 preguntas
            if (count($pregunta_ids) !== 3 || count($respuestas) !== 3) {
                $errores[] = "Debe seleccionar 3 preguntas de seguridad y proporcionar sus respuestas";
            } else {
                // Verificar que todas las preguntas estén seleccionadas
                $todas_seleccionadas = true;
                foreach ($pregunta_ids as $id) {
                    if (empty($id)) {
                        $todas_seleccionadas = false;
                        break;
                    }
                }
                
                if (!$todas_seleccionadas) {
                    $errores[] = "Debe seleccionar las 3 preguntas de seguridad";
                } else {
                    // Verificar que no haya preguntas duplicadas
                    if (count(array_unique($pregunta_ids)) !== 3) {
                        $errores[] = "No puede seleccionar la misma pregunta más de una vez";
                    }
                    
                    // Validar cada respuesta
                    foreach ($respuestas as $index => $respuesta) {
                        $respuesta = trim($respuesta);
                        if (empty($respuesta)) {
                            $errores[] = "La respuesta " . ($index + 1) . " es obligatoria";
                        } elseif (strlen($respuesta) < 3) {
                            $errores[] = "La respuesta " . ($index + 1) . " debe tener al menos 3 caracteres";
                        } elseif (strlen($respuesta) > 50) {
                            $errores[] = "La respuesta " . ($index + 1) . " no puede tener más de 50 caracteres";
                        }
                    }
                }
            }
        }
        
        // ===== SI HAY ERRORES, DETENER =====
        if (!empty($errores)) {
            $_SESSION['error_perfil'] = implode("<br>", $errores);
            header("Location: /modules/perfil/perfil.php");
            exit();
        }
        
        // ===== SI HAY CAMPOS PARA ACTUALIZAR EN USUARIO, EJECUTAR =====
        $pdo->beginTransaction();
        
        if (!empty($campos_actualizar)) {
            $update_sql = "UPDATE usuarios SET " . implode(", ", $campos_actualizar) . " WHERE id = :id";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->execute($params);
        }
        
        // ===== ACTUALIZAR PREGUNTAS DE SEGURIDAD (SOLO SI HAY INTENCIÓN DE CAMBIO) =====
        if ($hayPreguntasSeleccionadas || $hayRespuestasLlenas) {
            
            // Obtener respuestas anteriores para el log
            $stmt_old = $pdo->prepare("SELECT pregunta_id FROM respuestas_seguridad WHERE usuario_id = ?");
            $stmt_old->execute([$_SESSION['user_id']]);
            $preguntas_anteriores = $stmt_old->fetchAll(PDO::FETCH_COLUMN);
            
            // Eliminar respuestas anteriores
            $stmt_del = $pdo->prepare("DELETE FROM respuestas_seguridad WHERE usuario_id = ?");
            $stmt_del->execute([$_SESSION['user_id']]);
            
            // Insertar nuevas respuestas (HASHEADAS)
            $stmt_ins = $pdo->prepare("
                INSERT INTO respuestas_seguridad 
                (usuario_id, pregunta_id, respuesta_hash, creado_por_id, creado_por_nombre, creado_por_cedula, creado_por_rol, fecha_modificacion) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
            ");
            
            $nombre_completo_log = trim($usuario['primer_nombre'] . ' ' . $usuario['primer_apellido']);
            $rol = ($usuario['id_rol'] == 1) ? 'Administrador' : 'Usuario';
            
            for ($i = 0; $i < 3; $i++) {
                // Normalizar y hashear la respuesta
                $respuesta_normalizada = normalizarRespuesta($respuestas[$i]);
                $respuesta_hash = password_hash($respuesta_normalizada, PASSWORD_BCRYPT);
                
                $stmt_ins->execute([
                    $_SESSION['user_id'],
                    $pregunta_ids[$i],
                    $respuesta_hash,
                    $_SESSION['user_id'],
                    $nombre_completo_log,
                    $usuario['cedula'],
                    $rol
                ]);
            }
            
            // ===== REGISTRAR EN HISTORIAL DE CAMBIOS DE PREGUNTAS =====
            $stmt_hist = $pdo->prepare("
                INSERT INTO historial_cambios_preguntas
                (usuario_afectado_id, usuario_afectado_nombre, usuario_afectado_cedula,
                 accion, realizado_por_id, realizado_por_nombre, realizado_por_cedula, realizado_por_rol,
                 detalle)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $detalle = "Actualizó preguntas de seguridad";
            if (!empty($preguntas_anteriores)) {
                $detalle .= " (IDs anteriores: " . implode(', ', $preguntas_anteriores) . ")";
            }
            
            $stmt_hist->execute([
                $_SESSION['user_id'],
                $nombre_completo_log,
                $usuario['cedula'],
                'actualizacion_preguntas',
                $_SESSION['user_id'],
                $nombre_completo_log,
                $usuario['cedula'],
                $rol,
                $detalle
            ]);
            
            // Registrar cambio de preguntas en logs generales
            registrarLog(
                $pdo,
                'actualizar_preguntas_seguridad',
                'respuestas_seguridad',
                $_SESSION['user_id'],
                $nombre_completo_log . ' ' . $apellido_completo,
                'Actualizó sus preguntas de seguridad'
            );
        }
        
        // ===== REGISTRAR EN LOGS GENERALES =====
        $cambios_detalle = [];
        
        if ($telefono_nuevo !== $telefono_actual) {
            $cambios_detalle[] = "Teléfono: '$telefono_actual' → '$telefono_nuevo'";
        }
        
        if ($email_nuevo !== $email_actual) {
            $cambios_detalle[] = "Email: '$email_actual' → '$email_nuevo'";
        }
        
        if ($direccion_nuevo !== $direccion_actual) {
            $dir_anterior = strlen($direccion_actual) > 50 ? substr($direccion_actual, 0, 47) . '...' : $direccion_actual;
            $dir_nueva = strlen($direccion_nuevo) > 50 ? substr($direccion_nuevo, 0, 47) . '...' : $direccion_nuevo;
            $cambios_detalle[] = "Dirección: '$dir_anterior' → '$dir_nueva'";
        }
        
        // Registrar cambios de perfil
        if (!empty($cambios_detalle)) {
            $detalle_completo = "Actualizó: " . implode(' | ', $cambios_detalle);
            registrarLog(
                $pdo,
                'editar_perfil',
                'usuarios',
                $_SESSION['user_id'],
                $nombre_completo_log . ' ' . $apellido_completo,
                $detalle_completo
            );
        }
        
        // Registrar cambio de contraseña si aplica
        if (!empty($nueva_password)) {
            registrarLog(
                $pdo,
                'cambiar_contrasena',
                'usuarios',
                $_SESSION['user_id'],
                $nombre_completo_log . ' ' . $apellido_completo,
                'Cambió su contraseña'
            );
        }
        
        $pdo->commit();
        
        $_SESSION['success_perfil'] = "Perfil actualizado correctamente";
        header("Location: /modules/perfil/perfil.php");
        exit();
        
    } catch (PDOException $e) {
        if (isset($pdo)) $pdo->rollBack();
        error_log("Error al actualizar perfil: " . $e->getMessage());
        $_SESSION['error_perfil'] = "Error al actualizar el perfil. Intente nuevamente.";
        header("Location: /modules/perfil/perfil.php");
        exit();
    }
}

// ===== RECUPERAR MENSAJES DE SESIÓN =====
if (isset($_SESSION['error_perfil'])) {
    $error = $_SESSION['error_perfil'];
    unset($_SESSION['error_perfil']);
}

if (isset($_SESSION['success_perfil'])) {
    $success = $_SESSION['success_perfil'];
    unset($_SESSION['success_perfil']);
}

// ===== INCLUIR LA VISTA (frontend) =====
include $_SERVER['DOCUMENT_ROOT'] . '/assets/frontend/perfil_frontend.php';
exit();
?>