<?php
/**
 *  index.php es el encargado de realizar el proceso de enrutamiento de recursos.
 *  Dependiendo de la petición, así mismo se carga el controlador respectivo.
 *  El controlador elegido tomará los atributos de la petición y consultará la capa de persistencia,
 *  para luego retornar los datos/errores en la vista JSON
 */

require_once 'webpresentation/views/JsonView.php';
require_once 'webpresentation/http/Request.php';
require_once 'di/InjectionContainer.php';
require_once 'webpresentation/exceptions/ApiException.php';
require_once 'webpresentation/http/status_messages.php';

// Apagado/Encendido de errores PHP
if (strtolower(getenv('DEVELOPMENT')) == "on") {
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
}

spl_autoload_register(function ($classname) {

    if (preg_match('/[a-zA-Z]+Controller$/', $classname)) {
        include __DIR__ . "/controllers/" . $classname . ".php";
        return true;
    } elseif (preg_match('/[a-zA-Z]+Repository$/', $classname)) {
        include __DIR__ . '/data/' . $classname . '.php';
        return true;
    } elseif (preg_match('/[a-zA-Z]+DataSource$/', $classname)) {
        include __DIR__ . '/data/datasource/' . $classname . '.php';
        return true;
    }
    return false;
}
);

set_exception_handler(function (ApiException $exception) {
    $json_view = new JsonView();
    $json_view->render($exception->response);
}
);

// Tomamos la petición entrante
$request = new Request();

// Se preparan directrices de enrutamiento
$plural_uc_resource_name = ucfirst($request->url_elements[0]);
$controller_name = $plural_uc_resource_name . 'Controller';
$repository_name = $plural_uc_resource_name . 'Repository';
$sql_data_source_name = 'Sql' . $plural_uc_resource_name . 'DataSource';

// Comprobar que las clases existan
$class_exists = class_exists($controller_name);
$class_exists1 = class_exists($repository_name);
$class_exists2 = class_exists($sql_data_source_name);


if ($class_exists && $class_exists1 && $class_exists2) {

    // Crear vista JSON
    $json_view = new JsonView();

    // Crear almacén de datos
    $sql_data_source = new $sql_data_source_name(
        InjectionContainer::provideDatabaseInstance());


    // Crear repositorio
    $repository = new $repository_name($sql_data_source);

    // Crear repositorio de usuarios para todos aquellos recursos protegidos
    if (strcasecmp($request->url_elements[0], 'users') != 0) {
        $mysqlUsersStore = new SqlUsersDataSource(InjectionContainer::provideDatabaseInstance());
        $userRepository = new UsersRepository($mysqlUsersStore);

        $controller = new $controller_name($repository, $userRepository);
    } else {
        $controller = new $controller_name($repository);
    }

    // Esto nos permitirá ejecutar la acción que viene del ciente
    $action_name = strtolower($request->verb) . 'Action';
    $response = $controller->$action_name($request);

    // Y finalmente, mostraremos la respuesta
    $json_view->render($response);

} else {
    throw new ApiException(404, ERROR_RESOURCE_NOT_FOUND);
}
