<?php

/**
 * Excepción personalizada para el envío de respuestas
 */
require_once 'webpresentation/http/status_messages.php';
require_once 'webpresentation/http/Response.php';

class ApiException extends Exception {
    public $response;

    public function __construct($status, $message) {
        $this->response = new Response();
        $this->response->setStatus($status);
        $this->response->setBody(['message' => $message]);
    }

}