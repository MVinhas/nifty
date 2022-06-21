<?php

namespace Nifty;

class Route
{
    public static function contentToRender()
    {
        $uri = self::getURI();
        if (class_exists($uri->controller)) {
            $controller = $uri->controller;
            $method = $uri->method;
            $params = $uri->params;
            $params ? $controller::{$method}(...$params) : $controller::{$method}();
        }
    }

    private static function getURI()
    {
        $url = explode(
            '/',
            $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']
        );

        /**
         * 
         * 0 Domain
         * 1 Controller
         * 2 Method
         * 3+ Args
         * 
         */
        $controllerArg = $url[1] ?? null;
        $methodArg = $url[2] ?? null;

        $numArgs = count($url);
        for ($i = 3; $i <= $numArgs; $i++) {
            $parameterArgs[] = $url[$i] ?? null;
        }

        $controller = !empty($controllerArg) ? 
            '\Nifty\Controllers\\'.$controllerArg.'Controller' : 
            '\Nifty\Controllers\HomeController';

        $method = !empty($methodArg) ? $methodArg : 'index';

        $params = !empty($parameterArgs) ? $parameterArgs : [];

        return (object)[
            'controller' => $controller,
            'method' => $method,
            'params' => $params
        ];
    }
}