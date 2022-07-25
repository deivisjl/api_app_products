<?php
require_once __DIR__ . '/View.php';

/**
 * Genera outputs con formato JSON
 */
class JsonView implements View
{

    public function render(Response $response)
    {
        header('Content-Type: application/json; charset=utf8');
        echo json_encode($response->getBody(), JSON_PRETTY_PRINT);
        http_response_code($response->getStatus());
        return true;
    }
}