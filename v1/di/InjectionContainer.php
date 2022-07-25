<?php

/**
 * Simple contenedor manual para injección de dependencias
 */
require_once 'external/mysql/login_mysql.php';

class InjectionContainer {
    private static $pdo = null;

    public static function provideDatabaseInstance() {
        if (self::$pdo == null) {
            try {
                self::$pdo = new PDO(
                    'mysql:dbname=' . DATABASE .
                    ';host=' . HOST . ";",
                    MYSQL_USER,
                    MYSQL_PASSWORD,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
                );

                // Habilitar excepciones
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                throw new ApiException(500, ERROR_SERVER_DATABASE.' : '.$exception->getMessage());
            }
        }

        return self::$pdo;

    }
}