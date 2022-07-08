<?php

use Nifty\Models\Site;
use PHPUnit\Framework\TestCase;

class SiteTest extends TestCase
{
    private bool|object $menu;
    public function setUp(): void
    {
        $this->menu = (new Site())->getMenu();
    }
}
