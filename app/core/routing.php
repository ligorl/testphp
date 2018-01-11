<?php

class Routing {

    static function execute($config) {
        $controllerName = 'index';
        $actionName = 'index';
        $piecesOfUrl = explode('/', $_SERVER['REQUEST_URI']);
//        print_r($piecesOfUrl);
//        die;
        if (!empty($piecesOfUrl[1])) {
            $controllerName = Routing::getClear($piecesOfUrl[1]);
        }
        if (!empty($piecesOfUrl[2])) {
            $actionName = Routing::getClear($piecesOfUrl[2]);
        }

        $modelName = $controllerName . '_model';
        $viewName = $controllerName . '_view';
        $controllerName = $controllerName . '_controller';

        $action_name = 'action_' . $actionName;


        $fileWithModel = strtolower($modelName) . '.php';
        $fileWithModelPath = "app/models/" . $fileWithModel;
        if (file_exists($fileWithModelPath)) {
            include $fileWithModelPath;
        } else {
            echo "err model $fileWithModelPath";
        }
        $fileWithView = strtolower($viewName) . '.php';
        $fileWithViewPath = "app/views/" . $fileWithView;
        if (file_exists($fileWithViewPath)) {
            include $fileWithViewPath;
        } else {
            echo "err view " . $fileWithViewPath;
        }
        $fileWithController = strtolower($controllerName) . '.php';
        $fileWithControllerPath = "app/controllers/" . $fileWithController;
        if (file_exists($fileWithControllerPath)) {
            include $fileWithControllerPath;
        } else {
            echo "err file";
        }
        //print_r($config['link']);die;
        $controller = new $controllerName($config['link']);
        $action = $action_name;

        if (method_exists($controller, $action)) {
            call_user_func(array($controller, $action), $piecesOfUrl);
        } else {
            echo "err method";
        }
    }

    static function getClear($str) {
        $pos = strpos($str, "?");        
        if ($pos !== false) {
            $str = substr($str, 0, $pos);
            
        }
        return $str;
    }

}
