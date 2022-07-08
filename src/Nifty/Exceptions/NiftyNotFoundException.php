<?php

namespace Nifty\Exceptions;
use Nifty\Controllers\Controller;

class NiftyNotFoundException extends Controller
{
    public function throw404()
    {
        $this->view((object)[], 'exceptions', '404.php');
    }
}
