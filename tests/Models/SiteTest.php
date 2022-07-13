<?php

namespace Nifty\Tests\Models;

use Nifty\Models\Site;
use Nifty\Tests\Utility;
use PHPUnit\Framework\TestCase;

class SiteTest extends TestCase
{
    private object $connection;
    private $site;

    protected function setUp(): void
    {
        $this->site = $this->createMock(Site::class);
        $this->connection = (new Utility())->mockConnection();
    }

    public function testGetMenu(): void
    {
        $this->assertIsObject($this->site->method('getMenu'));
    }

    public function testGetPostsFalseOnEmpty(): void
    {
        $this->assertSame($this->site->getMenu(), false);
    }
}
