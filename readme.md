# API de Autenticación - Registro y Login

> "Evidencia de desempeño: GA7-220501096-AA5-EV01 diseño y desarrollo de servicios web - caso / Evidencia de producto: GA7-220501096-AA5-EV02 API"
>
> **Programa:** Análisis y Desarrollo de Software — SENA

---

## Descripción del Proyecto

API REST desarrollada en PHP para el registro e inicio de sesión de usuarios. Este servicio web permite autenticar usuarios mediante credenciales (usuario y contraseña), retornando mensajes de éxito o error según corresponda. La API está diseñada siguiendo los principios de REST y utiliza JSON como formato de intercambio de datos.

### Funcionalidades

- **Registro de usuarios:** Permite crear una nueva cuenta con usuario y contraseña.
- **Inicio de sesión:** Valida las credenciales y retorna mensaje de autenticación.
- **Validaciones:** Control de campos vacíos, usuario duplicado y credenciales incorrectas.
- **Encriptación:** Las contraseñas se almacenan encriptadas utilizando `password_hash()`.

---

## Instalación y Configuración

### Requisitos Previos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache) o servidor integrado de PHP
- Postman o cualquier cliente HTTP para pruebas

### Pasos de Instalación

1. **Clonar el repositorio**

   ```bash
   git clone https://github.com/tu-usuario/api-registro-login.git
   cd api-registro-login
   ```
2. **Configurar la base de datos**

   - Crear una base de datos llamada `api_auth`
   - Importar el archivo `sql/database.sql` desde phpMyAdmin o mediante línea de comandos:
     ```bash
     mysql -u root -p api_auth < sql/database.sql
     ```
3. **Configurar la conexión**

   - Abrir el archivo `config/Database.php`
   - Verificar las credenciales de conexión:
     ```php
     private $host = "localhost";
     private $db_name = "api_auth";
     private $username = "root";  //Cambiar segun tu configuración
     private $password = "";      //Cambiar segun tu configuración
     ```
4. **Iniciar el servidor**

   ```bash
   php -S localhost:8000
   ```

   > La API estará disponible en `http://localhost:8000`
   
   **Nota**: Si el puerto 8000 está ocupado en tu sistema, puedes cambiarlo por otro (ej. 8080, 3000) usando:

   ```bash
   php -S localhost:8080
   ```
   Recuerda ajustar las URLs de las pruebas al puerto que elijas.
---

## Pruebas de la API

A continuación se describen los 7 casos de prueba realizados con sus respectivas peticiones y respuestas esperadas. Puedes probarlos utilizando **Postman** u otro cliente HTTP.

#### Configuración Común para Todas las Peticiones

- **Headers:**
  - `Content-Type: application/json`

#### Endpoints Disponibles

| Método | Endpoint                                   | Descripción                  |
| ------- | ------------------------------------------ | ----------------------------- |
| POST    | `http://localhost:8000/api/register.php` | Registro de nuevos usuarios   |
| POST    | `http://localhost:8000/api/login.php`    | Inicio de sesión de usuarios |

**Nota**: Si cambiaste el puerto al iniciar el servidor, actualiza la URL (ej. `http://localhost:8080/api/register.php`).

---

### 1. Registro Exitoso

**Petición:**

```http
POST http://localhost:8000/api/register.php
Content-Type: application/json

{
    "username": "juanperez",
    "password": "123456"
}
```

**Respuesta Esperada:**

```json
{
    "status": "success",
    "message": "Usuario registrado exitosamente"
}
```

**Código HTTP:** `201 Created`

---

### 2. Registro con Usuario Duplicado

**Petición:**

```http
POST http://localhost:8000/api/register.php
Content-Type: application/json

{
    "username": "juanperez",
    "password": "123456"
}
```

**Respuesta Esperada:**

```json
{
    "status": "error",
    "message": "El usuario ya existe"
}
```

**Código HTTP:** `409 Conflict`

---

### 3. Registro con Campos Vacíos

**Petición:**

```http
POST http://localhost:8000/api/register.php
Content-Type: application/json

{
    "username": "",
    "password": ""
}
```

**Respuesta Esperada:**

```json
{
    "status": "error",
    "message": "Username y password no pueden estar vacíos"
}
```

**Código HTTP:** `400 Bad Request`

---

### 4. Login Exitoso

**Petición:**

```http
POST http://localhost:8000/api/login.php
Content-Type: application/json

{
    "username": "juanperez",
    "password": "123456"
}
```

**Respuesta Esperada:**

```json
{
    "status": "success",
    "message": "Autenticación satisfactoria",
    "user_id": 1
}
```

**Código HTTP:** `200 OK`

---

### 5. Login con Contraseña Incorrecta

**Petición:**

```http
POST http://localhost:8000/api/login.php
Content-Type: application/json

{
    "username": "juanperez",
    "password": "contraseñaincorrecta"
}
```

**Respuesta Esperada:**

```json
{
    "status": "error",
    "message": "Error en la autenticación"
}
```

**Código HTTP:** `401 Unauthorized`

---

### 6. Login con Usuario No Existente

**Petición:**

```http
POST http://localhost:8000/api/login.php
Content-Type: application/json

{
    "username": "usuariofalso",
    "password": "123456"
}
```

**Respuesta Esperada:**

```json
{
    "status": "error",
    "message": "Error en la autenticación"
}
```

**Código HTTP:** `401 Unauthorized`

---

### 7. Login con Campos Vacíos

**Petición:**

```http
POST http://localhost:8000/api/login.php
Content-Type: application/json

{
    "username": "",
    "password": ""
}
```

**Respuesta Esperada:**

```json
{
    "status": "error",
    "message": "Username y password no pueden estar vacíos"
}
```

**Código HTTP:** `400 Bad Request`

---

## Pruebas con Postman / O alguna alternativa

Para probar la API, puedes utilizar **Postman** o su extensión de VS Code:

1. Abre tu cliente HTTP preferido
2. Configura una nueva petición con método `POST`
3. Agrega el header: `Content-Type: application/json`
4. Ingresa la URL del endpoint
5. En el body, selecciona formato JSON y escribe las credenciales
6. Haz clic en "Send" y observa la respuesta

### Códigos de Respuesta HTTP

| Código                   | Significado                       |
| ------------------------- | --------------------------------- |
| 200 OK                    | Login exitoso                     |
| 201 Created               | Usuario registrado exitosamente   |
| 400 Bad Request           | Campos vacíos o datos inválidos |
| 401 Unauthorized          | Credenciales incorrectas          |
| 404 Not Found             | Endpoint no encontrado            |
| 405 Method Not Allowed    | Método HTTP no permitido         |
| 409 Conflict              | Usuario ya existe                 |
| 500 Internal Server Error | Error interno del servidor        |

---

## Aprendices

* Diego Armando Higuita Cortés
* Gean Carlos Coplas Romero
* Luis Eduardo Zabaleta Mora
* Yessica Alejandra Martínez Rincón

---

## Institución

**Servicio Nacional de Aprendizaje — SENA**
**Programa:** Análisis y Desarrollo de Software
**Ficha:** 3070324
**Año:** 2026
