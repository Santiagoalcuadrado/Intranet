<?php
/**
 * crud_admin_ajax.php
 * API para peticiones AJAX del CRUD de usuarios
 * Ubicación: /modules/admin/crud_admin_ajax.php
 */

// ===== SEGURIDAD =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexiondb.php';

header('Content-Type: application/json');

// ===== VERIFICAR QUE SEA ADMIN =====
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'Administrador') {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso denegado']);
    exit();
}

// ===== FUNCIÓN PARA REGISTRAR EN LOGS =====
function registrarLog($pdo, $accion, $tabla, $registro_id, $registro_titulo, $detalle = null) {
    $usuario_id = $_SESSION['user_id'];
    
    $stmt = $pdo->prepare("SELECT primer_nombre, primer_apellido, cedula, id_rol FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch();
    
    $usuario_nombre = $usuario['primer_nombre'] . ' ' . $usuario['primer_apellido'];
    $usuario_cedula = $usuario['cedula'];
    
    $stmt = $pdo->prepare("SELECT nombre_rol FROM roles WHERE id = ?");
    $stmt->execute([$usuario['id_rol']]);
    $rol = $stmt->fetchColumn();
    
    $sql = "INSERT INTO logs 
            (usuario_id, usuario_nombre, usuario_cedula, usuario_rol, accion, tabla, registro_id, registro_titulo, detalle) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario_id, $usuario_nombre, $usuario_cedula, $rol, $accion, $tabla, $registro_id, $registro_titulo, $detalle]);
}

// ===== FUNCIÓN PARA VALIDAR FECHAS (NUEVA) =====
function validarFechas($fecha_ingreso, $fecha_egreso = null) {
    $hoy = date('Y-m-d');
    
    // Validar que fecha ingreso no sea futura
    if ($fecha_ingreso > $hoy) {
        return "La fecha de ingreso no puede ser futura";
    }
    
    // Validar fecha egreso si existe
    if (!empty($fecha_egreso)) {
        if ($fecha_egreso > $hoy) {
            return "La fecha de egreso no puede ser futura";
        }
        if ($fecha_egreso < $fecha_ingreso) {
            return "La fecha de egreso no puede ser anterior a la fecha de ingreso";
        }
    }
    
    return null;
}

// ===== FUNCIONES DE VALIDACIÓN EXISTENTES =====
function normalizarTexto($texto) {
    if (empty($texto)) return null;
    $texto = preg_replace('/\s+/', ' ', trim($texto));
    $texto = mb_strtolower($texto, 'UTF-8');
    return mb_convert_case($texto, MB_CASE_TITLE, 'UTF-8');
}

function limpiarCedula($cedula) {
    return preg_replace('/[^0-9]/', '', $cedula);
}

function validarNombre($nombre, $campo, $esObligatorio = true) {
    if ($esObligatorio && empty($nombre)) {
        return "El $campo es obligatorio";
    }
    if (!empty($nombre)) {
        if (!preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ]{3,}$/u', trim($nombre))) {
            return "El $campo debe tener al menos 3 letras y no puede contener números ni espacios";
        }
    }
    return null;
}

function validarTelefono($telefono, $esObligatorio = true) {
    if ($esObligatorio && empty($telefono)) {
        return "El teléfono es obligatorio";
    }
    if (!empty($telefono)) {
        $telefono = preg_replace('/[^0-9]/', '', $telefono);
        if (!preg_match('/^[0-9]{10,11}$/', $telefono)) {
            return "El teléfono debe tener entre 10 y 11 dígitos numéricos";
        }
    }
    return null;
}

function validarCedula($cedula, $esObligatorio = true) {
    if ($esObligatorio && empty($cedula)) {
        return "La cédula es obligatoria";
    }
    if (!empty($cedula)) {
        $cedula = preg_replace('/[^0-9]/', '', $cedula);
        if (!preg_match('/^[0-9]{7,10}$/', $cedula)) {
            return "La cédula debe tener entre 7 y 10 dígitos numéricos";
        }
    }
    return null;
}

function validarEmail($email, $esObligatorio = true) {
    if ($esObligatorio && empty($email)) {
        return "El email es obligatorio";
    }
    if (!empty($email)) {
        if (strlen($email) < 5) {
            return "El email debe tener al menos 5 caracteres";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "El formato del email no es válido";
        }
    }
    return null;
}

