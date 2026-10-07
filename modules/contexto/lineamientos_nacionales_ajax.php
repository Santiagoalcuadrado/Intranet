<?php
/**
 * lineamientos_nacionales_ajax.php
 * API AJAX específica para Lineamientos Nacionales sobre el libro, la lectura y las bibliotecas
 * 
 * Campos en la tabla:
 * - titulo: Marco Legal / Estratégico
 * - descripcion: Impacto en la Administración Pública y Rol de las Bibliotecas
 * - gaceta: Vigencia / Gaceta
 * 
 * Auditoría: Todas las acciones quedan registradas en la tabla 'logs'.
 * Control de acceso: Usuarios regulares SOLO pueden ver/descargar documentos con estado 'aprobado'.
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
    
    $stmt = $pdo->prepare("SELECT primer_nombre, primer_apellido, cedula, id_rol FROM usuarios WHERE id = ?");
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch();
    
    if (!$usuario) return false;
    
    $usuario_nombre = escapeHtml($usuario['primer_nombre'] . ' ' . $usuario['primer_apellido']);
    $usuario_cedula = escapeHtml($usuario['cedula']);
    
    $stmt = $pdo->prepare("SELECT nombre_rol FROM roles WHERE id = ?");
    $stmt->execute([$usuario['id_rol']]);
    $usuario_rol = escapeHtml($stmt->fetchColumn());
    
    $sql = "INSERT INTO logs 
            (usuario_id, usuario_nombre, usuario_cedula, usuario_rol, accion, tabla, registro_id, registro_titulo, detalle, fecha) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([$usuario_id, $usuario_nombre, $usuario_cedula, $usuario_rol, $accion, $tabla, $registro_id, $registro_titulo, $detalle]);
}

// ===== CONFIGURACIÓN ESPECÍFICA =====
$tipo_documento = 'lineamiento_nacional';
$es_admin = ($_SESSION['rol'] === 'Administrador');

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

switch ($accion) {
    
    case 'listar':
        $pagina = $_GET['pagina'] ?? 1;
        $orden = $_GET['orden'] ?? 'fecha_desc';
        $limite = 10;
        $offset = ($pagina - 1) * $limite;
        
        $orderBy = "fecha_creacion DESC";
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
            default:
                $orderBy = "fecha_creacion DESC";
        }
        
        try {
            if ($es_admin) {
                $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM documentos WHERE tipo_documento = ? AND eliminado = 0");
                $stmt_count->execute([$tipo_documento]);
            } else {
                $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM documentos WHERE tipo_documento = ? AND estado = 'aprobado' AND eliminado = 0");
                $stmt_count->execute([$tipo_documento]);
            }
            $total = $stmt_count->fetchColumn();
            $total_paginas = ceil($total / $limite);
            
            if ($es_admin) {
                $stmt = $pdo->prepare("
                    SELECT id, titulo, descripcion, gaceta, estado, archivo_nombre, archivo_ruta 
                    FROM documentos 
                    WHERE tipo_documento = ? AND eliminado = 0
                    ORDER BY $orderBy
                    LIMIT ? OFFSET ?
                ");
            } else {
                $stmt = $pdo->prepare("
                    SELECT id, titulo, descripcion, gaceta, estado, archivo_nombre, archivo_ruta 
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
        $descripcion = trim($_POST['descripcion'] ?? '');
        $gaceta = trim($_POST['gaceta'] ?? '');
        
        if (empty($titulo) || empty($descripcion) || empty($gaceta)) {
            echo json_encode(['success' => false, 'errores' => ['Todos los campos son obligatorios']]);
            exit();
        }
        
        if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'errores' => ['Error al subir el archivo']]);
            exit();
        }
        
        $archivo = $_FILES['archivo'];
        $max_size = 120 * 1024 * 1024;
        if ($archivo['size'] > $max_size) {
            echo json_encode(['success' => false, 'errores' => ['El archivo excede el límite de 120MB']]);
            exit();
        }
        
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $archivo['tmp_name']);
        finfo_close($finfo);
        
        $allowed_mimes = ['application/pdf', 'application/x-pdf'];
        if (!in_array($mime_type, $allowed_mimes)) {
            echo json_encode(['success' => false, 'errores' => ['El archivo no es un PDF válido']]);
            exit();
        }
        
        function sanitizarNombre($nombre) {
            $nombre_sin_extension = preg_replace('/\.pdf$/i', '', $nombre);
            $nombre_sin_extension = mb_strtolower($nombre_sin_extension, 'UTF-8');
            $acentos = ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n', 'ç' => 'c'];
            $nombre_sin_extension = strtr($nombre_sin_extension, $acentos);
            $nombre_sin_extension = preg_replace('/[^a-z0-9_-]/', '_', $nombre_sin_extension);
            $nombre_sin_extension = preg_replace('/_+/', '_', $nombre_sin_extension);
            $nombre_sin_extension = trim($nombre_sin_extension, '_');
            if (strlen($nombre_sin_extension) > 100) {
                $nombre_sin_extension = substr($nombre_sin_extension, 0, 100);
            }
            if (empty($nombre_sin_extension)) {
                $nombre_sin_extension = 'documento';
            }
            return $nombre_sin_extension . '.pdf';
        }
        
        $nombre_original = $archivo['name'];
        $nombre_sanitizado = sanitizarNombre($nombre_original);
        $carpeta_modulo = 'lineamientos_nacionales';
        
        $fecha_actual = new DateTime();
        $anio = $fecha_actual->format('Y');
        $mes = $fecha_actual->format('m');
        $dia = $fecha_actual->format('d');
        
        $timestamp = $fecha_actual->format('Ymd_His');
        $usuario_id = $_SESSION['user_id'];
        $nombre_unico = $timestamp . '_U' . $usuario_id . '_' . $nombre_sanitizado;
        
        $ruta_base = $_SERVER['DOCUMENT_ROOT'] . '/uploads/documentos/';
        $ruta_completa_carpeta = $ruta_base . $carpeta_modulo . '/' . $anio . '/' . $mes . '/' . $dia . '/';
        
        if (!is_dir($ruta_completa_carpeta)) {
            mkdir($ruta_completa_carpeta, 0755, true);
        }
        
        $ruta_destino = '/uploads/documentos/' . $carpeta_modulo . '/' . $anio . '/' . $mes . '/' . $dia . '/' . $nombre_unico;
        $ruta_completa_archivo = $_SERVER['DOCUMENT_ROOT'] . $ruta_destino;
        
        if (move_uploaded_file($archivo['tmp_name'], $ruta_completa_archivo)) {
            try {
                $stmt = $pdo->prepare("SELECT primer_nombre, primer_apellido, cedula FROM usuarios WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $usuario = $stmt->fetch();
                
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
                registrarLog($pdo, 'subir_documento', 'documentos', $nuevo_id, $titulo, 
                            "Subió nuevo lineamiento nacional: $titulo (ruta: $carpeta_modulo/$anio/$mes/$dia/)");
                
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
        $descripcion = trim($data['descripcion'] ?? '');
        $gaceta = trim($data['gaceta'] ?? '');
        
        if (!$id || empty($titulo) || empty($descripcion) || empty($gaceta)) {
            echo json_encode(['success' => false, 'errores' => ['Datos incompletos']]);
            exit();
        }
        
        try {
            $stmt_old = $pdo->prepare("SELECT titulo FROM documentos WHERE id = ?");
            $stmt_old->execute([$id]);
            $old = $stmt_old->fetch();
            
            $stmt = $pdo->prepare("UPDATE documentos SET titulo = ?, descripcion = ?, gaceta = ? WHERE id = ?");
            $stmt->execute([$titulo, $descripcion, $gaceta, $id]);
            
            registrarLog($pdo, 'editar_documento', 'documentos', $id, $titulo, "Editó lineamiento nacional: {$old['titulo']}");
            
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
            $stmt_doc = $pdo->prepare("SELECT titulo FROM documentos WHERE id = ?");
            $stmt_doc->execute([$id]);
            $doc = $stmt_doc->fetch();
            
            $stmt = $pdo->prepare("UPDATE documentos SET estado = ? WHERE id = ?");
            $stmt->execute([$estado, $id]);
            
            $estado_texto = $estado === 'aprobado' ? 'Aprobado' : ($estado === 'rechazado' ? 'Rechazado' : 'Pendiente');
            registrarLog($pdo, 'cambiar_estado', 'documentos', $id, $doc['titulo'], "Cambió estado a: $estado_texto");
            
            echo json_encode(['success' => true, 'mensaje' => 'Estado actualizado correctamente']);
            
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'errores' => ['Error al cambiar estado']]);
        }
        break;
    
    // ===== SOFT DELETE usando estado 'rechazado' =====
    case 'eliminar':
        if (!$es_admin) {
            echo json_encode(['success' => false, 'errores' => ['No tienes permisos para esta acción']]);
            exit();
        }
        
        $id = $_POST['id'] ?? 0;
        $motivo = $_POST['motivo'] ?? '';
        $motivo_trim = trim($motivo);
        
        if (!$id || empty($motivo_trim)) {
            echo json_encode(['success' => false, 'errores' => ['Datos incompletos']]);
            exit();
        }
        
        function contarLetrasPhp($texto) {
            $soloLetras = preg_replace('/\s+/', '', $texto);
            return strlen($soloLetras);
        }
        
        $letrasValidas = contarLetrasPhp($motivo);
        if ($letrasValidas < 9) {
            echo json_encode(['success' => false, 'errores' => ['El motivo debe tener al menos 9 letras (sin contar espacios)']]);
            exit();
        }
        
        try {
            $stmt_doc = $pdo->prepare("SELECT titulo FROM documentos WHERE id = ?");
            $stmt_doc->execute([$id]);
            $doc = $stmt_doc->fetch();
            
            $usuario_id = $_SESSION['user_id'];
            $usuario_nombre = $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido'];
            $usuario_cedula = $_SESSION['cedula'] ?? '';
            $usuario_rol = $_SESSION['rol'] ?? '';
            
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
            
            registrarLog($pdo, 'eliminar_documento', 'documentos', $id, $doc['titulo'], 
                        "Marcó documento como No Disponible. Motivo: $motivo. Eliminado por: $usuario_nombre (Cédula: $usuario_cedula, Rol: $usuario_rol)");
            
            echo json_encode(['success' => true, 'mensaje' => 'Documento marcado como No Disponible correctamente']);
            
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'errores' => ['Error al marcar documento como No Disponible']]);
        }
        break;
    
    // ===== RECUPERAR DOCUMENTO =====
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
            $stmt_doc = $pdo->prepare("SELECT titulo FROM documentos WHERE id = ? AND estado = 'rechazado'");
            $stmt_doc->execute([$id]);
            $doc = $stmt_doc->fetch();
            
            if (!$doc) {
                echo json_encode(['success' => false, 'errores' => ['Documento no encontrado o no está en estado No Disponible']]);
                exit();
            }
            
            $usuario_id = $_SESSION['user_id'];
            $usuario_nombre = $_SESSION['primer_nombre'] . ' ' . $_SESSION['primer_apellido'];
            $usuario_cedula = $_SESSION['cedula'] ?? '';
            $usuario_rol = $_SESSION['rol'] ?? '';
            
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
            
            registrarLog($pdo, 'recuperar_documento', 'documentos', $id, $doc['titulo'], 
                        "Recuperó documento que estaba en estado No Disponible. Recuperado por: $usuario_nombre (Cédula: $usuario_cedula, Rol: $usuario_rol)");
            
            echo json_encode(['success' => true, 'mensaje' => 'Documento recuperado correctamente. Ahora está en estado "En Revisión".']);
            
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'errores' => ['Error al recuperar documento']]);
        }
        break;
    
    // ===== OBTENER MOTIVO DE ELIMINACIÓN CON DATOS COMPLETOS =====
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
            
            registrarLog($pdo, 'ver_documento', 'documentos', $id, $documento['titulo'], "Visualizó lineamiento nacional");
            
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
            
            registrarLog($pdo, 'descargar_documento', 'documentos', $id, $documento['titulo'], "Descargó lineamiento nacional");
            
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