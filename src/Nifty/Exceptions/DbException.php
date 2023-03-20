<?php

namespace Nifty\Exceptions;

use Nifty\Controllers\Controller;

class DbException extends Controller
{
    public function throwDbNotConfigured(string $info = ''): bool
    {
        return $this->view(
            (object)[
                'host' => getenv('HOST'),
                'database' => getenv('DBNAME'),
                'username' => getenv('USERNAME'),
                'password' => getenv('PASSWORD'),
                'info' => $info
            ],
            'exceptions',
            'db-not-configured.php'
        );
    }
}
