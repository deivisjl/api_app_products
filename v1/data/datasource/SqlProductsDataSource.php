<?php

/**
 * Fuente de datos en MySQL
 */
require_once 'ProductsStore.php';
require_once 'domain/Product.php';

class SqlProductsDataSource implements ProductsStore {

    private $dbh;
    private $table_name = Product::PRODUCT_TABLE_NAME;


    public function __construct(PDO $dbh) {
        $this->dbh = $dbh;
    }


    function retrieve() {
        $sql = 'SELECT * FROM ' . $this->table_name;
        $stmt = $this->dbh->prepare($sql);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return $stmt->errorInfo()[2];
        }
    }
}