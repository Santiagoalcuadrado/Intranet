<?php
/**
 * contexto_venezolano_ajax.php
 * API AJAX específica para Contexto Venezolano
 * 
 * NOTA: Los IDs en los modales del frontend (titulo, gaceta, descripcion) 
 * son utilizados por JavaScript. En la base de datos estos campos se 
 * almacenan como 'titulo', 'gaceta' y 'descripcion' respectivamente.
 * 
 * Auditoría: Todas las acciones (ver, descargar, subir, editar, 
 * cambiar estado, eliminar) quedan registradas en la tabla 'logs'.
 * 
 * Control de acceso: Los usuarios regulares SOLO pueden ver/descargar
 * documentos con estado 'aprobado'. Los administradores pueden ver todo.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/conexiondb.php';

header('Content-Type: application/json');

// ===== FUNCIÓN PARA ESCAPAR XSS =====
function escapeHtml($texto) {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

// ===== FUNCIÓN PARA REGISTRAR EN LOGS =====
function registrarLog($pdo, $accion, $tabla, $registro_id, $registro_titulo, $detalle = null) {
    $usuario_id = $_SESSION['user_id'];
    
    // Obtener datos del usuario actual
    $stmt = $pdo->prepare("SELECT primer_nombre, primer_apellido, cedula, id_rol FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch();
    
    if (!$usuario) return false;
    
    // Escapar datos para logs
    $usuario_nombre = escapeHtml($usuario['primer_nombre'] . ' ' . $usuario['primer_apellido']);
    $usuario_cedula = escapeHtml($usuario['cedula']);
    
    // Obtener nombre del rol
    $stmt = $pdo->prepare("SELECT nombre_rol FROM roles WHERE id = ?");
    $stmt->execute([$usuario['id_rol']]);
    $usuario_rol = escapeHtml($stmt->fetchColumn());
    
    $sql = "INSERT INTO logs 
            (usuario_id, usuario_nombre, usuario_cedula, usuario_rol, accion, tabla, registro_id, registro_titulo, detalle, fecha) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$usuario_id, $usuario_nombre, $usuario_cedula, $usuario_rol, $accion, $tabla, $registro_id, $registro_titulo, $detalle]);
}

// ===== CONFIGURACIÓN ESPECÍFICA DE ESTE MÓDULO =====
$tipo_documento = 'ley';
$es_admin = ($_SESSION['rol'] === 'Administrador');

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

switch ($accion) {
    
    case 'listar':
        $pagina = $_GET['pagina'] ?? 1;
        $orden = $_GET['orden'] ?? 'fecha_desc'; // Nuevo parámetro de orden
        $limite = 10;
        $offset = ($pagina - 1) * $limite;
        
        // ===== NUEVO: Definir ordenamiento =====
        $orderBy = "fecha_creacion DESC"; // Por defecto
        switch ($orden) {
            case 'fecha_asc':
                $orderBy = "fecha_creacion ASC";
                break;
            case 'titulo_asc':
                $orderBy = "titulo ASC";
                break;
            case 'titulo_desc':
                $orderBy = "titulo DESC";
                break;
            case 'estado_asc':
                $orderBy = "FIELD(estado, 'aprobado', 'pendiente', 'rechazado'), fecha_creacion DESC";
                break;
            case 'estado_desc':
                $orderBy = "FIELD(estado, 'rechazado', 'pendiente', 'aprobado'), fecha_creacion DESC";
                break;
            default: // fecha_desc
                $orderBy = "fecha_creacion DESC";
        }
        
        try {
            // Contar total (para admin todos, para usuarios solo aprobados)
            if ($es_admin) {
                $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM documentos WHERE tipo_documento = ? AND eliminado = 0");
                $stmt_count->execute([$tipo_documento]);
            } else {
                $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM documentos WHERE tipo_documento = ? AND estado = 'aprobado' AND eliminado = 0");
                $stmt_count->execute([$tipo_documento]);
            }
            $total = $stmt_count->fetchColumn();
            $total_paginas = ceil($total / $limite);
            
            // Obtener documentos con el orden dinámico
            if ($es_admin) {
                $stmt = $pdo->prepare("
                    SELECT id, titulo, gaceta, descripcion, estado, archivo_nombre, archivo_ruta 
                    FROM documentos 
                    WHERE tipo_documento = ? AND eliminado = 0
                    ORDER BY $orderBy
                    LIMIT ? OFFSET ?
                ");
            } else {
                $stmt = $pdo->prepare("
                    SELECT id, titulo, gaceta, descripcion, estado, archivo_nombre, archivo_ruta 
                    FROM documentos 
                    WHERE tipo_documento = ? AND estado = 'aprobado' AND eliminado = 0
                    ORDER BY $orderBy
                    LIMIT ? OFFSET ?
                ");
            }
            $stmt->bindValue(1, $tipo_documento, PDO::PARAM_STR);
            $stmt->bindValue(2, $limite, PDO::PARAM_INT);
            $stmt->bindValue(3, $offset, PDO::PARAM_INT);
            $stmt->execute();
            $documentos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'documentos' => $documentos,
                'total_paginas' => $total_paginas,
                'pagina_actual' => (int)$pagina
            ]);
            
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'errores' => ['Error al cargar documentos']]);
        }
        break;
    
    case 'obtener':
        $id = $_GET['id'] ?? 0;
        
        try {
            // Para obtener un documento específico, los admin pueden todo,
            // los usuarios solo si está aprobado
            if ($es_admin) {
                $stmt = $pdo->prepare("SELECT * FROM documentos WHERE id = ? AND eliminado = 0");
            } else {
                $stmt = $pdo->prepare("SELECT * FROM documentos WHERE id = ? AND estado = 'aprobado' AND eliminado = 0");
            }
            $stmt->execute([$id]);
            $documento = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($documento) {
                echo json_encode(['success' => true, 'documento' => $documento]);
            } else {
                echo json_encode(['success' => false, 'errores' => ['Documento no encontrado o no disponible']]);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'errores' => ['Error al obtener documento']]);
        }
        break;
    
    case 'subir':
        if (!$es_admin) {
            echo json_encode(['success' => false, 'errores' => ['No tienes permisos para esta acción']]);
            exit();
        }
        
        $titulo = trim($_POST['titulo'] ?? '');
        $gaceta = trim($_POST['gaceta'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        
        // ===== VALIDAR CAMPOS OBLIGATORIOS =====
        if (empty($titulo)) {
            echo json_encode(['success' => false, 'errores' => ['El título es obligatorio']]);
            exit();
        }
        
        if (empty($gaceta)) {
            echo json_encode(['success' => false, 'errores' => ['La gaceta/actualización es obligatoria']]);
            exit();
        }
        
        if (empty($descripcion)) {
            echo json_encode(['success' => false, 'errores' => ['El resumen de impacto es obligatorio']]);
            exit();
        }
        
        if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'errores' => ['Error al subir el archivo']]);
            exit();
        }
        
        $archivo = $_FILES['archivo'];
        
        // ===== VALIDACIÓN: TAMAÑO MÁXIMO 120MB =====
        $max_size = 120 * 1024 * 1024; // 120MB en bytes
        if ($archivo['size'] > $max_size) {
            echo json_encode(['success' => false, 'errores' => ['El archivo excede el límite de 120MB']]);
            exit();
        }
        
        // ===== VALIDACIÓN: VERIFICAR TIPO MIME REAL =====
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $archivo['tmp_name']);
        finfo_close($finfo);
        
        $allowed_mimes = ['application/pdf', 'application/x-pdf'];
        if (!in_array($mime_type, $allowed_mimes)) {
            echo json_encode(['success' => false, 'errores' => ['El archivo no es un PDF válido']]);
            exit();
        }
        
        // ===== FUNCIÓN: SANITIZAR NOMBRE DE ARCHIVO =====
        function sanitizarNombre($nombre) {
            // 1. Eliminar extensión .pdf
            $nombre_sin_extension = preg_replace('/\.pdf$/i', '', $nombre);
            
            // 2. Convertir a minúsculas
            $nombre_sin_extension = mb_strtolower($nombre_sin_extension, 'UTF-8');
            
            // 3. Reemplazar acentos
            $acentos = [
                'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
                'ü' => 'u', 'ñ' => 'n', 'ç' => 'c',
                'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u',
            ];
            $nombre_sin_extension = strtr($nombre_sin_extension, $acentos);
            
            // 4. Eliminar caracteres no permitidos
            $nombre_sin_extension = preg_replace('/[^a-z0-9_-]/', '_', $nombre_sin_extension);
            
            // 5. Eliminar guiones bajos múltiples
            $nombre_sin_extension = preg_replace('/_+/', '_', $nombre_sin_extension);
            $nombre_sin_extension = trim($nombre_sin_extension, '_');
            
            // 6. Limitar longitud
            if (strlen($nombre_sin_extension) > 100) {
                $nombre_sin_extension = substr($nombre_sin_extension, 0, 100);
            }
            
            // 7. Si queda vacío, usar genérico
            if (empty($nombre_sin_extension)) {
                $nombre_sin_extension = 'documento';
            }
            
            return $nombre_sin_extension . '.pdf';
        }
        
        // ===== OBTENER NOMBRE ORIGINAL Y SANITIZARLO =====
        $nombre_original = $archivo['name'];
        $nombre_sanitizado = sanitizarNombre($nombre_original);
        
        // ===== CARPETA SEGÚN EL MÓDULO =====
        $carpeta_modulo = 'contexto_venezolano';
        
        // ===== CREAR ESTRUCTURA DE FECHA =====
        $fecha_actual = new DateTime();
        $anio = $fecha_actual->format('Y');
        $mes = $fecha_actual->format('m');
        $dia = $fecha_actual->format('d');
        
        // ===== GENERAR NOMBRE ÚNICO =====
        $timestamp = $fecha_actual->format('Ymd_His');
        $usuario_id = $_SESSION['user_id'];
        $nombre_unico = $timestamp . '_U' . $usuario_id . '_' . $nombre_sanitizado;
        
        // ===== CREAR ESTRUCTURA DE CARPETAS =====
        $ruta_base = $_SERVER['DOCUMENT_ROOT'] . '/uploads/documentos/';
        $ruta_completa_carpeta = $ruta_base . $carpeta_modulo . '/' . $anio . '/' . $mes . '/' . $dia . '/';
        
        if (!is_dir($ruta_completa_carpeta)) {
            mkdir($ruta_completa_carpeta, 0755, true);
        }
        
        // ===== RUTA DESTINO =====
        $ruta_destino = '/uploads/documentos/' . $carpeta_modulo . '/' . $anio . '/' . $mes . '/' . $dia . '/' . $nombre_unico;
        $ruta_completa_archivo = $_SERVER['DOCUMENT_ROOT'] . $ruta_destino;
        
        // ===== MOVER ARCHIVO =====
        if (move_uploaded_file($archivo['tmp_name'], $ruta_completa_archivo)) {
            try {
                // Obtener datos del usuario
                $stmt = $pdo->prepare("SELECT primer_nombre, primer_apellido, cedula FROM usuarios WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $usuario = $stmt->fetch();
                
                // Insertar en BD
                $sql = "INSERT INTO documentos 
                        (tipo_documento, titulo, descripcion, gaceta, estado,
                         archivo_nombre, archivo_ruta, archivo_tamano,
                         creado_por_id, creado_por_nombre, creado_por_cedula, creado_por_rol) 
                        VALUES 
                        (?, ?, ?, ?, 'pendiente', ?, ?, ?, ?, ?, ?, ?)";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $tipo_documento,
                    $titulo,
                    $descripcion,
                    $gaceta,
                    $nombre_original,
                    $ruta_destino,
                    $archivo['size'],
                    $_SESSION['user_id'],
                    $usuario['primer_nombre'] . ' ' . $usuario['primer_apellido'],
                    $usuario['cedula'],
                    $_SESSION['rol']
                ]);
                
                $nuevo_id = $pdo->lastInsertId();
                
                // Registrar en logs
                registrarLog($pdo, 'subir_documento', 'documentos', $nuevo_id, $titulo, 
                            "Subió nuevo documento: $titulo (ruta: $carpeta_modulo/$anio/$mes/$dia/)");
                
                echo json_encode(['success' => true, 'mensaje' => 'Documento subido correctamente. Pendiente de aprobación.']);
                
            } catch (PDOException $e) {
                unlink($ruta_completa_archivo);
                echo json_encode(['success' => false, 'errores' => ['Error al guardar en base de datos']]);
            }
        } else {
            echo json_encode(['success' => false, 'errores' => ['Error al guardar el archivo']]);
        }
        break;
    
    case 'editar':
        if (!$es_admin) {
            echo json_encode(['success' => false, 'errores' => ['No tienes permisos para esta acción']]);
            exit();
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? 0;
        $titulo = trim($data['titulo'] ?? '');
        $gaceta = trim($data['gaceta'] ?? '');
        $descripcion = trim($data['descripcion'] ?? '');
        
        if (!$id) {
            echo json_encode(['success' => false, 'errores' => ['ID no válido']]);
            exit();
        }
        
        // ===== VALIDAR CAMPOS OBLIGATORIOS =====
        if (empty($titulo)) {
            echo json_encode(['success' => false, 'errores' => ['El título es obligatorio']]);
            exit();
        }
        
        if (empty($gaceta)) {
            echo json_encode(['success' => false, 'errores' => ['La gaceta/actualización es obligatoria']]);
            exit();
        }
        
        if (empty($descripcion)) {
            echo json_encode(['success' => false, 'errores' => ['El resumen de impacto es obligatorio']]);
            exit();
        }
        
        try {
            // Obtener datos anteriores para el log
            $stmt_old = $pdo->prepare("SELECT titulo FROM documentos WHERE id = ?");
            $stmt_old->execute([$id]);
            $old = $stmt_old->fetch();
            
            $stmt = $pdo->prepare("UPDATE documentos SET titulo = ?, gaceta = ?, descripcion = ? WHERE id = ?");
            $stmt->execute([$titulo, $gaceta, $descripcion, $id]);
            
            // ===== REGISTRAR EN LOGS =====
            registrarLog($pdo, 'editar_documento', 'documentos', $id, $titulo, "Editó documento: {$old['titulo']}");
            
            echo json_encode(['success' => true, 'mensaje' => 'Documento actualizado correctamente']);
            
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'errores' => ['Error al editar documento']]);
        }
        break;
    
    case 'cambiar_estado':
        if (!$es_admin) {
            echo json_encode(['success' => false, 'errores' => ['No tienes permisos para esta acción']]);
            exit();
        }
        
        $id = $_POST['id'] ?? 0;
        $estado = $_POST['estado'] ?? '';
        
        if (!$id || !in_array($estado, ['pendiente', 'aprobado', 'rechazado'])) {
            echo json_encode(['success' => false, 'errores' => ['Datos no válidos']]);
            exit();
        }
        
        try {
            // Obtener datos del documento para el log
            $stmt_doc = $pdo->prepare("SELECT titulo FROM documentos WHERE id = ?");
            $stmt_doc->execute([$id]);
            $doc = $stmt_doc->fetch();
            
            $stmt = $pdo->prepare("UPDATE documentos SET estado = ? WHERE id = ?");
            $stmt->execute([$estado, $id]);
            
            // ===== REGISTRAR EN LOGS =====
            $estado_texto = $estado === 'aprobado' ? 'Aprobado' : ($estado === 'rechazado' ? 'Rechazado' : 'Pendiente');
            registrarLog($pdo, 'cambiar_estado', 'documentos', $id, $doc['titulo'], "Cambió estado a: $estado_texto");
            
            echo json_encode(['success' => true, 'mensaje' => 'Estado actualizado correctamente']);
            
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'errores' => ['Error al cambiar estado']]);
        }
        break;
    
    // ===== MODIFICADO: Eliminar (soft delete usando estado 'rechazado') CON AUDITORÍA COMPLETA =====
    case 'eliminar':
        if (!$es_admin) {
            echo json_encode(['success' => false, 'errores' => ['No tienes permisos para esta acción']]);
            exit();
        }
        
        $id = $_POST['id'] ?? 0;
        $motivo = $_POST['motivo'] ?? '';
        $motivo_trim = trim($motivo);
        
        // ===== VALIDACIÓN: ¿ESTÁ VACÍO? =====
        if (!$id || empty($motivo_trim)) {
            echo json_encode(['success' => false, 'errores' => ['Datos incompletos']]);
            exit();
        }
        
        // ===== FUNCIÓN PARA CONTAR SOLO LETRAS EN PHP =====
        function contarLetrasPhp($texto) {
            // Eliminar espacios, saltos de línea, tabulaciones
            $soloLetras = preg_replace('/\s+/', '', $texto);
            return strlen($soloLetras);
        }
        
        // ===== VALIDACIÓN: MÍNIMO 9 LETRAS (ignorando espacios) =====
        $letrasValidas = contarLetrasPhp($motivo);
        if ($letrasValidas < 9) {
            echo json_encode(['success' => false, 'errores' => ['El motivo debe tener al menos 9 letras (sin contar espacios)']]);
            exit();
        }
        
        try {
            // Obtener datos del documento para el log y auditoría
            $stmt_doc = $pdo->prepare("SELECT titulo FROM documentos WHERE id = ?");
            $stmt_doc->execute([$id]);
            $doc = $stmt_doc->fetch();
            
            // Obtener datos del usuario actual para auditoría
            $usuario_id = $_SESSION['user_id'];
            $usuario_nombre = $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido'];
            $usuario_cedula = $_SESSION['cedula'] ?? '';
            $usuario_rol = $_SESSION['rol'] ?? '';
            
            // ===== SOFT DELETE: Cambiar estado a 'rechazado' Y registrar quién lo eliminó =====
            $stmt = $pdo->prepare("
                UPDATE documentos 
                SET estado = 'rechazado', 
                    motivo_eliminacion = ?, 
                    fecha_eliminacion = NOW(),
                    eliminado_por_id = ?,
                    eliminado_por_nombre = ?,
                    eliminado_por_cedula = ?,
                    eliminado_por_rol = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $motivo,
                $usuario_id,
                $usuario_nombre,
                $usuario_cedula,
                $usuario_rol,
                $id
            ]);
            
            // ===== REGISTRAR EN LOGS =====
            registrarLog($pdo, 'eliminar_documento', 'documentos', $id, $doc['titulo'], 
                        "Marcó documento como No Disponible. Motivo: $motivo. Eliminado por: $usuario_nombre (Cédula: $usuario_cedula, Rol: $usuario_rol)");
            
            echo json_encode(['success' => true, 'mensaje' => 'Documento marcado como No Disponible correctamente']);
            
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'errores' => ['Error al marcar documento como No Disponible']]);
        }
        break;
    
    // ===== NUEVA ACCIÓN: RECUPERAR DOCUMENTO CON AUDITORÍA =====
    case 'recuperar':
        if (!$es_admin) {
            echo json_encode(['success' => false, 'errores' => ['No tienes permisos para esta acción']]);
            exit();
        }
        
        $id = $_POST['id'] ?? 0;
        
        if (!$id) {
            echo json_encode(['success' => false, 'errores' => ['ID no válido']]);
            exit();
        }
        
        try {
            // Verificar que el documento existe y está en estado rechazado
            $stmt_doc = $pdo->prepare("SELECT titulo FROM documentos WHERE id = ? AND estado = 'rechazado'");
            $stmt_doc->execute([$id]);
            $doc = $stmt_doc->fetch();
            
            if (!$doc) {
                echo json_encode(['success' => false, 'errores' => ['Documento no encontrado o no está en estado No Disponible']]);
                exit();
            }
            
            // Obtener datos del usuario actual para auditoría
            $usuario_id = $_SESSION['user_id'];
            $usuario_nombre = $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido'];
            $usuario_cedula = $_SESSION['cedula'] ?? '';
            $usuario_rol = $_SESSION['rol'] ?? '';
            
            // Restaurar a estado 'pendiente' Y registrar quién lo recuperó (opcional: podrías tener campo restaurado_por_*)
            $stmt = $pdo->prepare("
                UPDATE documentos 
                SET estado = 'pendiente',
                    modificado_por_id = ?,
                    modificado_por_nombre = ?,
                    modificado_por_cedula = ?,
                    modificado_por_rol = ?,
                    fecha_modificacion = NOW()
                WHERE id = ?
            ");
            $stmt->execute([
                $usuario_id,
                $usuario_nombre,
                $usuario_cedula,
                $usuario_rol,
                $id
            ]);
            
            // Registrar en logs
            registrarLog($pdo, 'recuperar_documento', 'documentos', $id, $doc['titulo'], 
                        "Recuperó documento que estaba en estado No Disponible. Recuperado por: $usuario_nombre (Cédula: $usuario_cedula, Rol: $usuario_rol)");
            
            echo json_encode(['success' => true, 'mensaje' => 'Documento recuperado correctamente. Ahora está en estado "En Revisión".']);
            
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'errores' => ['Error al recuperar documento']]);
        }
        break;

    // ===== NUEVA ACCIÓN: OBTENER MOTIVO DE ELIMINACIÓN CON DATOS COMPLETOS =====
    case 'obtener_motivo':
        if (!$es_admin) {
            echo json_encode(['success' => false, 'errores' => ['No tienes permisos para esta acción']]);
            exit();
        }
        
        $id = $_GET['id'] ?? 0;
        
        if (!$id) {
            echo json_encode(['success' => false, 'errores' => ['ID no válido']]);
            exit();
        }
        
        try {
            $stmt = $pdo->prepare("
                SELECT 
                    titulo, 
                    descripcion, 
                    gaceta, 
                    fecha_creacion,
                    motivo_eliminacion, 
                    fecha_eliminacion, 
                    eliminado_por_nombre, 
                    eliminado_por_cedula, 
                    eliminado_por_rol
                FROM documentos 
                WHERE id = ? AND estado = 'rechazado'
            ");
            $stmt->execute([$id]);
            $motivo = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($motivo) {
                echo json_encode([
                    'success' => true,
                    'motivo' => $motivo
                ]);
            } else {
                echo json_encode(['success' => false, 'errores' => ['Documento no encontrado o no está eliminado']]);
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'errores' => ['Error al obtener motivo']]);
        }
        break;

    case 'ver':
        $id = $_GET['id'] ?? 0;
        
        try {
            // Verificar acceso
            if ($es_admin) {
                $stmt = $pdo->prepare("SELECT * FROM documentos WHERE id = ? AND eliminado = 0");
            } else {
                $stmt = $pdo->prepare("SELECT * FROM documentos WHERE id = ? AND estado = 'aprobado' AND eliminado = 0");
            }
            $stmt->execute([$id]);
            $documento = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$documento) {
                http_response_code(403);
                echo "Acceso denegado o documento no disponible";
                exit();
            }
            
            $ruta_completa = $_SERVER['DOCUMENT_ROOT'] . $documento['archivo_ruta'];
            
            if (!file_exists($ruta_completa)) {
                http_response_code(404);
                echo "Archivo no encontrado";
                exit();
            }
            
            // ===== REGISTRAR EN LOGS =====
            registrarLog($pdo, 'ver_documento', 'documentos', $id, $documento['titulo'], "Visualizó documento");
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . $documento['archivo_nombre'] . '"');
            readfile($ruta_completa);
            exit();
            
        } catch (PDOException $e) {
            http_response_code(500);
            exit();
        }
        break;
    
    case 'descargar':
        $id = $_GET['id'] ?? 0;
        
        try {
            // Verificar acceso
            if ($es_admin) {
                $stmt = $pdo->prepare("SELECT * FROM documentos WHERE id = ? AND eliminado = 0");
            } else {
                $stmt = $pdo->prepare("SELECT * FROM documentos WHERE id = ? AND estado = 'aprobado' AND eliminado = 0");
            }
            $stmt->execute([$id]);
            $documento = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$documento) {
                http_response_code(403);
                echo "Acceso denegado o documento no disponible";
                exit();
            }
            
            $ruta_completa = $_SERVER['DOCUMENT_ROOT'] . $documento['archivo_ruta'];
            
            if (!file_exists($ruta_completa)) {
                http_response_code(404);
                echo "Archivo no encontrado";
                exit();
            }
            
            // ===== REGISTRAR EN LOGS =====
            registrarLog($pdo, 'descargar_documento', 'documentos', $id, $documento['titulo'], "Descargó documento");
            
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $documento['archivo_nombre'] . '"');
            readfile($ruta_completa);
            exit();
            
        } catch (PDOException $e) {
            http_response_code(500);
            exit();
        }
        break;
    
    default:
        http_response_code(400);
        echo json_encode(['error' => 'Acción no válida']);
}
?>