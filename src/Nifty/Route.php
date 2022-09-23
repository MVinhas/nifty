<?php

namespace Nifty;

use Nifty\Controllers\SiteController;
use Nifty\Exceptions\NiftyNotFoundException;

class Route
{
    public function run(): void
    {
        (new SiteController())->head();
        (new Db())->initialize();
        (new SiteController())->header();
        (new Route())->contentToRender();
        (new SiteController())->footer();
    }

    private function contentToRender(): void
    {
        $uri = $this->getURI();
        if (class_exists($uri->controller)) {
            $controller = $uri->controller;
            $method = $uri->method;
            $params = $uri->params;
            $params ? (new $controller())->{$method}(...$params) : (new $controller())->{$method}();
        } else {
            (new NiftyNotFoundException())->throw404();
        }
    }

    private function getURI(): object
    {
        $path_info = $_SERVER['PATH_INFO'] ?? '/';
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $url = explode(
            '/',
            $host.$path_info
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
