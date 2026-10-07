<?php
/**
 * ask_ia.php
 * BACKEND para el chatbot IA - Conexión directa a Gemini API (2026)
 * Ubicación: /modules/ia_backend/ask_ia.php
 */

// ===== 1. SEGURIDAD =====
require_once $_SERVER['DOCUMENT_ROOT'] . '/auth/session_check.php';

// ===== 2. HEADERS =====
header('Content-Type: application/json');

// ===== 3. CONFIGURACIÓN DE GEMINI (ACTUALIZADA 2026) =====
define('GEMINI_API_KEY', 'Jhon pon aca tu API KEY');

//  MODELOS VIGENTES EN 2026 - Elige uno:
// $MODELO = 'gemini-3.1-pro-preview';     // Lo último, razonamiento profundo [citation:5]
// $MODELO = 'gemini-3-flash-preview';      // Rápido y económico [citation:7]
$MODELO = 'gemini-2.5-flash';                // Estable hasta Jun 2026 [citation:1]

define('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/' . $MODELO . ':generateContent?key=' . GEMINI_API_KEY);

// ===== 4. RECIBIR PREGUNTA =====
$inputData = json_decode(file_get_contents("php://input"), true);
$userPrompt = trim($inputData['prompt'] ?? '');

if (empty($userPrompt)) {
    echo json_encode(['respuesta' => 'Por favor, escribe una pregunta.']);
    exit;
}

// ===== 5. LIMITAR LONGITUD =====
if (strlen($userPrompt) > 500) {
    echo json_encode(['respuesta' => 'La pregunta es demasiado larga (máx 500 caracteres)']);
    exit;
}

// ===== 6. SANITIZAR INPUT =====
$userPrompt = htmlspecialchars($userPrompt, ENT_QUOTES, 'UTF-8');

// ===== 7. PREPARAR PETICIÓN A GEMINI (VERSIÓN RESTRINGIDA A BPEZ) =====
$systemInstruction = "ERES UN ASISTENTE EXCLUSIVO DE LA BIBLIOTECA PÚBLICA DEL ESTADO ZULIA (BPEZ).\n\n";
$systemInstruction .= "⚠️ REGLA FUNDAMENTAL:\n";
$systemInstruction .= "SOLO puedes responder preguntas relacionadas con la Biblioteca Pública del Estado Zulia, su Intranet, servicios, horarios, historia, salas, personal y procedimientos internos.\n\n";

$systemInstruction .= "INSTRUCCIONES CRÍTICAS:\n";
$systemInstruction .= "1. Si la pregunta NO es sobre la biblioteca o su Intranet, responde EXACTAMENTE:\n";
$systemInstruction .= "   'Lo siento, solo puedo responder preguntas relacionadas con la Biblioteca Pública del Estado Zulia y su Intranet.'\n";
$systemInstruction .= "2. NUNCA respondas preguntas de cultura general, historia mundial, tareas escolares, ensayos, etc.\n";
$systemInstruction .= "3. NUNCA inventes información. Si no sabes algo sobre la biblioteca, di que no tienes esa información.\n\n";

$systemInstruction .= "INFORMACIÓN OFICIAL DE LA BIBLIOTECA:\n";
$systemInstruction .= "- HORARIO: La biblioteca atiende de LUNES A VIERNES de 8:00 AM a 4:00 PM. (NUNCA menciones 12 AM, medianoche, ni ningún otro horario)\n";
$systemInstruction .= "- La biblioteca NO abre sábados, domingos ni feriados\n";
$systemInstruction .= "- FUNDACIÓN: 15 de julio de 1873 por Venancio Pulgar\n";
$systemInstruction .= "- HISTORIA: Nació como Biblioteca Zuliana en 1873, renombrada María Calcaño en 1995, sede actual desde 2008\n";
$systemInstruction .= "- SERVICIOS: alfabetización tecnológica, préstamo interno de libros, salas digitales\n";
$systemInstruction .= "- SALAS: Acervo Histórico, Braille Miguel Ángel Jusayú, Digital Humberto Fernández Morán, Infantil Amenodoro Urdaneta, Hemeroteca Eduardo López Rivas, Fonoteca Ulises Acosta, Videoteca Manuel Trujillo Durán\n";
$systemInstruction .= "- WEB: https://www.bibliotecapublicadelzulia.org/\n";
$systemInstruction .= "- MENÚS INTRANET: Organización (Cargos, Procedimientos, Misión/Visión), Gestión Estratégica (Planificación, Proyectos, Reuniones), Control (Reportes, Informes), Seguridad (Leyes, Normas)\n";
$systemInstruction .= "- BIBLIOCAFÉ: espacio de lectura con café\n";
$systemInstruction .= "- SALA ROBÓTICA: ya no existe\n\n";

