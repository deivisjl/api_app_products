<?php

require_once 'domain/User.php';

/**
 * Repositorio de usuarios
 */
class UsersRepository implements IUsersRepository {

    private $_mysqlUsersStore;

    public function __construct(SqlUsersDataSource $mysqlUsersStore) {
        $this->_mysqlUsersStore = $mysqlUsersStore;
    }


    function saveUser($requestParams) {
        $user = User::fromRequestParams($requestParams);

        // ¿No se pudo crear el usuario a causa de malos parámetros?
        if (!$user) {
            throw new ApiException(400, ERROR_REQUEST_MALFORMED);
        }

        // Generar Token
        $user->setToken(uniqid(rand(), TRUE));

        return $this->_mysqlUsersStore->save($user);
    }

    function isAuthorizedUser($token, $action, $resource) {
        $rawUser = $this->_mysqlUsersStore->checkPermissionOverResource($token, $action, $resource);
        if (!isset($rawUser["id"])) {
            return false;
        }
        return true;
    }
}