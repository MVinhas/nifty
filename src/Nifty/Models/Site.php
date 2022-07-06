<?php

namespace Nifty\Models;

use Nifty\Db;

class Site
{
    public function getMenu()
    {
        return (new Db())->select(['*'], 'menu');
    }
}
