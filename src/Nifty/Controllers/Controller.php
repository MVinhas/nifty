<?php

namespace Nifty\Controllers;

class Controller
{
    public function view(object $data = null, $path = null, $file = null): void
    {
        $path = $path ?? strtolower($this->path());
        $file = $file ?? $this->file();
        include $this->basepath().'/resources/views/'.$path.'/'.$file;
    }

    public function basepath(): string
    {
        return __DIR__.'/../../..';
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
