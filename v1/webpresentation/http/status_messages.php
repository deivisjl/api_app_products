<?php
/**
 * Personalización de mensajes según estado HTTP
 */

define('ERROR_REQUEST_MALFORMED', 'Sintaxis de solicitud con formato incorrecto');
define('ERROR_RESOURCE_NOT_FOUND', 'La URL no es una referencia de un recurso en el servidor');
define('ERROR_SERVER_DATABASE', 'Ha ocurrido un error inesperado en el servidor');
define('ERROR_METHOD_NOT_ALLOWED', utf8_encode('Método no soportado para este recurso'));
define('ERROR_EMAIL', 'No existe un usuario con ese correo');
define('ERROR_AUTHORIZATION', 'Información de autorización no adjunta');
define('ERROR_WRONG_PASSWORD', 'Contraseña incorrecta');
define('ERROR_REQUIRED_AUTHORIZATION', utf8_encode('Requiere autorización'));
define('ERROR_USER_CREATION', 'El usuario no pudo ser creado');

define('MESSAGE_CREATED_USER', 'Usuario creado');