function validarDireccion($direccion, $esObligatorio = true) {
    if ($esObligatorio && empty($direccion)) {
        return "La dirección es obligatoria";
    }
    if (!empty($direccion)) {
        if (strlen($direccion) < 10) {
            return "La dirección debe tener al menos 10 caracteres";
        }
        if (!preg_match('/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.,\*#\?\-\(\)]+$/', $direccion)) {
            return "La dirección contiene caracteres no permitidos";
        }
    }
    return null;
}

function validarPassword($password, $confirmar = null, $requerido = false) {
    if ($requerido && empty($password)) {
        return "La contraseña es obligatoria";
    }
    if (!empty($password)) {
        if (strlen($password) < 9) {
            return "La contraseña debe tener al menos 9 caracteres";
        }
        if (strlen($password) > 50) {
            return "La contraseña no puede tener más de 50 caracteres";
        }
        if (!preg_match('/^[a-zA-Z0-9.*#]+$/', $password)) {
            return "La contraseña solo puede contener letras, números y .*#";
        }
        if ($confirmar !== null && $password !== $confirmar) {
            return "Las contraseñas no coinciden";
        }
    }
    return null;
}

// ===== FUNCIÓN PARA NORMALIZAR RESPUESTAS =====
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

// ===== PROCESAR ACCIONES =====
$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

switch ($accion) {
    
    case 'listar':
        $pagina = $_GET['pagina'] ?? 1;
        $limite = 10;
        $offset = ($pagina - 1) * $limite;
        
        $count = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE id != 1")->fetchColumn();
        $total_paginas = ceil($count / $limite);
        
        $stmt = $pdo->prepare("
            SELECT u.*, r.nombre_rol 
            FROM usuarios u 
            JOIN roles r ON u.id_rol = r.id 
            WHERE u.id != 1 
            ORDER BY 
                CASE 
                    WHEN u.estado = 'Activo' THEN 1
                    WHEN u.estado = 'Suspendido' THEN 2
                    WHEN u.estado = 'Inactivo' THEN 3
                END,
                u.id
            LIMIT :limite OFFSET :offset
        ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'usuarios' => $usuarios,
            'total_paginas' => $total_paginas,
            'pagina_actual' => (int)$pagina
        ]);
        break;
    
    case 'obtener':
        $id = $_GET['id'] ?? 0;
        
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($usuario) {
            echo json_encode(['success' => true, 'usuario' => $usuario]);
        } else {
            echo json_encode(['success' => false, 'errores' => ['Usuario no encontrado']]);
        }
        break;
    
// ===== LISTAR PREGUNTAS DISPONIBLES =====
case 'listar_preguntas':
    $stmt = $pdo->prepare("SELECT id, pregunta FROM preguntas_seguridad WHERE activa = 1 ORDER BY orden");
    $stmt->execute();
    $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'preguntas' => $preguntas]);
    break;

// ===== OBTENER PREGUNTAS DE UN USUARIO =====
case 'obtener_preguntas_usuario':
    $usuario_id = $_GET['usuario_id'] ?? 0;
    
    if (!$usuario_id) {
        echo json_encode(['success' => false, 'error' => 'ID no válido']);
        exit();
    }
    
    $stmt = $pdo->prepare("
        SELECT pregunta_id 
        FROM respuestas_seguridad 
        WHERE usuario_id = ? 
        ORDER BY id 
        LIMIT 3
    ");
    $stmt->execute([$usuario_id]);
    $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['success' => true, 'preguntas' => $preguntas]);
    break;

