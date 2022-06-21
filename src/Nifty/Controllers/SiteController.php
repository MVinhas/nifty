<?php

namespace Nifty\Controllers;

use Nifty\Models\Site;

class SiteController extends Controller
{
    public static function head()
    {
        return self::view();
    }

    public static function header()
    {
        $data = (object)[];
        $data->menu = Site::getMenu();
        return self::view($data);
    }

    public static function footer()
    {
        return self::view();
    }

    public static function index()
    {
        return (new \Nifty\Controllers\HomeController)->index();
    }
}