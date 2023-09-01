<?php

namespace Nifty\Controllers;

class Controller
{
    public function view(?object $data = null, $path = null, $file = null): bool
    {
        $path ??= strtolower($this->path());
        $file ??= $this->file();
        $file = pathinfo($file, PATHINFO_EXTENSION) === 'php' ? $file : $file . '.php';
        $fullPath = $this->basepath() . '/resources/views/' . $path . '/' . $file;
        $this->defaultData($data);
        if (!file_exists($fullPath)) {
            return false;
        }
        include $fullPath;
        return true;
    }

    private function path(): string
    {
        $path_split = explode('/', debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['file']);
        return explode('Controller', end($path_split))[0];
    }

    private function file(): string
    {
        return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function'] . '.php';
    }

    public function basepath(): string
    {
        return dirname(__DIR__ . '/../../..', 6);
    }

    private function defaultData(&$data = null): void
    {
        if (is_null($data)) {
            $data = (object)[];
        }
        $home = new HomeController();
        $data->about = $home->getAboutContent();
        $data->social_networks = $home->getSocialNetworks();
        $data->archive = $home->getArchive();
    }
}
