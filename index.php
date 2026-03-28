<?php
/**
 * API de Autenticación - Punto de entrada
 * Retorna información básica de los endpoints disponibles
 */
header("Content-Type: application/json");
echo json_encode([
    'api' => 'Servicio de autenticación',
    'version' => '1.0',
    'endpoints' => [
        'register' => [
            'method' => 'POST',
            'url' => '/api/register.php'
        ],
        'login' => [
            'method' => 'POST', 
            'url' => '/api/login.php'
        ]
    ]
]);