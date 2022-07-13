<?php

namespace Nifty\Tests\Models;

use Nifty\Models\About;
use Nifty\Tests\Utility;
use PHPUnit\Framework\TestCase;

class AboutTest extends TestCase
{
    private object $connection;
    private $about;

    protected function setUp(): void
    {
        $this->about = $this->createMock(About::class);
        $this->connection = (new Utility())->mockConnection();
    }


    public function testGetAboutPage(): void
    {
        $this->about->method('getAboutPage')->willReturn(false);
        $this->assertFalse($this->about->getAboutPage());
    }
}
