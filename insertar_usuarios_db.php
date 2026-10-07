<?php
/**
 * SCRIPT DE REGISTRO ADMINISTRATIVO - INTRANET BPEZ
 * Versión adaptada a la nueva estructura: Cédula numérica (max 10), campos obligatorios,
 * fecha de ingreso, fecha de egreso y campos de modificación individual.
 * INCLUYE PREGUNTAS DE SEGURIDAD CON HASH
 */

// 1. INCLUIR LA CONEXIÓN PDO
require_once 'config/conexiondb.php'; 

// 2. DATOS DEL USUARIO A INSERTAR
$datos = [
    'primer_nombre'    => 'Jose',           // Obligatorio
    'segundo_nombre'   => 'Gregorio',       // Opcional (puede ser NULL)
    'primer_apellido'  => 'Fernandez',      // Obligatorio
    'segundo_apellido' => 'Hernandez',      // Opcional (puede ser NULL)
    'cedula'           => '4526739',        // Obligatorio: SOLO NÚMEROS (Ej: 4526739)
    'fecha_nacimiento' => '1980-01-01',     // Obligatorio: Formato Año-Mes-Día
    'genero'           => 'M',              // Obligatorio: 'M', 'F' o 'O'
    'telefono'         => '04246212898',    // Obligatorio: Se recomienda sin guiones
    'email'            => 'jose.fernandez@bpez.com', // Obligatorio y Único
    'direccion'        => 'Sector Tierra Negra, Calle 78, Maracaibo', // Obligatorio
    'password_plana'   => '123456789',      // La clave real (se encriptará abajo)
    'id_rol'           => 1,                // 1 para Administrador, 2 para Usuario...
    'estado'           => 'Activo',         // 'Activo', 'Inactivo' o 'Suspendido'
    'fecha_ingreso'    => '2022-02-01',     // Fecha de ingreso a la institución (obligatorio)
    'fecha_egreso'     => null,             // Fecha de egreso (opcional, null si sigue activo)
    
    // ===== PREGUNTAS DE SEGURIDAD (OBLIGATORIAS) =====
    'preguntas' => [
        ['id' => 2, 'respuesta' => 'Maracaibo'],  // ¿En qué ciudad naciste? (ID 2)
        ['id' => 4, 'respuesta' => 'Pizza'],      // ¿Cuál es tu comida favorita? (ID 4)
        ['id' => 12, 'respuesta' => 'futbol']     // ¿Cuál es el nombre de tu deporte favorito? (ID 12)
    ]
];

/**
 * 3. FUNCIÓN PARA NORMALIZAR RESPUESTAS (opcional pero recomendada)
 */
function normalizarRespuesta($texto) {
    if (empty($texto)) return '';
    
    // Convertir a minúsculas y eliminar tildes básicas
    $texto = mb_strtolower(trim($texto), 'UTF-8');
    $acentos = [
        'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
        'ü' => 'u', 'ñ' => 'n', 'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
    ];
    $texto = strtr($texto, $acentos);
    
    // Eliminar caracteres especiales y espacios múltiples
    $texto = preg_replace('/[^a-z0-9\s]/', '', $texto);
    $texto = preg_replace('/\s+/', ' ', $texto);
    
    return trim($texto);
}

/**
 * 4. LIMPIEZA Y NORMALIZACIÓN DE DATOS PERSONALES
 */
// Normalizar Nombres/Apellidos: "JOSE" -> "Jose"
$datos['primer_nombre']    = mb_convert_case(mb_strtolower(trim($datos['primer_nombre'])), MB_CASE_TITLE, "UTF-8");
$datos['segundo_nombre']   = !empty($datos['segundo_nombre']) ? mb_convert_case(mb_strtolower(trim($datos['segundo_nombre'])), MB_CASE_TITLE, "UTF-8") : null;
$datos['primer_apellido']  = mb_convert_case(mb_strtolower(trim($datos['primer_apellido'])), MB_CASE_TITLE, "UTF-8");
$datos['segundo_apellido'] = !empty($datos['segundo_apellido']) ? mb_convert_case(mb_strtolower(trim($datos['segundo_apellido'])), MB_CASE_TITLE, "UTF-8") : null;

// Limpiar Cédula: Quitar puntos, guiones o letras (Solo números)
$datos['cedula'] = preg_replace('/[^0-9]/', '', $datos['cedula']);

// Validar que fecha_ingreso no sea null (es obligatoria)
if (empty($datos['fecha_ingreso'])) {
    exit("❌ Error: La fecha de ingreso es obligatoria.");
}