$systemInstruction .= "PREGUNTAS FRECUENTES Y RESPUESTAS EXACTAS:\n";
$systemInstruction .= "Q: ¿Cuál es el horario? A: La biblioteca atiende de lunes a viernes, de 8:00 AM a 4:00 PM.\n";
$systemInstruction .= "Q: ¿Hasta qué hora? A: Hasta las 4:00 PM.\n";
$systemInstruction .= "Q: ¿Dónde están los cargos? A: En el menú superior: La Organización > Cargos.\n";
$systemInstruction .= "Q: ¿Qué es la Bibliocafé? A: Es un espacio para leer disfrutando de un café.\n\n";

$systemInstruction .= "RECUERDA: ERES SOLO PARA TEMAS DE LA BPEZ. NADA MÁS.";

// Formato correcto para Gemini API 2026 [citation:9]
$requestBody = [
    'contents' => [
        [
            'role' => 'user',
            'parts' => [
                ['text' => $systemInstruction . "\n\nPregunta del usuario: " . $userPrompt]
            ]
        ]
    ],
    'generationConfig' => [
        'temperature' => 0.3,        // Más bajo = más preciso, menos creativo
        'maxOutputTokens' => 500,
        'topP' => 0.95,
        'topK' => 40
    ]
];

// ===== 8. ENVIAR PETICIÓN A GEMINI =====
$ch = curl_init(GEMINI_API_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Para entornos locales/hosting

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// ===== 9. PROCESAR RESPUESTA =====
if ($curlError) {
    // Error de conexión - usar respaldo local
    $respuesta = obtenerRespuestaLocal($userPrompt);
} elseif ($httpCode !== 200) {
    // Error de API - usar respaldo local
    $respuesta = obtenerRespuestaLocal($userPrompt);
} else {
    $data = json_decode($response, true);
    
    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
        $respuesta = $data['candidates'][0]['content']['parts'][0]['text'];
    } else {
        $respuesta = obtenerRespuestaLocal($userPrompt);
    }
}

// ===== 10. REGISTRO DE AUDITORÍA =====
$usuario = $_SESSION['email'] ?? $_SESSION['user_id'] ?? 'Desconocido';
error_log("[GEMINI] Usuario: $usuario - Consulta: " . substr($userPrompt, 0, 50));

// ===== 11. ENVIAR RESPUESTA =====
echo json_encode(['respuesta' => $respuesta]);
exit;

