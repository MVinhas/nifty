<?php

namespace Nifty\Tests\Models;

use Nifty\Models\Home;
use Nifty\Tests\Utility;
use PHPUnit\Framework\TestCase;

class HomeTest extends TestCase
{
    private object $connection;
    private $home;

    protected function setUp(): void
    {
        $this->home = $this->createMock(Home::class);
        $this->connection = (new Utility())->mockConnection();
    }

    public function testGetPosts(): void
    {
        $this->home->method('getPosts')->willReturn((object)['1' => '1']);
        $this->assertIsObject($this->home->getPosts());
    }

    public function testGetPostsFalseOnEmpty(): void
    {
        $this->assertSame($this->home->getPosts(), false);
    }
}
