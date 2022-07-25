<?php

/**
 * Representación general del repositorio de usuarios
 */
interface IUsersRepository {

    function saveUser($requestParams);

    function isAuthorizedUser($token, $action, $resource);
}