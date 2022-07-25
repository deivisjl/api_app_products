<?php

require_once 'SessionsStore.php';
require_once 'domain/User.php';

/**
 * Almacén de sesiones
 */
class SqlSessionsDataSource implements SessionsStore {

    private $_mysqlHandler;

    public function __construct(PDO $mysqlHandler) {
        $this->_mysqlHandler = $mysqlHandler;
    }

    public function login($email, $password) {
        try {
            $stm = "select * from " . User::TABLE_NAME_USER .
                " where " . User::COLUMN_EMAIL . "= ?";

            $prepareStm = $this->_mysqlHandler->prepare($stm);
            $prepareStm->bindParam(1, $email);

            if ($prepareStm->execute()) {

                $res = $prepareStm->fetch();

                if(!empty($res)) {
                    // Construir usuario a partir del objeto plano
                    $user = User::fromRawObject($res);

                    // Comprobar validez de la contraseña
                    if ($user->verifyHashPassword($password)) {
                        return $user->toArray();
                    } else {
                        throw new ApiException(400, ERROR_WRONG_PASSWORD);
                    }
                }else{
                    throw new ApiException(400, ERROR_EMAIL);
                }

            } else {
                throw new ApiException(500, ERROR_SERVER_DATABASE);
            }
        } catch (PDOException $e) {
            $message = $e->getMessage();
            throw new ApiException(500, ERROR_SERVER_DATABASE . ": $message");
        }
    }
}