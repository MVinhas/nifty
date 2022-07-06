<?php

namespace Nifty\Controllers;

class Controller
{
    /**
     *
     * Know who called me, get the view path from that information
     * and also the filename to be called
     */
    public function view(object $data = null)
    {
        include __DIR__.'/../../../resources/views/'.strtolower($this->path()).'/'.$this->file();
    }

    private function path(): string
    {
        $explode = explode(
            '/',
            debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['file']
        );
        return str_replace('Controller.php', '', end($explode));
    }

    private function file(): string
    {
        return debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2]['function'].'.php';
    }
}