// ===== GUARDAR PREGUNTAS DE SEGURIDAD =====
case 'guardar_preguntas':
    $data = json_decode(file_get_contents('php://input'), true);
    $usuario_id = $data['usuario_id'] ?? 0;
    $pregunta_ids = $data['pregunta_ids'] ?? [];
    $respuestas = $data['respuestas'] ?? [];
    
    if (!$usuario_id || count($pregunta_ids) !== 3 || count($respuestas) !== 3) {
        echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
        exit();
    }
    
    // Validar que no haya preguntas duplicadas
    if (count(array_unique($pregunta_ids)) !== 3) {
        echo json_encode(['success' => false, 'error' => 'No puede seleccionar la misma pregunta más de una vez']);
        exit();
    }
    
    // Validar cada respuesta
    $errores = [];
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
    
    if (!empty($errores)) {
        echo json_encode(['success' => false, 'errores' => $errores]);
        exit();
    }
    
    // ===== OBTENER DATOS DEL ADMIN DESDE LA BD =====
    $stmt = $pdo->prepare("SELECT primer_nombre, primer_apellido, cedula FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $admin = $stmt->fetch();
    
    if (!$admin) {
        echo json_encode(['success' => false, 'error' => 'Administrador no encontrado']);
        exit();
    }
    
    $admin_nombre = $admin['primer_nombre'] . ' ' . $admin['primer_apellido'];
    $admin_cedula = $admin['cedula'];
    
    // Obtener datos del usuario para el log
    $stmt = $pdo->prepare("SELECT primer_nombre, primer_apellido, cedula, id_rol FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch();
    
    if (!$usuario) {
        echo json_encode(['success' => false, 'error' => 'Usuario no encontrado']);
        exit();
    }
    
    $pdo->beginTransaction();
    
    try {
        // Obtener preguntas anteriores para el log
        $stmt_old = $pdo->prepare("SELECT pregunta_id FROM respuestas_seguridad WHERE usuario_id = ?");
        $stmt_old->execute([$usuario_id]);
        $preguntas_anteriores = $stmt_old->fetchAll(PDO::FETCH_COLUMN);
        
        // Eliminar respuestas anteriores
        $stmt_del = $pdo->prepare("DELETE FROM respuestas_seguridad WHERE usuario_id = ?");
        $stmt_del->execute([$usuario_id]);
        
        // Insertar nuevas respuestas
        $stmt_ins = $pdo->prepare("
            INSERT INTO respuestas_seguridad 
            (usuario_id, pregunta_id, respuesta_hash, creado_por_id, creado_por_nombre, creado_por_cedula, creado_por_rol, fecha_modificacion) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        
        $rol = ($usuario['id_rol'] == 1) ? 'Administrador' : 'Usuario';
        
        for ($i = 0; $i < 3; $i++) {
            // Normalizar y hashear la respuesta
            $respuesta_normalizada = normalizarRespuesta($respuestas[$i]);
            $respuesta_hash = password_hash($respuesta_normalizada, PASSWORD_BCRYPT);
            
            $stmt_ins->execute([
                $usuario_id,
                $pregunta_ids[$i],
                $respuesta_hash,
                $_SESSION['user_id'],
                $admin_nombre,  // ← Usamos variable obtenida de BD
                $admin_cedula,   // ← Usamos variable obtenida de BD
                $_SESSION['rol']
            ]);
        }
        
        // Registrar en historial
        $stmt_hist = $pdo->prepare("
            INSERT INTO historial_cambios_preguntas
            (usuario_afectado_id, usuario_afectado_nombre, usuario_afectado_cedula,
             accion, realizado_por_id, realizado_por_nombre, realizado_por_cedula, realizado_por_rol,
             detalle)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $detalle = "Admin configuró preguntas de seguridad";
        if (!empty($preguntas_anteriores)) {
            $detalle .= " (IDs anteriores: " . implode(', ', $preguntas_anteriores) . ")";
        }
        
        $stmt_hist->execute([
            $usuario_id,
            $usuario['primer_nombre'] . ' ' . $usuario['primer_apellido'],
            $usuario['cedula'],
            'admin_configuro_preguntas',
            $_SESSION['user_id'],
            $admin_nombre,
            $admin_cedula,
            $_SESSION['rol'],
            $detalle
        ]);
        
        // Registrar en logs
        $stmt_log = $pdo->prepare("
            INSERT INTO logs 
            (usuario_id, usuario_nombre, usuario_cedula, usuario_rol, accion, tabla, registro_id, registro_titulo, detalle) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt_log->execute([
            $_SESSION['user_id'],
            $admin_nombre,
            $admin_cedula,
            $_SESSION['rol'],
            'configurar_preguntas_usuario',
            'respuestas_seguridad',
            $usuario_id,
            $usuario['primer_nombre'] . ' ' . $usuario['primer_apellido'],
            "Configuró preguntas de seguridad para: " . $usuario['primer_nombre'] . ' ' . $usuario['primer_apellido']
        ]);
        
        $pdo->commit();
        
        echo json_encode(['success' => true, 'mensaje' => 'Preguntas de seguridad guardadas correctamente']);
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'error' => 'Error al guardar preguntas: ' . $e->getMessage()]);
    }
    break;

    case 'crear':
        $data = json_decode(file_get_contents('php://input'), true);
        
        $errores = [];
        
        // Validar nombres y apellidos
        $error = validarNombre($data['primer_nombre'] ?? '', 'primer nombre', true);
        if ($error) $errores[] = $error;
        
        if (!empty($data['segundo_nombre'])) {
            $error = validarNombre($data['segundo_nombre'], 'segundo nombre', false);
            if ($error) $errores[] = $error;
        }
        
        $error = validarNombre($data['primer_apellido'] ?? '', 'primer apellido', true);
        if ($error) $errores[] = $error;
        
        if (!empty($data['segundo_apellido'])) {
            $error = validarNombre($data['segundo_apellido'], 'segundo apellido', false);
            if ($error) $errores[] = $error;
        }
        
        $error = validarCedula($data['cedula'] ?? '', true);
        if ($error) $errores[] = $error;
        
        $error = validarTelefono($data['telefono'] ?? '', true);
        if ($error) $errores[] = $error;
        
        $error = validarEmail($data['email'] ?? '', true);
        if ($error) $errores[] = $error;
        
        $error = validarDireccion($data['direccion'] ?? '', true);
        if ($error) $errores[] = $error;
        
        if (empty($data['fecha_nacimiento'])) {
            $errores[] = "La fecha de nacimiento es obligatoria";
        }
        if (empty($data['genero'])) {
            $errores[] = "El género es obligatorio";
        }
        if (empty($data['id_rol'])) {
            $errores[] = "El rol es obligatorio";
        }
        if (empty($data['fecha_ingreso'])) {
            $errores[] = "La fecha de ingreso es obligatoria";
        }
        
        // ===== NUEVA VALIDACIÓN DE FECHAS =====
        $error_fechas = validarFechas($data['fecha_ingreso'] ?? '', $data['fecha_egreso'] ?? null);
        if ($error_fechas) {
            $errores[] = $error_fechas;
        }
        
        if (!empty($errores)) {
            echo json_encode(['success' => false, 'errores' => $errores]);
            exit();
        }
        
        // Normalizar datos
        $data['primer_nombre'] = normalizarTexto($data['primer_nombre']);
        $data['segundo_nombre'] = !empty($data['segundo_nombre']) ? normalizarTexto($data['segundo_nombre']) : null;
        $data['primer_apellido'] = normalizarTexto($data['primer_apellido']);
        $data['segundo_apellido'] = !empty($data['segundo_apellido']) ? normalizarTexto($data['segundo_apellido']) : null;
        $data['cedula'] = limpiarCedula($data['cedula']);
        
        $check = $pdo->prepare("SELECT id FROM usuarios WHERE cedula = ? OR email = ? OR telefono = ?");
        $check->execute([$data['cedula'], $data['email'], $data['telefono']]);
        if ($check->fetch()) {
            echo json_encode(['success' => false, 'errores' => ['Ya existe un usuario con esa cédula, email o teléfono']]);
            exit();
        }
        
        $password_default = $data['cedula'] . '123456789';
        $password_hash = password_hash($password_default, PASSWORD_BCRYPT);
        $fecha_actual = date('Y-m-d H:i:s');
        
        $sql = "INSERT INTO usuarios 
                (primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cedula, 
                 fecha_nacimiento, genero, telefono, email, direccion, id_rol, fecha_ingreso, fecha_egreso,
                 password_hash, estado,
                 telefono_modificacion, email_modificacion, direccion_modificacion, 
                 contrasena_modificacion, rol_modificacion, fecha_registro, ultima_modificacion) 
                VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Activo', ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $data['primer_nombre'],
            $data['segundo_nombre'],
            $data['primer_apellido'],
            $data['segundo_apellido'],
            $data['cedula'],
            $data['fecha_nacimiento'],
            $data['genero'],
            $data['telefono'],
            $data['email'],
            $data['direccion'],
            $data['id_rol'],
            $data['fecha_ingreso'],
            $data['fecha_egreso'] ?? null,
            $password_hash,
            $fecha_actual,
            $fecha_actual,
            $fecha_actual,
            $fecha_actual,
            $fecha_actual,
            $fecha_actual,
            $fecha_actual
        ]);
        
        $nuevo_id = $pdo->lastInsertId();
        $nombre_completo = $data['primer_nombre'] . ' ' . $data['primer_apellido'];
        
        registrarLog($pdo, 'crear_usuario', 'usuarios', $nuevo_id, $nombre_completo, 
                     "Creó nuevo usuario: $nombre_completo (Cédula: {$data['cedula']})");
        
        echo json_encode(['success' => true, 'id' => $nuevo_id, 'mensaje' => 'Usuario creado correctamente']);
        break;
    
case 'editar':
    error_log("=== EDITAR USUARIO ===");
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;
    
    if (!$id) {
        echo json_encode(['success' => false, 'errores' => ['ID no válido']]);
        exit();
    }
    
    $errores = [];
    
    $error = validarNombre($data['primer_nombre'] ?? '', 'primer nombre', true);
    if ($error) $errores[] = $error;
    
    if (!empty($data['segundo_nombre'])) {
        $error = validarNombre($data['segundo_nombre'], 'segundo nombre', false);
        if ($error) $errores[] = $error;
    }
    
    $error = validarNombre($data['primer_apellido'] ?? '', 'primer apellido', true);
    if ($error) $errores[] = $error;
    
    if (!empty($data['segundo_apellido'])) {
        $error = validarNombre($data['segundo_apellido'], 'segundo apellido', false);
        if ($error) $errores[] = $error;
    }
    
    $error = validarCedula($data['cedula'] ?? '', true);
    if ($error) $errores[] = $error;
    
    $error = validarTelefono($data['telefono'] ?? '', true);
    if ($error) $errores[] = $error;
    
    $error = validarEmail($data['email'] ?? '', true);
    if ($error) $errores[] = $error;
    
    $error = validarDireccion($data['direccion'] ?? '', true);
    if ($error) $errores[] = $error;
    
    if (empty($data['fecha_nacimiento'])) {
        $errores[] = "La fecha de nacimiento es obligatoria";
    }
    if (empty($data['genero'])) {
        $errores[] = "El género es obligatorio";
    }
    if (empty($data['id_rol'])) {
        $errores[] = "El rol es obligatorio";
    }
    if (empty($data['fecha_ingreso'])) {
        $errores[] = "La fecha de ingreso es obligatoria";
    }
    
    $error_fechas = validarFechas($data['fecha_ingreso'] ?? '', $data['fecha_egreso'] ?? null);
    if ($error_fechas) {
        $errores[] = $error_fechas;
    }
    
    if (!empty($errores)) {
        echo json_encode(['success' => false, 'errores' => $errores]);
        exit();
    }
    
    $data['primer_nombre'] = normalizarTexto($data['primer_nombre']);
    $data['segundo_nombre'] = !empty($data['segundo_nombre']) ? normalizarTexto($data['segundo_nombre']) : null;
    $data['primer_apellido'] = normalizarTexto($data['primer_apellido']);
    $data['segundo_apellido'] = !empty($data['segundo_apellido']) ? normalizarTexto($data['segundo_apellido']) : null;
    $data['cedula'] = limpiarCedula($data['cedula']);
    
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $anterior = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$anterior) {
        echo json_encode(['success' => false, 'errores' => ['Usuario no encontrado']]);
        exit();
    }
    
    $check = $pdo->prepare("SELECT id FROM usuarios WHERE (cedula = ? OR email = ? OR telefono = ?) AND id != ?");
    $check->execute([$data['cedula'], $data['email'], $data['telefono'], $id]);
    if ($check->fetch()) {
        echo json_encode(['success' => false, 'errores' => ['Ya existe otro usuario con esa cédula, email o teléfono']]);
        exit();
    }
    
    // ===== SI EL ESTADO ES ACTIVO O SUSPENDIDO, LIMPIAR FECHA DE EGRESO =====
    if ($data['estado'] !== 'Inactivo') {
        $data['fecha_egreso'] = null;
    }
    
    // ===== ACTUALIZAR INCLUYENDO FECHA DE EGRESO =====
    $sql = "UPDATE usuarios SET 
            primer_nombre = ?, segundo_nombre = ?, primer_apellido = ?, segundo_apellido = ?,
            cedula = ?, fecha_nacimiento = ?, genero = ?, telefono = ?, email = ?, direccion = ?,
            id_rol = ?, fecha_ingreso = ?, fecha_egreso = ?,
            ultima_modificacion = NOW()
            WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $data['primer_nombre'],
        $data['segundo_nombre'],
        $data['primer_apellido'],
        $data['segundo_apellido'],
        $data['cedula'],
        $data['fecha_nacimiento'],
        $data['genero'],
        $data['telefono'],
        $data['email'],
        $data['direccion'],
        $data['id_rol'],
        $data['fecha_ingreso'],
        $data['fecha_egreso'],
        $id
    ]);
    
    $cambios = [];
    $campos_comparar = [
        'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido', 
        'cedula', 'telefono', 'email', 'direccion', 'id_rol', 'fecha_ingreso', 'fecha_egreso', 'estado'
    ];
    
    foreach ($campos_comparar as $campo) {
        if (($anterior[$campo] ?? '') != ($data[$campo] ?? '')) {
            if ($campo === 'id_rol') {
                $r_anterior = $pdo->prepare("SELECT nombre_rol FROM roles WHERE id = ?");
                $r_anterior->execute([$anterior[$campo]]);
                $nom_ant = $r_anterior->fetchColumn();
                
                $r_nuevo = $pdo->prepare("SELECT nombre_rol FROM roles WHERE id = ?");
                $r_nuevo->execute([$data[$campo]]);
                $nom_nue = $r_nuevo->fetchColumn();
                
                $cambios[] = "Rol: $nom_ant → $nom_nue";
            } elseif ($campo === 'fecha_egreso') {
                $valor_anterior = $anterior[$campo] ?: '(vacío)';
                $valor_nuevo = $data[$campo] ?: '(vacío)';
                $cambios[] = "Fecha egreso: '$valor_anterior' → '$valor_nuevo'";
            } elseif ($campo === 'estado') {
                $cambios[] = "Estado: '{$anterior[$campo]}' → '{$data[$campo]}'";
            } else {
                $valor_anterior = $anterior[$campo] ?? '(vacío)';
                $valor_nuevo = $data[$campo] ?? '(vacío)';
                $cambios[] = "$campo: '$valor_anterior' → '$valor_nuevo'";
            }
        }
    }
    
    if (!empty($cambios)) {
        $nombre_completo = $data['primer_nombre'] . ' ' . $data['primer_apellido'];
        $detalle = "Editó usuario: " . implode(' | ', $cambios);
        registrarLog($pdo, 'editar_usuario', 'usuarios', $id, $nombre_completo, $detalle);
    }
    
    echo json_encode(['success' => true, 'mensaje' => 'Usuario actualizado correctamente']);
    break;
    
    case 'cambiar_password':
        $id = $_POST['id'] ?? 0;
        $nueva_password = $_POST['password'] ?? '';
        
        if (!$id) {
            echo json_encode(['success' => false, 'errores' => ['ID no válido']]);
            exit();
        }
        
        $error = validarPassword($nueva_password, null, true);
        if ($error) {
            echo json_encode(['success' => false, 'errores' => [$error]]);
            exit();
        }
        
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$usuario) {
            echo json_encode(['success' => false, 'errores' => ['Usuario no encontrado']]);
            exit();
        }
        
        $password_hash = password_hash($nueva_password, PASSWORD_BCRYPT);
        
        $sql = "UPDATE usuarios SET 
                password_hash = ?,
                contrasena_modificacion = NOW()
                WHERE id = ?";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$password_hash, $id]);
        
        $nombre_completo = $usuario['primer_nombre'] . ' ' . $usuario['primer_apellido'];
        registrarLog($pdo, 'cambiar_password', 'usuarios', $id, $nombre_completo, 
                     "Cambió contraseña del usuario");
        
        echo json_encode(['success' => true, 'mensaje' => 'Contraseña actualizada correctamente']);
        break;
    
    case 'inactivar':
        $id = $_POST['id'] ?? 0;
        
        if (!$id) {
            echo json_encode(['success' => false, 'errores' => ['ID no válido']]);
            exit();
        }
        
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$usuario) {
            echo json_encode(['success' => false, 'errores' => ['Usuario no encontrado']]);
            exit();
        }
        
        if ($usuario['estado'] === 'Inactivo') {
            echo json_encode(['success' => false, 'errores' => ['El usuario ya está inactivo']]);
            exit();
        }
        
        // ===== CORREGIDO: FORZAR LA FECHA ACTUAL =====
        $fecha_hoy = date('Y-m-d'); // Esto SIEMPRE será la fecha de Caracas
        
        $sql = "UPDATE usuarios SET 
                estado = 'Inactivo',
                fecha_egreso = :fecha_egreso,
                ultima_modificacion = NOW()
                WHERE id = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':fecha_egreso' => $fecha_hoy,  // Usamos la variable de PHP, NO la del usuario
            ':id' => $id
        ]);
        
        $nombre_completo = $usuario['primer_nombre'] . ' ' . $usuario['primer_apellido'];
        $detalle = "Inactivó al usuario (estado anterior: {$usuario['estado']}) - Fecha egreso: $fecha_hoy";
        registrarLog($pdo, 'inactivar_usuario', 'usuarios', $id, $nombre_completo, $detalle);
        
        echo json_encode(['success' => true, 'mensaje' => 'Usuario inactivado correctamente']);
        break;
    
    case 'cambiar_estado':
        $id = $_POST['id'] ?? 0;
        $estado = $_POST['estado'] ?? '';
        
        if (!$id || !in_array($estado, ['Activo', 'Suspendido'])) {
            echo json_encode(['success' => false, 'errores' => ['Datos no válidos']]);
            exit();
        }
        
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$usuario) {
            echo json_encode(['success' => false, 'errores' => ['Usuario no encontrado']]);
            exit();
        }
        
        $estado_anterior = $usuario['estado'];
        if ($estado_anterior === $estado) {
            echo json_encode(['success' => false, 'errores' => ['El usuario ya tiene ese estado']]);
            exit();
        }
        
        // ===== SI SE PONE INACTIVO, ACTUALIZAR FECHA EGRESO =====
        if ($estado === 'Inactivo') {
            $fecha_egreso = $usuario['fecha_egreso'] ?? date('Y-m-d');
            $sql = "UPDATE usuarios SET 
                    estado = :estado,
                    fecha_egreso = :fecha_egreso
                    WHERE id = :id";
            $params = [
                ':estado' => $estado,
                ':fecha_egreso' => $fecha_egreso,
                ':id' => $id
            ];
        } else {
            // Si se reactiva, limpiar fecha de egreso
            $sql = "UPDATE usuarios SET 
                    estado = :estado,
                    fecha_egreso = NULL
                    WHERE id = :id";
            $params = [
                ':estado' => $estado,
                ':id' => $id
            ];
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        $nombre_completo = $usuario['primer_nombre'] . ' ' . $usuario['primer_apellido'];
        $detalle = "Cambió estado de '$estado_anterior' a '$estado'";
        
        if ($estado === 'Inactivo') {
            $detalle .= " - Fecha egreso: $fecha_egreso";
        }
        
        registrarLog($pdo, 'cambiar_estado', 'usuarios', $id, $nombre_completo, $detalle);
        
        echo json_encode(['success' => true, 'mensaje' => 'Estado actualizado correctamente']);
        break;
    
    case 'activar':
    $id = $_POST['id'] ?? 0;
    
    if (!$id) {
        echo json_encode(['success' => false, 'errores' => ['ID no válido']]);
        exit();
    }
    
    // Obtener datos del usuario
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        echo json_encode(['success' => false, 'errores' => ['Usuario no encontrado']]);
        exit();
    }
    
    if ($usuario['estado'] !== 'Inactivo') {
        echo json_encode(['success' => false, 'errores' => ['El usuario no está inactivo']]);
        exit();
    }
    
    // Actualizar solo el estado y limpiar fecha de egreso
    $sql = "UPDATE usuarios SET 
            estado = 'Activo',
            fecha_egreso = NULL,
            ultima_modificacion = NOW()
            WHERE id = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    
    $nombre_completo = $usuario['primer_nombre'] . ' ' . $usuario['primer_apellido'];
    registrarLog($pdo, 'activar_usuario', 'usuarios', $id, $nombre_completo, "Activó al usuario");
    
    echo json_encode(['success' => true, 'mensaje' => 'Usuario activado correctamente']);
    break;

    default:
        http_response_code(400);
        echo json_encode(['error' => 'Acción no válida']);
}
?>