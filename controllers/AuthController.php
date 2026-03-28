<?php
/**
 * Clase AuthController - Controlador para manejar autenticación
 * 
 * Implementa el patrón MVC y encapsula la lógica de negocio
 * Cada método realiza una sola tarea (principio de responsabilidad única)
 */

class AuthController {
    // Propiedad privada para almacenar el modelo de usuario
    private $user;

    /**
     * Constructor - Inicializa el modelo User
     * 
     * @param PDO $db Conexión a la base de datos
     */
    public function __construct($db) {
        $this->user = new User($db);
    }

    /**
     * Maneja el registro de usuarios
     * Valida los datos de entrada antes de procesar
     * 
     * @param array $data Datos del usuario (username, password)
     * @return array Respuesta con estado, mensaje y código HTTP
     */
    public function register($data) {
        // Validación de campos requeridos
        if(!isset($data['username']) || !isset($data['password'])) {
            return $this->response('error', 'Se requieren username y password', 400);
        }

        // Validación de campos vacíos
        if(empty(trim($data['username'])) || empty(trim($data['password']))) {
            return $this->response('error', 'Username y password no pueden estar vacíos', 400);
        }

        // Asignar valores al modelo
        $this->user->username = trim($data['username']);
        $this->user->password = $data['password'];

        // Intentar registrar
        if($this->user->register()) {
            return $this->response('success', 'Usuario registrado exitosamente', 201);
        } else {
            return $this->response('error', 'El usuario ya existe', 409);
        }
    }

    /**
     * Maneja el inicio de sesión
     * Valida credenciales y retorna resultado de autenticación
     * 
     * @param array $data Datos del usuario (username, password)
     * @return array Respuesta con estado, mensaje y código HTTP
     */
    public function login($data) {
        // Validación de campos requeridos
        if(!isset($data['username']) || !isset($data['password'])) {
            return $this->response('error', 'Se requieren username y password', 400);
        }

        // Validación de campos vacíos
        if(empty(trim($data['username'])) || empty(trim($data['password']))) {
            return $this->response('error', 'Username y password no pueden estar vacíos', 400);
        }

        // Asignar valores al modelo
        $this->user->username = trim($data['username']);
        $this->user->password = $data['password'];

        // Intentar autenticar
        if($this->user->login()) {
            return $this->response('success', 'Autenticación satisfactoria', 200, [
                'user_id' => $this->user->id
            ]);
        } else {
            return $this->response('error', 'Error en la autenticación', 401);
        }
    }

    /**
     * Método privado para estandarizar respuestas
     * Implementa el formato JSON como se indica en Tema 3.6
     * 
     * @param string $status Estado de la respuesta (success/error)
     * @param string $message Mensaje descriptivo
     * @param int $http_code Código HTTP
     * @param array $extra Datos adicionales opcionales
     * @return array Respuesta formateada
     */
    private function response($status, $message, $http_code, $extra = []) {
        $response = [
            'status' => $status,
            'message' => $message
        ];
        
        // Agregar datos adicionales si existen
        if(!empty($extra)) {
            $response = array_merge($response, $extra);
        }
        
        return [
            'body' => $response,
            'http_code' => $http_code
        ];
    }
}
?>
