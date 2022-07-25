<?php


/**
 * Implementación concreta del repositorio de productos
 */
class ProductsRepository implements IProductsRepository
{
    private $sqlProductsDataSource;

    public function __construct(ProductsStore $productsDataSource)
    {
        $this->sqlProductsDataSource = $productsDataSource;
    }


    public function getAllProducts()
    {
        return $this->sqlProductsDataSource->retrieve();
    }
}