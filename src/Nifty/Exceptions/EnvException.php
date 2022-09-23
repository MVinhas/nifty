<?php

namespace Nifty\Exceptions;

use Nifty\Controllers\Controller;

class EnvException extends Controller
{
    public function throwEnvNotFound()
    {
        $this->view(null, 'exceptions', 'env-not-found.php');
    }

    public function throwEnvNotReadable()
    {
        $this->view(null, 'exceptions', 'env-not-readable.php');
    }
}
