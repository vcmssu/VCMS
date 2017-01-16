<?php

try {

    $router = new Router(Functions::GET_HTTP_HOST());

    /* простейшее подключение файлов с папки, в будущем переписать */
    if ($handle = opendir(HOME . '/app/core/route')) {
        while (false !== ($file = readdir($handle))) {
            if ($file != "." && $file != "..") {
                if (substr($file, strlen($file) - 4) == ".php") {
                    require_once HOME . '/app/core/route/' . $file;
                }
            }
        }
        closedir($handle);
    }

    $route = $router->match(Functions::GET_METHOD(), Functions::GET_PATH_INFO());

    if (null == $route) {
        $route = new MatchedRoute('MainController:error404');
        SmartySingleton::instance()->assign(array(
            'route' => 1
        ));
    }

    list($class, $action) = explode(':', $route->getController(), 2);

    call_user_func_array(array(new $class($router), $action), $route->getParameters());
} catch (Exception $e) {

    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

    echo $e->getMessage();
    echo $e->getTraceAsString();
    exit;
}
