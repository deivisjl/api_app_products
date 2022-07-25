<?php

require_once 'Controller.php';
require_once 'domain/Role.php';

/**
 * Controlador de usuarios (users)
 */
class UsersController implements Controller {

    private $_usersRepository;


    public function __construct(UsersRepository $usersRepository) {
        $this->_usersRepository = $usersRepository;
    }


    function getAction(Request $request) {
        throw new ApiException(501, ERROR_METHOD_NOT_ALLOWED);
    }

    function postAction(Request $request) {
        $response = new Response();

        // Comprobación de URL
        if (isset($request->url_elements[1])) {
            throw new ApiException(400, ERROR_REQUEST_MALFORMED);
        }

        // Parámetros para confrontar la existencia del permiso
        $token = $request->authorization;
        $action = "add";
        $resource = $request->url_elements[0];

        // Comprobar si existe permiso para el usuario
        if ($this->_usersRepository->isAuthorizedUser($token, $action, $resource)) {
            $requestParams = $request->parameters;
            $results = $this->_usersRepository->saveUser($requestParams);
        } else {
            throw new ApiException(401, ERROR_REQUIRED_AUTHORIZATION);
        }

        if ($results) {
            $response->setBody(['message' => MESSAGE_CREATED_USER]);
            $response->setStatus(201);
        } else {
            $response->setBody(['message' => ERROR_USER_CREATION]);
            $response->setStatus(400);
        }
        return $response;
    }

    function putAction(Request $request) {
        throw new ApiException(501, ERROR_METHOD_NOT_ALLOWED);
    }

    function deleteAction(Request $request) {
        throw new ApiException(501, ERROR_METHOD_NOT_ALLOWED);
    }
}