<?php

/**
 * Repositorio de sesiones
 */
class SessionsRepository implements ISessionsRepository {

    private $_mysqlSessionsStore;

    public function __construct(SessionsStore $mysqlUsersStore) {
        $this->_mysqlSessionsStore = $mysqlUsersStore;
    }


    public function createSession($authorization) {

        $encodeFragments = explode(" ", $authorization);

        $credentials = explode(":", base64_decode($encodeFragments[1]));

        return $this->_mysqlSessionsStore->login($credentials[0], $credentials[1]);

    }
}