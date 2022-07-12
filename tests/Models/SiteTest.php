<?php

namespace Nifty\Tests\Models;

use Nifty\Models\Site;
use PHPUnit\Framework\TestCase;

class SiteTest extends TestCase
{
    private Site $site;
    protected function setUp(): void
    {
        $this->site = new Site();
    }
}
