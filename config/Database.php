<?php
/**
 * Clase Database - Configuración y conexión a MySQL
 * 
 * Basado en los conceptos del Tema 5: Conexiones a SQL
 * Utiliza PDO para conexiones seguras a bases de datos
 */

class Database {
    // Propiedades privadas (visibilidad private)
    private $host = "localhost";
    private $db_name = "api_auth";
    private $username = "root"; //Cambiar segun tu configuración
    private $password = ""; //Cambiar segun tu configuración
    public $conn;

    /**
     * Método público para obtener la conexión a la base de datos
     * 
     * @return PDO|null Objeto de conexión PDO o null si falla
     */
    public function getConnection() {
        $this->conn = null;
        
        try {
            // Crear conexión usando PDO
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            // Configurar atributos para manejo de errores
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
            
        } catch(PDOException $exception) {
            // Manejo de errores
            echo "Error de conexión: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}
?>
