<?php
/**
 * API Endpoint: Registro de usuarios
 * 
 * Método HTTP permitido: POST
 * Formato de entrada: JSON
 * Formato de salida: JSON
 * 
 * Ejemplo de petición:
 * {
 *     "username": "diegocortes",
 *     "password": "123456"
 * }
 */

// Configurar cabeceras para API REST
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Manejar peticiones OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Verificar método HTTP
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido. Use POST'
    ]);
    exit();
}

// Incluir archivos necesarios
require_once '../config/Database.php';
require_once '../models/User.php';
require_once '../controllers/AuthController.php';

try {
    // Inicializar la base de datos
    $database = new Database();
    $db = $database->getConnection();
    
    // Inicializar el controlador
    $authController = new AuthController($db);
    
    // Leer datos de entrada (JSON)
    $input = json_decode(file_get_contents("php://input"), true);
    
    // Si no hay datos JSON, intentar con POST
    if(empty($input)) {
        $input = $_POST;
    }
    
    // Procesar registro
    $result = $authController->register($input);
    
    // Enviar respuesta
    http_response_code($result['http_code']);
    echo json_encode($result['body']);
    
} catch(Exception $e) {
    // Manejo de errores con try/catch
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error interno del servidor: ' . $e->getMessage()
    ]);
}
?>