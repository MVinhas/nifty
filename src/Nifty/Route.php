<?php

namespace Nifty;

use Nifty\Controllers\SiteController;
use Nifty\Exceptions\NiftyNotFoundException;

class Route
{
    public function run(): void
    {
        $site = new SiteController();
        $site->head();
        $site->header();
        $this->contentToRender();
        $site->footer();
    }

    private function contentToRender(): void
    {
        $uri = $this->getURI();
        if (class_exists($uri->controller)) {
            $controller = $uri->controller;
            $method = $uri->method;
            $params = $uri->params;
            if (method_exists((new $controller()), $method)) {
                $params ? (new $controller())->{$method}(...$params) : (new $controller())->{$method}();
            } else {
                //Since method was not in the URL, then $method must be the parameter (if it exists)
                $params[] = $method;
                $method ? (new $controller())->index(...$params) : (new $controller())->index();
            }

        } else {
            (new NiftyNotFoundException())->throw404();
        }
    }

    public function getURI(): object
    {
        $path_info = $_SERVER['PATH_INFO'] ?? '/';
        $host = $_SERVER['HTTP_HOST'] ?? '';
        $url = explode(
            '/',
            $host . $path_info
        );

        /**
         * Some controllers are inside a subfolder
         * Only one sublevel allowed
         */
        $this->checkIfIsDir($url);
        $controllerArg = $url[1] ?? '';
        $methodArg = $url[2] ?? '';

        $numArgs = count($url);
        $parameterArgs = [];
        for ($i = 3; $i <= $numArgs; $i++) {
            if (array_key_exists($i, $url)) {
                $parameterArgs[] = $url[$i];
            }
        }
        $controller = $controllerArg !== '' ?
            '\Nifty\Controllers\\' . $controllerArg . 'Controller' :
            '\Nifty\Controllers\HomeController';

        $method = $methodArg !== '' ? $methodArg : 'index';
        return (object)[
            'controller' => $controller,
            'model' => ucfirst($controllerArg),
            'method' => $method,
            'params' => $parameterArgs
        ];
    }

    private function checkIfIsDir(&$url): void
    {
        if (is_dir(__DIR__ . '/Controllers/' . $url[1])) {
            $url = array_combine(range(-1, count($url) - 2), array_values($url));
            if (array_key_exists(1, $url)) {
                $url[1] = $url[0] . '\\' . ucfirst($url[1]);
            }
        } else {
            $url[1] = ucfirst($url[1]);
        }
    }
}
