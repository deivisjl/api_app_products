<?php

/**
 * Controlador de los Productos
 */

require_once 'Controller.php';
require_once 'webpresentation/http/Response.php';
require_once 'webpresentation/http/status_messages.php';


class ProductsController implements Controller {

    private $_productsRepository;
    private $_usersRepository;


    public function __construct(IProductsRepository $productsRepository,
                                IUsersRepository $usersRepository) {
        $this->_productsRepository = $productsRepository;
        $this->_usersRepository= $usersRepository;
    }


    public function getAction(Request $request) {
        $response = new Response();

        // Comprobación de URL
        if (isset($request->url_elements[1])) {
            throw new ApiException(400, ERROR_REQUEST_MALFORMED);
        }

        // Parámetros para confrontar la existencia del permiso
        $token = $request->authorization;
        $action = "view";
        $resource = $request->url_elements[0];

        // Autorizar usuario
        if($this->_usersRepository->isAuthorizedUser($token, $action, $resource)) {
            $results = $this->_productsRepository->getAllProducts();
        }else{
            throw new ApiException(401, ERROR_REQUIRED_AUTHORIZATION);
        }

        if (is_array($results)) {
            $response->setBody($results);
            $response->setStatus(200);
        } else if (is_string($results)) {
            $response->setBody(['message' => $results]);
            $response->setStatus(200);
        }


        return $response;
    }

    public function postAction(Request $request) {
        throw new ApiException(501, ERROR_METHOD_NOT_ALLOWED);

    }

    public function putAction(Request $request) {
        throw new ApiException(501, ERROR_METHOD_NOT_ALLOWED);
    }

    public function deleteAction(Request $request) {
        throw new ApiException(501, ERROR_METHOD_NOT_ALLOWED);
    }
}