try {
    // Iniciar transacción (TODAS las operaciones juntas)
    $pdo->beginTransaction();
    
    /**
     * 5. VALIDACIÓN DE DUPLICADOS (Cédula, Email y Teléfono son UNIQUE)
     */
    $check_sql = "SELECT cedula, email, telefono FROM usuarios 
                  WHERE cedula = :ced OR email = :mail OR telefono = :tel LIMIT 1";
    $check_stmt = $pdo->prepare($check_sql);
    $check_stmt->execute([
        ':ced'  => $datos['cedula'],
        ':mail' => $datos['email'],
        ':tel'  => $datos['telefono']
    ]);
    
    $duplicado = $check_stmt->fetch();

    if ($duplicado) {
        if ($duplicado['cedula'] == $datos['cedula']) exit("❌ Error: La Cédula " . $datos['cedula'] . " ya existe.");
        if ($duplicado['email'] == $datos['email']) exit("❌ Error: El Correo ya está registrado.");
        if ($duplicado['telefono'] == $datos['telefono']) exit("❌ Error: El Teléfono ya está registrado.");
    }

    /**
     * 6. SEGURIDAD: HASHEO DE CONTRASEÑA
     */
    $password_hash = password_hash($datos['password_plana'], PASSWORD_BCRYPT);

    /**
     * 7. PREPARACIÓN E INSERCIÓN DEL USUARIO
     */
    $sql = "INSERT INTO usuarios (
                primer_nombre, segundo_nombre, primer_apellido, segundo_apellido,
                cedula, fecha_nacimiento, genero, telefono, email, direccion,
                password_hash, id_rol, estado, fecha_ingreso, fecha_egreso,
                telefono_modificacion, email_modificacion, direccion_modificacion,
                contrasena_modificacion, rol_modificacion, fecha_registro, ultima_modificacion,
                ultimo_login, token_recuperacion, token_expiracion
            ) VALUES (
                :p_nom, :s_nom, :p_ape, :s_ape,
                :ced, :f_nac, :gen, :tel, :mail, :dir,
                :pass, :rol, :est, :f_ingreso, :f_egreso,
                NOW(), NOW(), NOW(), NOW(), NOW(),
                NOW(), NOW(), NULL, NULL, NULL
            )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':p_nom'     => $datos['primer_nombre'],
        ':s_nom'     => $datos['segundo_nombre'],
        ':p_ape'     => $datos['primer_apellido'],
        ':s_ape'     => $datos['segundo_apellido'],
        ':ced'       => $datos['cedula'],
        ':f_nac'     => $datos['fecha_nacimiento'],
        ':gen'       => $datos['genero'],
        ':tel'       => $datos['telefono'],
        ':mail'      => $datos['email'],
        ':dir'       => $datos['direccion'],
        ':pass'      => $password_hash,
        ':rol'       => $datos['id_rol'],
        ':est'       => $datos['estado'],
        ':f_ingreso' => $datos['fecha_ingreso'],
        ':f_egreso'  => $datos['fecha_egreso']
    ]);

    // Obtener el ID del usuario recién insertado
    $usuario_id = $pdo->lastInsertId();
    
    /**
     * 8. INSERTAR PREGUNTAS DE SEGURIDAD (HASHEADAS)
     */
    $nombre_completo = $datos['primer_nombre'] . ' ' . $datos['primer_apellido'];
    
    // Preparar consulta para insertar respuestas
    $sql_respuesta = "INSERT INTO respuestas_seguridad (
                        usuario_id, pregunta_id, respuesta_hash,
                        creado_por_id, creado_por_nombre, creado_por_cedula, creado_por_rol,
                        fecha_creacion
                      ) VALUES (
                        :usuario_id, :pregunta_id, :respuesta_hash,
                        :creado_por_id, :creado_por_nombre, :creado_por_cedula, :creado_por_rol,
                        NOW()
                      )";
    
    $stmt_respuesta = $pdo->prepare($sql_respuesta);
    
    // Insertar cada pregunta
    foreach ($datos['preguntas'] as $pregunta) {
        $respuesta_normalizada = normalizarRespuesta($pregunta['respuesta']);
        $respuesta_hash = password_hash($respuesta_normalizada, PASSWORD_BCRYPT);
        
        $stmt_respuesta->execute([
            ':usuario_id'          => $usuario_id,
            ':pregunta_id'         => $pregunta['id'],
            ':respuesta_hash'      => $respuesta_hash,
            ':creado_por_id'       => $usuario_id, // El mismo usuario se crea a sí mismo
            ':creado_por_nombre'   => $nombre_completo,
            ':creado_por_cedula'   => $datos['cedula'],
            ':creado_por_rol'      => ($datos['id_rol'] == 1) ? 'Administrador' : 'Usuario'
        ]);
        
        /**
         * 9. REGISTRAR EN HISTORIAL DE CAMBIOS (por cada pregunta)
         */
        // Obtener texto de la pregunta
        $stmt_preg = $pdo->prepare("SELECT pregunta FROM preguntas_seguridad WHERE id = ?");
        $stmt_preg->execute([$pregunta['id']]);
        $pregunta_texto = $stmt_preg->fetchColumn();
        
        $sql_historial = "INSERT INTO historial_cambios_preguntas (
                            usuario_afectado_id, usuario_afectado_nombre, usuario_afectado_cedula,
                            accion, pregunta_id, pregunta_texto,
                            realizado_por_id, realizado_por_nombre, realizado_por_cedula, realizado_por_rol,
                            detalle, fecha_cambio
                          ) VALUES (
                            :afectado_id, :afectado_nombre, :afectado_cedula,
                            :accion, :pregunta_id, :pregunta_texto,
                            :realizado_id, :realizado_nombre, :realizado_cedula, :realizado_rol,
                            :detalle, NOW()
                          )";
        
        $stmt_historial = $pdo->prepare($sql_historial);
        $stmt_historial->execute([
            ':afectado_id'       => $usuario_id,
            ':afectado_nombre'   => $nombre_completo,
            ':afectado_cedula'   => $datos['cedula'],
            ':accion'            => 'creacion',
            ':pregunta_id'       => $pregunta['id'],
            ':pregunta_texto'    => $pregunta_texto,
            ':realizado_id'      => $usuario_id,
            ':realizado_nombre'  => $nombre_completo,
            ':realizado_cedula'  => $datos['cedula'],
            ':realizado_rol'     => ($datos['id_rol'] == 1) ? 'Administrador' : 'Usuario',
            ':detalle'           => 'Configuración inicial de preguntas de seguridad'
        ]);
    }
    
    /**
     * 10. REGISTRAR EN LOGS (Auditoría general)
     */
    $sql_log = "INSERT INTO logs (
                    usuario_id, usuario_nombre, usuario_cedula, usuario_rol,
                    accion, tabla, registro_id, registro_titulo, detalle, fecha
                ) VALUES (
                    :usuario_id, :usuario_nombre, :usuario_cedula, :usuario_rol,
                    :accion, :tabla, :registro_id, :registro_titulo, :detalle, NOW()
                )";
    
    $stmt_log = $pdo->prepare($sql_log);
    $stmt_log->execute([
        ':usuario_id'       => $usuario_id,
        ':usuario_nombre'   => $nombre_completo,
        ':usuario_cedula'   => $datos['cedula'],
        ':usuario_rol'      => ($datos['id_rol'] == 1) ? 'Administrador' : 'Usuario',
        ':accion'           => 'registro_usuario',
        ':tabla'            => 'usuarios',
        ':registro_id'      => $usuario_id,
        ':registro_titulo'  => $nombre_completo,
        ':detalle'          => 'Registro completo con preguntas de seguridad'
    ]);
    
    // Confirmar transacción
    $pdo->commit();

    // Mensaje de resultado
    $mensaje_egreso = $datos['fecha_egreso'] ? "Fecha de egreso: " . $datos['fecha_egreso'] : "Aún activo en la institución";
    
    echo "✅✅✅ REGISTRO EXITOSO ✅✅✅<br><br>";
    echo "👤 Usuario: <b>" . $datos['primer_nombre'] . " " . $datos['primer_apellido'] . "</b><br>";
    echo "🆔 Cédula: " . $datos['cedula'] . "<br>";
    echo "🎭 Rol: " . (($datos['id_rol'] == 1) ? 'Administrador' : 'Usuario') . "<br>";
    echo "📅 Fecha de ingreso: " . $datos['fecha_ingreso'] . "<br>";
    echo "📅 " . $mensaje_egreso . "<br>";
    echo "📌 ID de usuario: " . $usuario_id . "<br>";
    echo "<br>🔐 PREGUNTAS DE SEGURIDAD CONFIGURADAS:<br>";
    
    // Mostrar las preguntas configuradas (solo para verificación, no se muestran las respuestas)
    foreach ($datos['preguntas'] as $p) {
        $stmt_preg = $pdo->prepare("SELECT pregunta FROM preguntas_seguridad WHERE id = ?");
        $stmt_preg->execute([$p['id']]);
        $pregunta_texto = $stmt_preg->fetchColumn();
        echo "- " . $pregunta_texto . " (ID: " . $p['id'] . "): [RESPUESTA HASHEADADA]<br>";
    }
    
    echo "<br>📌 Todos los campos de modificación inicializados con la fecha actual.<br>";
    echo "📌 Quedó registrado en: respuestas_seguridad, historial_cambios_preguntas y logs.";

} catch (PDOException $e) {
    // Revertir transacción en caso de error
    $pdo->rollBack();
    
    // Captura errores de base de datos
    echo "❌ Error técnico en BD: " . $e->getMessage();
    
    // Información adicional para debugging
    echo "<br><br>📌 Si el error es de integridad, verifica que los IDs de preguntas (2,4,12) existan en la tabla preguntas_seguridad.";
}
?>