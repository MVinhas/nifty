<?php

namespace Nifty\Tests\Controllers;

use Nifty\Controllers\Controller;
use PHPUnit\Framework\TestCase;
use TypeError;

class ControllerTest extends TestCase
{
    private Controller $controller;
    private string $projectRoot;

    protected function setUp(): void
    {
        $this->controller = new Controller();
        $this->projectRoot = dirname(__DIR__.'/../..', 4);
    }

    public function testThatBasePathIsProjectRootPath()
    {
        $this->assertSame($this->projectRoot, $this->controller->basepath());
    }

    public function testRootDirectoryExists()
    {
        $this->assertDirectoryExists($this->projectRoot);
    }

    public function testViewFailsIfNotExists()
    {
        $this->assertFalse($this->controller->view());
    }

    public function testRealView()
    {
        $this->assertTrue($this->controller->view(null, 'site', 'head.php'));
    }

    public function testRealViewWithData()
    {
        $this->assertTrue($this->controller->view((object)['1' => '1'], 'site', 'head.php'));
    }

    public function testRealViewWithDataButNotAnObject()
    {
        $this->expectException(TypeError::class);
        $this->controller->view(['1' => '1'], 'site', 'head.php');
    }
}
