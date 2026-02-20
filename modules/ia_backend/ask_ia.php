<?php
// modules/ia_backend/ask_ia.php

// 1. Configuración del Motor Local (Python FastAPI)
// Ya no necesitamos API Key de Google, usamos tu puerto local 8000
$LOCAL_IA_URL = "http://localhost:8000/consultar";

// 2. Recibir la pregunta del frontend
$inputData = json_decode(file_get_contents("php://input"), true);
$userPrompt = $inputData['prompt'] ?? '';

if (empty($userPrompt)) {
    header('Content-Type: application/json');
    echo json_encode(['respuesta' => 'No se recibió ninguna pregunta']);
    exit;
}

// 3. Preparar el cuerpo de la petición para Python
// Tu main.py espera un JSON con la clave "prompt"
$requestBody = [
    "prompt" => $userPrompt
];

// 4. Ejecutar la petición usando cURL hacia tu motor local
$ch = curl_init($LOCAL_IA_URL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestBody));

// Como es local (http), no necesitamos verificar SSL
curl_setopt($ch, CURLOPT_TIMEOUT, 5); // Tiempo de espera máximo

$response = curl_exec($ch);

// Manejo de errores de conexión (por si main.py está apagado)
if(curl_errno($ch)){
    $error_msg = curl_error($ch);
    header('Content-Type: application/json');
    echo json_encode(['respuesta' => 'Error: El Motor de IA local (Python) no está encendido.']);
    curl_close($ch);
    exit;
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// 5. Devolver la respuesta al frontend
header('Content-Type: application/json');

if ($httpCode === 200) {
    // Si todo salió bien, enviamos la respuesta de Python tal cual
    echo $response;
} else {
    echo json_encode(['respuesta' => 'Hubo un problema procesando la consulta en el motor local.']);
}
?>