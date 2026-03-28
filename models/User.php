<?php
/**
 * Clase User - Modelo para manejar operaciones de usuarios
 * 
 * Implementa los conceptos de Clases y Objetos
 * La clase es el "plano" (como el apartamento en la analogía)
 * Los objetos serán las instancias creadas
 */

class User {
    // Propiedades privadas - encapsulamiento
    private $conn;
    private $table_name = "users";
    
    // Propiedades públicas (visibilidad public)
    public $id;
    public $username;
    public $password;

    /**
     * Constructor de la clase - se ejecuta al crear el objeto
     * @param PDO $db Conexión a la base de datos
     */
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Método para registrar un nuevo usuario
     * @return bool True si el registro es exitoso, False en caso contrario
     */
    public function register() {
        // Verificar si el usuario ya existe (función de validación)
        if($this->userExists()) {
            return false;
        }

        // Consulta SQL usando DML (INSERT)
        $query = "INSERT INTO " . $this->table_name . "
                  SET username = :username, password = :password";

        $stmt = $this->conn->prepare($query);

        // Encriptar contraseña por seguridad
        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        // Vincular parámetros
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $hashed_password);

        // Ejecutar y retornar resultado
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Método privado para verificar si un usuario existe
     * Visibilidad private
     * @return bool True si existe, False si no existe
     */
    private function userExists() {
        $query = "SELECT id FROM " . $this->table_name . " 
                  WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    /**
     * Método para autenticar usuario (login)
     * Implementa la lógica de autenticación requerida
     * 
     * @return bool True si la autenticación es exitosa, False en caso contrario
     */
    public function login() {
        $query = "SELECT id, username, password FROM " . $this->table_name . " 
                  WHERE username = :username LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row['password'];

            // Verificar contraseña usando password_verify
            if(password_verify($this->password, $hashed_password)) {
                $this->id = $row['id'];
                return true;
            }
        }
        return false;
    }
}
?>
