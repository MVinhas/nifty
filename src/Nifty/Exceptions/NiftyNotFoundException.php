<?php

namespace Nifty\Exceptions;

use Nifty\Controllers\Controller;

class NiftyNotFoundException extends Controller
{
    public function throw404()
    {
        $this->view(null, 'exceptions', '404.php');
    }
}
