<?php

namespace Nifty\Tests;

use Nifty\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    public function testRunReturnsNull(): void
    {
        $this->assertNull((new Route())->run());
    }
}
