<?php
use Library\Config;
use Library\Controller;
use Library\NotFoundException;
use Library\Request;
use Library\Router;
use Library\Session;
use Library\Pagination;

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', __DIR__ . DS . '..' . DS);
define('VIEW_DIR', ROOT . 'View' . DS);
define('LIB_DIR', ROOT . 'Library' . DS);
define('CONTROLLER_DIR', ROOT . 'Controller' . DS);
define('MODEL_DIR', ROOT . 'Model' . DS);
define('CONF_DIR', ROOT . 'Config' . DS);

function __autoload($className)
{
    $file = ROOT . str_replace('\\', DS, $className) . '.php';

    if (!file_exists($file)) {
    throw new \Exception("{$file} not found", 500);
     }
    require $file;
}


try {
    Session::start();

    Config::setFromXML('db.xml');

    Router::init('routes.php');

    $request = new Request();
    Router::match($request);

    $controller = Router::$controller;
    $action = Router::$action;

    $controller = new $controller();

    if (!method_exists($controller, $action)) {
        throw new \Exception("{$action} not found", 500);
    }

    $content = $controller->$action($request);
    
} catch (PDOException $e) {
    // you can make it different for PDO
    $content = Controller::renderError($e->getMessage(), $e->getCode());
} catch (NotFoundException $e) {
    // you can make it different
    $content = Controller::renderError($e->getMessage(), $e->getCode());
} catch (Exception $e) {
    $content = Controller::renderError($e->getMessage(), $e->getCode());
}

echo $content;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;


?>

