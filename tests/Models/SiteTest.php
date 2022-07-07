<?php

use Nifty\Models\Site;
use PHPUnit\Framework\TestCase;

class SiteTest extends TestCase
{
    public function testObjectIsRetrievedWhenGettingMenu()
    {
        $this->assertIsObject((new Site())->getMenu());
    }
}