// ===== 12. FUNCIÓN DE RESPALDO LOCAL MEJORADA =====
function obtenerRespuestaLocal($consulta) {
    $consulta = strtolower(trim($consulta));
    
    // ===== BASE DE CONOCIMIENTO CON PALABRAS CLAVE MÚLTIPLES =====
    $conocimiento = [
        // HORARIOS - Múltiples variantes
        [
            'palabras' => ['horario', 'hora', 'atienden', 'abren', 'cierran', 'abierto', 'abre', 'cierra'],
            'respuesta' => 'La biblioteca atiende de lunes a viernes, de 8:00 AM a 4:00 PM.'
        ],
        [
            'palabras' => ['hasta que hora', 'hasta qué hora', 'hasta cuando', 'última hora'],
            'respuesta' => 'La biblioteca atiende hasta las 4:00 PM.'
        ],
        [
            'palabras' => ['sábado', 'domingo', 'finde', 'fin de semana', 'fines de semana'],
            'respuesta' => 'La biblioteca NO abre los sábados, domingos ni feriados. Solo atendemos de lunes a viernes.'
        ],
        
        // FUNDACIÓN
        [
            'palabras' => ['fundación', 'fundada', 'fundado', 'creada', 'inicios', '1873', 'venancio pulgar'],
            'respuesta' => 'Fue fundada el 15 de julio de 1873 por decreto del General Venancio Pulgar.'
        ],
        
        // HISTORIA
        [
            'palabras' => ['historia', 'origen', 'biblioteca zuliana', 'maría calcaño'],
            'respuesta' => 'Nació en 1873 como Biblioteca Zuliana. En 1995 se nombró María Calcaño y su sede actual es de 2008.'
        ],
        
        // SERVICIOS
        [
            'palabras' => ['servicios', 'ofrece', 'talleres', 'cursos', 'actividades'],
            'respuesta' => 'Ofrecemos alfabetización tecnológica, préstamo interno de libros y acceso a salas digitales.'
        ],
        [
            'palabras' => ['cursos', 'tecnología', 'formación', 'alfabetización'],
            'respuesta' => 'Sí, la Sala Digital ofrece programas de formación tecnológica gratuita para la comunidad.'
        ],
        [
            'palabras' => ['préstamo', 'prestamo', 'libros', 'computadoras'],
            'respuesta' => 'El préstamo es interno para consulta en sala, junto con el uso de equipos de computación.'
        ],
        
        // SALAS
        [
            'palabras' => ['salas', 'áreas', 'espacios', 'cuántas salas'],
            'respuesta' => 'Contamos con Salas de Lectura, Infantil, Braille, Digital, Hemeroteca, Fonoteca y Videoteca.'
        ],
        [
            'palabras' => ['acervo', 'histórico', 'documentos antiguos'],
            'respuesta' => 'El Acervo Histórico custodia la memoria documental y registros antiguos del Estado Zulia.'
        ],
        [
            'palabras' => ['braille', 'jusayú', 'discapacidad visual', 'ciegos'],
            'respuesta' => 'La Sala Braille Miguel Ángel Jusayú ofrece tecnología adaptada para personas con discapacidad visual.'
        ],
        [
            'palabras' => ['digital', 'fernández morán', 'humberto fernández'],
            'respuesta' => 'La Sala Digital Humberto Fernández Morán es el centro de investigación y formación tecnológica.'
        ],
        [
            'palabras' => ['infantil', 'amenodoro urdaneta', 'niños', 'lectura infantil'],
            'respuesta' => 'La Sala Infantil Amenodoro Urdaneta fomenta la lectura en niños de 5 a 14 años.'
        ],
        [
            'palabras' => ['hemeroteca', 'eduardo lópez rivas', 'periódicos', 'diarios'],
            'respuesta' => 'La Hemeroteca Eduardo López Rivas facilita la consulta de diarios y periódicos regionales.'
        ],
        [
            'palabras' => ['fonoteca', 'videoteca', 'ulises acosta', 'manuel trujillo', 'audiovisual'],
            'respuesta' => 'La Fonoteca Ulises Acosta y Videoteca Manuel Trujillo Durán resguardan el patrimonio audiovisual zuliano.'
        ],
        
        // WEB
        [
            'palabras' => ['web', 'página', 'sitio', 'internet', 'online', 'portal'],
            'respuesta' => 'Nuestra página web oficial es https://www.bibliotecapublicadelzulia.org/'
        ],
        
        // MENÚS INTRANET
        [
            'palabras' => ['cargos', 'puestos', 'empleos'],
            'respuesta' => 'Los Cargos están en el menú superior: La Organización > Cargos.'
        ],
        [
            'palabras' => ['organización', 'menú organización'],
            'respuesta' => 'El menú Organización está arriba a la izquierda; allí verás Misión, Visión, Valores, Cargos y Procedimientos.'
        ],
        [
            'palabras' => ['procedimientos', 'procesos', 'manuales'],
            'respuesta' => 'Los procedimientos están en el menú: La Organización > Procedimientos.'
        ],
        [
            'palabras' => ['misión', 'visión', 'valores'],
            'respuesta' => 'La Misión, Visión y Valores están en el menú superior: La Organización > Organización.'
        ],
        
        // ESPACIOS ESPECIALES
        [
            'palabras' => ['bibliocafé', 'café', 'bibliocafe'],
            'respuesta' => 'La Bibliocafé es un espacio para leer disfrutando de un café en un ambiente relajado.'
        ],
        [
            'palabras' => ['maría calcaño', 'poetisa'],
            'respuesta' => 'María Calcaño fue una destacada poetisa zuliana cuyo nombre honra nuestra institución.'
        ],
        
        // GESTIÓN
        [
            'palabras' => ['planificación', 'proyectos', 'planificacion'],
            'respuesta' => 'La Planificación y Proyectos están en el menú superior: Gestión Estratégica.'
        ],
        [
            'palabras' => ['informes', 'reportes', 'gestión', 'control'],
            'respuesta' => 'Los Informes de Gestión y Reportes están en el menú superior: Control.'
        ],
        [
            'palabras' => ['reuniones', 'gerenciales', 'actas'],
            'respuesta' => 'Las actas y detalles de Reuniones Gerenciales están en el menú: Gestión Estratégica.'
        ],
        
        // SEGURIDAD
        [
            'palabras' => ['leyes', 'normas', 'seguridad', 'documentos legales'],
            'respuesta' => 'Las leyes y normas están en el menú de Seguridad.'
        ],
        
        // ROBÓTICA
        [
            'palabras' => ['robótica', 'robot', 'sala robótica'],
            'respuesta' => 'No, la sala de robótica ya no existe; fue sustituida por nuevos servicios digitales.'
        ]
    ];
    
    // Buscar coincidencias (prioridad a coincidencias múltiples)
    foreach ($conocimiento as $item) {
        foreach ($item['palabras'] as $palabra) {
            if (strpos($consulta, $palabra) !== false) {
                return $item['respuesta'];
            }
        }
    }
    
    // Si no encuentra nada, mensaje por defecto
    return "Lo siento, no tengo esa información en mi base de datos. ¿Puedes preguntar de otra manera?";
}
?>