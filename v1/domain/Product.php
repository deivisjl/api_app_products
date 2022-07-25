<?php

/**
 * Representación de "Producto" como entidad de negocios
 */
class Product
{

    private $code;
    private $name;
    private $description;
    private $price;
    private $brand;
    private $unitsInStock;
    private $imageUrl;


    public function __construct($code, $name, $description, $price, $brand, $unitsInStock, $imageUrl)
    {
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->brand = $brand;
        $this->unitsInStock = $unitsInStock;
        $this->imageUrl = $imageUrl;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function getUnitsInStock()
    {
        return $this->unitsInStock;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    // Contrato para esquema de la tabla "product"
    const PRODUCT_TABLE_NAME = 'product';

}