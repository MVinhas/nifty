<?php

use Nifty\Controllers\SiteController;
use Nifty\Controllers\Controller;
use Nifty\Models\Site;
use PHPUnit\Framework\TestCase;

class SiteControllerTest extends TestCase
{
    //assert that menu exists
    public function testMenuExists()
    {
        $data = (new Site())->getMenu();
        $this->assertEquals((new Controller())->view($data, 'site', 'header.php'), (new SiteController())->header());
    }
}
