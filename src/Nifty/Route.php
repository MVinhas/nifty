<?php

namespace Nifty;

use Nifty\Controllers\SiteController;

class Route
{
    public function run()
    {
        (new Db)->initialize();
        (new SiteController)->head();
        (new SiteController)->header();
        (new Route)->contentToRender();
        (new SiteController)->footer();
    }

    private function contentToRender()
    {
        $uri = $this->getURI();
        if (class_exists($uri->controller)) {
            $controller = $uri->controller;
            $method = $uri->method;
            $params = $uri->params;
            $params ? (new $controller)->{$method}(...$params) : (new $controller)->{$method}();
        }
    }

    private function getURI() : object
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
