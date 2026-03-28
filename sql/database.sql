-- Script de creación de base de datos para el servicio de autenticación

-- Crear base de datos
CREATE DATABASE IF NOT EXISTS api_auth;
USE api_auth;

-- Crear tabla de usuarios
-- DDL: CREATE TABLE
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT 'Identificador único del usuario',
    username VARCHAR(50) UNIQUE NOT NULL COMMENT 'Nombre de usuario único',
    password VARCHAR(255) NOT NULL COMMENT 'Contraseña encriptada',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación'
) COMMENT='Tabla de usuarios para autenticación';

-- Insertar usuario de prueba (opcional)
-- DML: INSERT
-- Contraseña: 123456 (encriptada)
INSERT INTO users (username, password) 
VALUES ('prueba', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE id = id;
