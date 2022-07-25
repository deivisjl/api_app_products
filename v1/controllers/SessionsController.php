<?php

require_once 'Controller.php';

/**
 * Controlador de sesiones
 */
class SessionsController implements Controller {

    private $_sessionsRepository;

    public function __construct($sessionsRepository) {
        $this->_sessionsRepository = $sessionsRepository;
    }


    function getAction(Request $request) {
        throw new ApiException(501, ERROR_METHOD_NOT_ALLOWED);
    }

    function postAction(Request $request) {
        $response = new Response();

        if (isset($request->url_elements[1])) {
            throw new ApiException(400, ERROR_REQUEST_MALFORMED);
        }

        if(empty($request->authorization)){
            throw new ApiException(400, ERROR_AUTHORIZATION);
        }

        $results = $this->_sessionsRepository->createSession($request->authorization);

        if (is_array($results)) {
            $response->setBody($results);
            $response->setStatus(200);
        } else if(is_string($results)){
            $response->setBody(['message' => $results]);
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