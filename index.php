<?php
session_start();

require_once __DIR__ . '/library/RequirePage.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/library/Twig.php';
require_once __DIR__ . '/library/Mailer.php';
require_once __DIR__ . '/config/Config.php';
require_once __DIR__.'/library/CheckSession.php';


// Enregistrer les information de connexion dans log
// require_once __DIR__ . '/controller/ControllerLog.php';
// $log = new ControllerLog;

//print_r($_SERVER['PATH_INFO']);
$url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : '/';


//print_r($url);

if ($url == '/') {
    require_once 'controller/ControllerHome.php';
    $controller = new ControllerHome;
    echo $controller->welcome();
} else {
    $requestURL = $url[0];
    $requestURL = ucfirst($requestURL);
    $controllerPath = __DIR__ . '/controller/Controller' . $requestURL . '.php';

    if (file_exists($controllerPath)) {
        require_once($controllerPath);
        $controllerName = 'Controller' . $requestURL;
        $controller = new $controllerName;
        if (isset($url[1]) && method_exists($controller, $url[1])) {
            $method = $url[1];
            if (isset($url[2])) {
                $value = $url[2];
                if (isset($url[3])) {
                    $value2 = $url[3];
                    echo $controller->$method($value, $value2);
                }else{
                    echo $controller->$method($value);
                }
            }else {
                echo $controller->$method();
            }
        } else {
            require_once 'controller/ControllerHome.php';
            $controller = new ControllerHome;
            echo $controller->error();
        }
    } else {
        require_once 'controller/ControllerHome.php';
        $controller = new ControllerHome;
        echo $controller->error();
    }
}
