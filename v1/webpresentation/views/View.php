<?php

/**
 * Clase base para la representación de las views
 */
interface View
{
    public function render(Response $response);
}