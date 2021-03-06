<?php

namespace Nifty\Controllers;

class Controller
{
    public function view(object $data = null, $path = null, $file = null): bool
    {
        $path = $path ?? strtolower($this->path());
        $file = $file ?? $this->file();
        $fullPath = $this->basepath().'/resources/views/'.$path.'/'.$file;
        if (!file_exists($fullPath)) {
            return false;
        }
        include $fullPath;
        return true;
    }

    public function basepath(): string
    {
        return dirname(__DIR__.'/../../..', 6);
    }

    private function path(): string
    {
        $path_split = explode(
            '/',
            debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['file']
        );
        return explode('Controller', end($path_split))[0];
    }

    private function file(): string
    {
        return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function'].'.php';
    }
}
