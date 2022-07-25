<?php

/**
 * Representa una petición HTTP proveniente del cliente Android
 */
class Request {
    public $url_elements;
    public $verb;
    public $parameters;
    public $authorization;

    public function __construct() {
        // Obtener verbo HTTP
        $this->verb = $_SERVER['REQUEST_METHOD'];

        // ¿No viene ruta definida en la URL?
        if (!isset($_GET['PATH_INFO'])) {
            return false;
        }

        // ¿Qué segmentos trae la URL?
        $this->url_elements = explode('/', $_GET['PATH_INFO']);

        // Obtener parámetros
        $this->parseIncomingParameters();

        // Cabecera Authorization
        if (isset(apache_request_headers()['Authorization'])) {
            $this->authorization = apache_request_headers()['Authorization'];
        }

        return true;
    }

    private function parseIncomingParameters() {
        $parameters = array();

        $body = file_get_contents("php://input");

        $body_params = json_decode($body);
        if ($body_params) {
            foreach ($body_params as $param_name => $param_value) {
                $parameters[$param_name] = $param_value;
            }
        }

        $this->parameters = $parameters;

    }

}