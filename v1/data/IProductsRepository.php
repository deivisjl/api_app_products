<?php

/**
 * Punto de interacción hacia la capa de persistencia/datos para consultar/operar productos
 */
interface IProductsRepository
{
    public function getAllProducts();
}