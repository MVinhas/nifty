<?php

namespace Nifty\Models;

use Nifty\Db;

class Site
{
    public static function getMenu()
    {
        return Db::select(['*'], 'menu');
    }
}