<?php

use Nifty\Controllers\SiteController;
use Nifty\Controllers\Controller;
use Nifty\Models\Site;
use PHPUnit\Framework\TestCase;

class SiteControllerTest extends TestCase
{
    public function testMenuExists()
    {
        $data = (object)[];
        $data->menu = (new Site())->getMenu();

        $this->assertEquals((new Controller())->view($data, 'site', 'header.php'), (new SiteController())->header());
    }
}
