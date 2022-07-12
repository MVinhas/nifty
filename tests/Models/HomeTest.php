<?php

namespace Nifty\Tests\Models;


use Nifty\Models\Home;
use Nifty\Tests\Utility;
use PHPUnit\Framework\TestCase;

class HomeTest extends TestCase
{
    private $connection;
    protected function setUp(): void
    {
        $this->home = $this->createMock(Home::class);
        $this->connection = (new Utility())->mockConnection();
    }

    public function testGetPosts(): void
    {
        $this->assertIsObject($this->home->method('getPosts'));
    }

    public function testGetPostsFalseOnEmpty(): void
    {
        $this->assertSame($this->home->getPosts(), false);
    }
}
